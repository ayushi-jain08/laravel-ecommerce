<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index(Request $req){
        $subCategories = SubCategory::select('sub_categories.*','categories.name as categoryName')->
        latest('sub_categories.id')
        ->leftJoin('categories', 'categories.id', 'sub_categories.category_id');
        
        if(!empty($req->get('keyword'))){
          $subCategories = $subCategories->where('sub_categories.name', 'like', '%'.$req->get('keyword').'%');
          $subCategories = $subCategories->orWhere('categories.name', 'like', '%'.$req->get('keyword').'%');
        }
        $subCategories = $subCategories->paginate(10);
        return view('admin.sub_category.list', compact('subCategories'));
    }
 public function create(){
    $categories = Category::orderBy('name','ASC')->get();
    $data['categories'] = $categories;
 
    return view('admin.sub_category.create', $data);
 }
 public function store(Request $req){
    $validatedData = $req->validate([
        'name' => 'required',
        'slug' => 'required|unique:sub_categories',
        'category' => 'required',
        'status' => 'required',
    ]);
    $subCategory = new SubCategory();
    $subCategory->name = $validatedData['name'];
    $subCategory->slug = $validatedData['slug'];
    $subCategory->category_id = $validatedData['category'];
    $subCategory->status = $validatedData['status'];
    $subCategory->showHome = $req->showHome;

    $subCategory->save();
  
    $req->session()->flash('success', 'SubCategory added successfully');
  
    return response()->json([
        'status' => true,
        'message' => 'SubCategory added successfully',
    ]);
 }

 public function edit( $subCategoryId, Request $req){
    $subcategory = SubCategory::find($subCategoryId);
    if(empty($subcategory)){
        $req->session()->flash('error', 'Category not found');
        return redirect()->route('sub-category.get');
      }
      $categories = Category::orderBy('name', 'ASC')->select('id', 'name')->get();

      $data['categories'] = $categories;
      $data['subcategory'] = $subcategory;  
     
      return view('admin.sub_category.edit', $data);
 }
 public function update($subCategoryId, Request $req){
    $subcategory = SubCategory::find($subCategoryId);

    if(empty($subcategory)){
        $req->session()->flash('error', 'Category not found');
        return response()->json([
          'status' => false,
          'notFound' => true,
          'message' => 'Category not found',
      ]);
      }
    
      $validatedData = $req->validate([
        'name' => 'required',
        'slug' => 'required|unique:sub_categories,slug,'.$subcategory->id.',id',
        'category' => 'required',
        'status' => 'required',
    ]);
    $subcategory->name = $validatedData['name'];
$subcategory->slug = $validatedData['slug'];
$subcategory->status = $validatedData['status'];
$subCategory->showHome = $req->showHome;
$subcategory->category_id = $validatedData['category'];

  $subcategory->save();

$req->session()->flash('success', 'SubCategory updated successfully');

return response()->json([
    'status' => true,
    'message' => 'SubCategory updated successfully',
]);
 }
 public function destroy($subCategoryId, Request $req){
  $subcategory = SubCategory::find($subCategoryId);

  if(!$subcategory){
    $req->session()->flash('error', 'Category not found');
    return response()->json([
      'status' => true,
      'message' => 'Category not found',
  ]);
  }
    $subcategory->delete();
    
    $req->session()->flash('success', 'Category deleted successfully');
    
    return response()->json([
      'status' => true,
      'message' => 'Category deleted successfully',
  ]);
 }
}