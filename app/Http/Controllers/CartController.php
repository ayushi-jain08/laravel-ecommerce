<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Country;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart(Request $req){
        $id = auth()->id();
        $cartItems = Cart::where('user_id', $id)->with('product')->get();
        if (!$cartItems) {
            return response()->json(['status' => false, 'message' => 'Product not found.'], 404);
        }
        $total = 0;

        foreach ($cartItems as $cartItem) {
            // Calculate the total for each item (price * quantity)
            $itemTotal = $cartItem->product->price * $cartItem->quantity;
    
            // Add the item total to the overall total
            $total += $itemTotal;
    
            // Add the item total to the cart item as a new attribute (optional)
            $cartItem->itemTotal = $itemTotal;
            
        }
        $data['cartItems'] = $cartItems;
        $data['total'] = $total;
      
        return view('front.cart.cart', $data);
    }
    public function AddToCart(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
        ]);
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found.'], 404);
        }
        $cartItem = Cart::where([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ])->first();
        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity,
            ]);
        } else {
            $cartItem = Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }
        return response()->json(['status' => true, 'message' => 'Item added to cart successfully', 'cart' => $cartItem]);
    }
// Edit Cart Quantity
public function EditCartQty(Request $request){
    $cartId = $request->cartItemId;
    $newQuantity = $request->newQuantity;
   try {
    $cart = Cart::findOrFail($cartId);
    // Update the quantity
    $cart->quantity = $newQuantity;
    $cart->save();

    // Return a success response
    return response()->json(['status' => true, 'message' => 'Cart quantity updated successfully']);
   } catch (\Throwable $th) {
    return response()->json(['status' => false, 'message' => 'Error updating cart quantity', 'error' => $th->getMessage()]);
   }
    
}
public function DeleteCartItem($id) {
    try {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json(['status' => false, 'message' => 'CartItem not found.'], 404);
        }

        $cart->delete();

        return response()->json(['status' => true, 'message' => 'Cart item deleted successfully']);
    } catch (\Throwable $th) {
        return response()->json(['status' => false, 'message' => 'Error deleting cart product', 'error' => $th->getMessage()]);
    }
}
public function CheckOut(){

    // If cart is empty redirect to cart page
    $result['cart_data'] = GetAddToCartTotalItems();
    if(isset($result['cart_data'][0])){
        session()->forget('url.intended');

        $userId = Auth::user()->id;
        $customerAddress = CustomerAddress::where('user_id', $userId)->first();;
        $countries = Country::orderBy('name', 'ASC')->get();
    $result['countries'] = $countries;
    $result['customerAddress'] = $customerAddress ;
 
        return view('front.checkout',$result);
        
    }
    session()->flash('error', 'Add Items in Cart to Checkout');
        return redirect()->route('get.cart');
  
}
public function processCheckOut(Request $request){
    $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email',
        'country_id' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'zip' => 'required',
        'mobile' => 'required'
    ]);
    $user = Auth::user();
    
    CustomerAddress::updateOrCreate(
        ['user_id'=> $user->id],
        ['first_name'=> $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'country_id' => $request->country_id,
        'address'=> $request->address,
         'city' => $request->city,
         'state' => $request->state ,
         'zip' => $request->zip,
         'mobile' => $request->mobile,
         'appartment' => $request->appartment, 
        ]
    );

    // Store data in orders table
    if($request->payment_method == "cod"){

        $shipping = 20;
        $discount = 0;
        $grandTotal = $request->total_price + $shipping;
        
        $order = new Order;
        $order->subtotal = $request->total_price;
        $order->shipping = $shipping;
        $order->grand_total = $grandTotal;
        $order->payment_status = 'not paid';
        $order->status = 'pending';
        $order->user_id = $user->id;
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->email = $request->email;
        $order->mobile = $request->mobile;
        $order->address = $request->address;
        $order->appartment = $request->appartment;
        $order->state = $request->state;
        $order->city = $request->city;
        $order->zip = $request->state;
        $order->notes = $request->notes;
        $order->country_id = $request->country_id;

        $order->save();

        // 4 Store Order Items in the Order Item Table
      
        $cartItems = GetAddToCartTotalItems();
        foreach ($cartItems as $item) {
            $orderItem = new OrderItem;
            $orderItem->product_id = $item->product->id;  // Assuming you have a product relationship
            $orderItem->order_id = $order->id;
            $orderItem->name = $item->product->title;  // Assuming 'name' is the attribute in your Product model
            $orderItem->price = $item->product->price;
            $orderItem->qty = $item->quantity;
            $orderItem->total = $item->product->price * $item->quantity;
            $orderItem->save();
        }
        
        session()->flash('success', 'You have successfully palced your order');
        
        $this->clearUserCart($user->id);
        return response()->json(['status' => true, 'message' => 'Order saved successfully', 'orderId' => $order->id]);
    }
}
public function clearUserCart($userId) {
    Cart::where('user_id', $userId)->delete();
}
public function Thankyou($orderId){
    return view('front.Thankyou', ['orderId' => $orderId]);
}
public function orders(){
    $userId = Auth::user()->id;

    $order = Order::where('user_id',$userId)->orderBy('created_at', 'DESC')->get();
    $data['orders'] = $order;
    return view('front.account.order', $data);
}
public function orderDetails($orderId, Request $req){
    $data = [];
    $userId = Auth::user()->id;
    $order = Order::where('user_id', $userId)->where('id', $orderId)->first();
    $orderItem = OrderItem::with('product')->where('order_id', $orderId)->get();
    $data['order'] = $order;
    $data['orderItem'] = $orderItem;
    return view('front.account.order-detail', $data);
}
}