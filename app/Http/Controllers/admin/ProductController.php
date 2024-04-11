<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\brand;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
public function create(){
    $data = [];
    $categories = Category::orderBy('name', 'ASC')->get();
    $brand = Brand::orderBy('name', 'ASC')->get();
    $data['categories'] = $categories;
    $data['brand'] = $brand;
    return view('admin.products.create', $data);
    
}
public function store (Request $req){
    $rules = ['title' => 'required',
    'slug' => 'required|unique:products',
    'image' => 'required|mimes:png,jpg,jpeg,gif|max:10000',
    'images_array' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    'price' => 'required|nullable',
    'sku' => 'required|unique:products',
    'track_qty' => 'required|in:Yes,No',
    'category' => 'required|numeric',
    'feature' => 'required|in:Yes,No',];
   
    if(!empty($req->track_qty) && $req->track_qty == 'Yes'){
        $rules['qty'] = 'required|numeric';
    }
    
    $validatedData = $req->validate($rules);
    $images = [];

    if ($req->hasFile('images')) {
        foreach ($req->file('images') as $image) {
            $imageName = time() . '_' . $image->getClientOriginalName();
          $imagePath =  $image->storeAs('images_array', $imageName,'public');
          $images[] = $imagePath;
        }
    }
    $file = $req->file('image');
    $fileName = time(). '.'. $file->getClientOriginalName();

    $filePath = $file->storeAs('images', $fileName, 'public');

    $product = new Product();
  $product->title = $validatedData['title'];
  $product->slug = $validatedData['slug'];
  $product->description = $req->description;
  $product->image = $filePath;
  $product->images_array= json_encode($images);
  $product->status =  $req->status;
  $product->price = $validatedData['price'];
  $product->compare_price = $req->compare_price;
  $product->sku = $validatedData['sku'];
  $product->barcode = $req->barcode;
  $product->track_qty = $validatedData['track_qty'];
  $product->qty =$req->qty;
  $product->category_id = $validatedData['category'];
  $product->sub_category_id = $req->sub_category;
  $product->brand_id = $req->brand;
  $product->is_featured = $validatedData['feature'];
  $product->short_description = $req->short_description;
  $product->shipping_returns = $req->shipping_return;
  $product->is_featured = $validatedData['feature'];

  $product->save();

  return response()->json([
    'status' => true,
    'message' => 'Product added successfully',
]);
}

public function index(Request $req)
{
    try {
        $query = Product::query(); // Start with the query builder instance

        if ($req->get('keyword') !== "") {
            $query->where('title', 'like', '%' . $req->keyword . '%');
        }

        $products = $query->with('subcategory.category')->latest('id')->paginate();

        $data['products'] = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'title' => $product->title,
                'categoryName' => $data->subcategory->category->name,
                'subcatName' => $product->subcategory->name,
            ];
        });

        return view('admin.products.list', compact('products'));
    } catch (\Throwable $th) {
        return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
    }
}

public function edit ($productId, Request $req){
    $product = Product::find($productId);
    
    $data = [];
    if(empty($product)){
        $req->session()->flash('error', 'Product not found');
        return redirect()->route('Product.get');
      }
    
$subCategories = subCategory::where('category_id',$product->category_id)->get();
      $categories = Category::orderBy('name', 'ASC')->select('id', 'name')->get();
      $brand = Brand::orderBy('name', 'ASC')->select('id', 'name')->get();

      $relatedProducts = [];
      // fetch related products 
      if($product->related_products != ""){
        $productArray = explode(',', $product->related_products);
        $relatedProducts = Product::whereIn('id',$productArray)->get();
      }
     
      $data['subCategories'] = $subCategories;
      $data['product'] = $product;
      $data['brand'] = $brand;
      $data['categories'] = $categories;
      $data['relatedProducts'] = $relatedProducts;
      
      return view('admin.products.edit', $data);
}  
public function getProducts (Request $req){
    $tempProduct = [];
    if($req->term != ""){
        $products = Product::where('title', 'like', '%'. $req->term . '%')->get();

        if($products != null){
        foreach($products as $product){
           $tempProduct[] = array('id' => $product->id, 'text' => $product->title); 
        }
        }
    }
    return response()->json([
        'tags' => $tempProduct,
        'status' => true,
    ]);
    print_r($tempProduct);    
}

}