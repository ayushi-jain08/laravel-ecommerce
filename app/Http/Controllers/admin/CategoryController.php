<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\TempImage;

class CategoryController extends Controller
{ 
  public function index (Request $req){
    $categories = Category::latest();
    if(!empty($req->get('keyword'))){
      $categories = $categories->where('name', 'like', '%'.$req->get('keyword').'%');
    }
    $categories = $categories->paginate(10);
    return view('admin.category.list', compact('categories'));
  }
  public function create(){
    return view('admin.category.create');
  }
  public function store(Request $req){
    $validatedData = $req->validate([
      'name' => 'required',
      'slug' => 'required|unique:categories',
      'status' => 'required',
  ]);

  $category = new Category();
  $category->name = $validatedData['name'];
  $category->slug = $validatedData['slug'];
  $category->status = $validatedData['status'];
  $category->showHome = $req->showHome;
 
    $category->save();
  
  $req->session()->flash('success', 'Category added successfully');

  return response()->json([
      'status' => true,
      'message' => 'Category added successfully',
  ]);
}
public function edit ($categoryId, Request $req) {

  $category = Category::find($categoryId);
 
  if(empty($category)){
    return redirect()->route('list');
  }
  return view('admin.category.edit', compact('category'));
}
public function update($categoryId, Request $req){
  $category = Category::find($categoryId);
 
  if(empty($category)){
    $req->session()->flash('error', 'Category not found');
    return response()->json([
      'status' => false,
      'notFound' => true,
      'message' => 'Category not found',
  ]);
  }
  $validatedData = $req->validate([
    'name' => 'required',
    'slug' => 'required|unique:categories,slug,'.$category->id.',id',
    'status' => 'required',
]);

$category->name = $validatedData['name'];
$category->slug = $validatedData['slug'];
$category->status = $validatedData['status'];
$category->showHome = $req->showHome;

  $category->save();

$req->session()->flash('success', 'Category updated successfully');

return response()->json([
    'status' => true,
    'message' => 'Category updated successfully',
]);
}

public function destroy($categoryId, Request $req){
  $category = Category::find($categoryId);

if(!$category){
  $req->session()->flash('error', 'Category not found');
  return response()->json([
    'status' => true,
    'message' => 'Category not found',
]);
}
  $category->delete();
  
  $req->session()->flash('success', 'Category deleted successfully');
  
  return response()->json([
    'status' => true,
    'message' => 'Category deleted successfully',
]);
}
}