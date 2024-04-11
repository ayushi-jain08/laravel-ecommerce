<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;

class ProductSubCategoryController extends Controller
{
   public function index(Request $req){
    if(!empty($req->category_id)){
        $subCategories = SubCategory::where('category_id', $req->category_id)->orderBy('name', 'ASC')->get();

        return response()->json([
            'status' => true,
            'subCategories' => $subCategories,
        ]);
    }else{
        return response()->json([
            'status' => true,
            'subCategories' => [],
        ]);
    }
    
   }
}