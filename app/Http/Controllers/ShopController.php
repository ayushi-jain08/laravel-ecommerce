<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\brand;
use App\Models\Product;
use App\Models\SubCategory;


class ShopController extends Controller
{
    public function index(Request $req, $categorySlug = null, $subCategorySlug = null ){
        $categorySelected = '';
        $subCategorySelected = '';
        $brandsArray = [];
        
        $categories = Category::orderBy('name','ASC')->with('sub_category')->where('status',1)->get();
        $brands = Brand::orderBy('name','ASC')->where('status',1)->get();

        $products  =  Product::where('status',1);
        // Apply products Filters here
if(!empty($categorySlug)){
    $category = Category::where('slug', $categorySlug)->first();
    $products = $products->where('category_id', $category->id);
    $categorySelected = $category->id;
}  
if(!empty($subCategorySlug)){
    $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
    $products = $products->where('sub_category_id', $subCategory->id);
    $subCategorySelected = $subCategory->id;
}  
if(!empty($req->get('brand'))){
    $brandsArray = explode(',', $req->get('brand'))  ;
    $products = $products->whereIn('brand_id', $brandsArray);
  }
  if(!empty($req->get('price_min') != "" && $req->get('price_max') != "")){
    if( $req->get('price_max') == 1000){
        $products = $products->whereBetween('price', [intval($req->get('price_min')),100000]);
    }else{
    $products = $products->whereBetween('price', [intval($req->get('price_min')),intval($req->get('price_max'))]);
  }
}
if($req->get('sort') !=  ''){
    if($req->get('sort') == 'latest'){
        $products = $products->orderBy('id','DESC');
    }else if($req->get('sort') == 'price_asc'){
        $products = $products->orderBy('price','ASC');
    }else{
        $products = $products->orderBy('price','DESC');
    }
}else{
    $products = $products->orderBy('id','DESC');
}
        $products = $products->paginate(2);
    
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;
        $data['subCategorySelected'] = $subCategorySelected;
        $data['brandsArray'] = $brandsArray;
        $data['priceMin'] = intval($req->get('price_min')) ;
        $data['priceMax'] = intval($req->get('price_max')) == 0 ? 1000 : intval($req->get('price_max')) ;
        $data['sort'] = $req->get('sort') ;
    
        return view('front.shop', $data);
    }
    public function product($slug){
        $product = Product::where('slug',$slug)->first();
       if($product == null){
        abort(404);
       }
       $relatedProducts = [];
       // fetch related products 
       if($product->related_products != ""){
         $productArray = explode(',', $product->related_products);
         $relatedProducts = Product::whereIn('id',$productArray)->get();
       }
      
       $data['product'] = $product;
       $data['relatedProducts'] = $relatedProducts;
       return view('front.product', $data);
    }
}