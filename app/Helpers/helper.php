<?php 
use App\Models\Category;
use App\Models\Cart;

function getCatgories(){
    return Category::orderBy('name','ASC')
    ->with('sub_category')
    ->orderBy('id','DESC')
    ->where('status',1)
    ->where('showHome','Yes')
    ->get();
}
function GetAddToCartTotalItems(){
    $id = auth()->id();
    $result = Cart::where('user_id', $id)
    ->with('product:id,title,price')
    ->select('id', 'quantity', 'product_id') // Select columns from the 'cart' table
    ->get();
    return $result;
}

?>