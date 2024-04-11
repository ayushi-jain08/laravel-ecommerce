<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\brand;

class BrandController extends Controller
{
    public function create(){
        return view('admin.brands.create');
    }
    public function store(Request $req){
        $validatedData = $req->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands',
            'status' => 'required',
        ]);
        $brand = new Brand();
        $brand->name = $validatedData['name'];
        $brand->slug = $validatedData['slug'];
        $brand->status = $validatedData['status'];
    
        $brand->save();
      
        $req->session()->flash('success', 'Brand added successfully');
      
        return response()->json([
            'status' => true,
            'message' => 'Brand added successfully',
        ]);
    }
   
    public function index (Request $req){
        $brand = Brand::latest();
        if(!empty($req->get('keyword'))){
          $brand = $brand->where('name', 'like', '%'.$req->get('keyword').'%');
        }
        $brand = $brand->paginate(10);
        return view('admin.brands.list', compact('brand'));
      }
   

      public function edit ($brandId, Request $req) {

        $brand = Brand::find($brandId);
       
        if(empty($brand)){
          return redirect()->route('brand.get');
        }
        return view('admin.brands.edit', compact('brand'));
      }

  
      public function update($brandId, Request $req){
        $brand = Brand::find($brandId);
       
        if(empty($brand)){
          $req->session()->flash('error', 'Category not found');
          return response()->json([
            'status' => false,
            'notFound' => true,
            'message' => 'Category not found',
        ]);
        }
        $validatedData = $req->validate([
          'name' => 'required',
          'slug' => 'required|unique:brands,slug,'.$brand->id.',id',
          'status' => 'required',
      ]);
      $brand->name = $validatedData['name'];
$brand->slug = $validatedData['slug'];
$brand->status = $validatedData['status'];

  $brand->save();



return response()->json([
    'status' => true,
    'message' => 'Brand updated successfully',
]);
    }
    public function destroy($brandId, Request $req){
        $brand = Brand::find($brandId);
      
      if(!$brand){
        $req->session()->flash('error', 'Brand not found');
        return response()->json([
          'status' => true,
          'message' => 'Brand not found',
      ]);
      }
        $brand->delete();
        
        $req->session()->flash('success', 'Brand deleted successfully');
        
        return response()->json([
          'status' => true,
          'message' => 'Brand deleted successfully',
      ]);
      }
}