<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\ProductSubCategoryController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\TempImagesController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// FRONTEND ROUTES
Route::get("/",[FrontController::class,'index'])->name('front.home');
Route::get("/shop/{categorySlug?}/{subCategorySlug?}",[ShopController::class,'index'])->name('front.shop');
Route::get("/product/{slug?}",[ShopController::class,'product'])->name('front.product');

Route::prefix('admin')->group(function(){
    // Accessible Without Login Pages
    Route::middleware(['admin.guest'])->group(function () {
        Route::get("/login",[AdminLoginController::class,'index'])->name('admin.login');
        Route::post("/authenticate",[AdminLoginController::class,'authenticateUser'])->name('authenticate');
    });
    Route::middleware(['admin.auth'])->group(function () {
        // Accessible Only After Login pages
        Route::get("/dashboard",[HomeController::class,'Dashboards'])->name('admin.dashboard');

          //  CATEGORY ROUTES
        Route::get("/categories/create",[CategoryController::class,'create'])->name('admin.category.create');
        Route::post("/categories",[CategoryController::class,'store'])->name('category.store');
        Route::get("/logout",[AdminLoginController::class,'Logout'])->name('admin.logout');
        Route::get("/list",[CategoryController::class,'index'])->name('list');
        Route::get("/categories/{categoryId}/edit",[CategoryController::class,'edit'])->name('category.edit');

        Route::put("/categories/{category}",[CategoryController::class,'update'])->name('category.update');
        Route::delete("/categories/{category}",[CategoryController::class,'destroy'])->name('category.delete');

        // SUB CATEGORY ROUTES
        Route::get("/sub-categories/create",[ SubCategoryController::class,'create'])->name('sub-category.create');
        Route::post("/sub-categories/create",[ SubCategoryController::class,'store'])->name('sub-category.store');
      
Route::get("/sub-categories/get",[ SubCategoryController::class,'index'])->name('sub-category.get');
        Route::get("/subcategories/{subCategoryId}/edit",[SubCategoryController::class,'edit'])->name('sub-category.edit');
        Route::put("/subcategories/{subCategoryId}",[SubCategoryController::class,'update'])->name('sub-category.update');
        Route::delete("subcategories/{subCategoryId}",[SubCategoryController::class,'destroy'])->name('sub-category.delete');
        

          // BRANDS ROUTES
          Route::get("/brand/create",[ BrandController::class,'create'])->name('brand.create');
          Route::post("/brand/store",[ BrandController::class,'store'])->name('brand.store');
          Route::get("/brand/get",[ BrandController::class,'index'])->name('brand.get');
          Route::get("/brand/{brandId}/edit",[BrandController::class,'edit'])->name('brand.edit');
          Route::put("/brand/{brandId}",[BrandController::class,'update'])->name('brand.update');
          Route::delete("brand/{brandId}",[BrandController::class,'destroy'])->name('brand.delete');
        
           // PRODUCTS ROUTES
           Route::get("/product/create",[ ProductController::class,'create'])->name('product.create');
           Route::post("/product/store",[ ProductController::class,'store'])->name('product.store');
           Route::get("/product/get",[ ProductController::class,'index'])->name('product.get');
           Route::get("/get-products",[ ProductController::class,'getProducts'])->name('get.product');
       
       
           Route::get("/product/{productId}/edit",[ProductController::class,'edit'])->name('product.edit');
           Route::post("/product/{productId}",[ProductController::class,'update'])->name('product.update');
           Route::delete("product/{id}",[ProductController::class,'destroy'])->name('product.delete');
              
           
        //temp-images-create
        Route::post("/upload-temp-image",[TempImagesController::class,'create'])->name('temp-images.create');
        
        Route::get('/getSlug',function(Request $req){
            $slug = '';
            if(!empty($req->title)){
                $slug = Str::slug($req->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug,
            ]);
        })->name('getSlug');
    });
    
    
});
    
Route::get("/product-subcategories",[ ProductSubCategoryController::class,'index'])->name('product-subcategories.get');

    // Add To Cart Routes
    Route::middleware(['admin.auth'])->group(function () {
       
      
    });
    
    Route::prefix('account')->group(function(){
        Route::middleware(['guest'])->group(function () {
// Auth Controller Api/Routes
Route::get("/register",[AuthController::class,'register'])->name('account.register');
Route::post("/post/register",[AuthController::class,'processRegistration'])->name('process.register');
Route::get("/login",[AuthController::class,'login'])->name('account.login');
Route::post("/post/login",[AuthController::class,'authenticate'])->name('process.login');
        });
        Route::middleware(['auth'])->group(function () {
            Route::post("/addtocart",[CartController::class,'AddTocart'])->name('add.cart');
            Route::get("/cart",[CartController::class,'cart'])->name('get.cart');
            Route::patch("/edit",[CartController::class,'EditCartQty'])->name('edit.cart.quantity');
            Route::delete("delete-cart-item/{id}",[CartController::class,'DeleteCartItem'])->name('delete.single.cartItem');
            Route::get("/profile",[AuthController::class,'Profile'])->name('user.profile');
            Route::get("/logout",[AuthController::class,'Logout'])->name('account.logout');
            Route::get("/checkout",[CartController::class,'CheckOut'])->name('account.checkout');
            Route::post("/process-checkout",[CartController::class,'processCheckOut'])->name('front.processCheckout');
            Route::get("/thankyou/{orderId}",[CartController::class,'Thankyou'])->name('thankyou');
            Route::get("/my-order",[CartController::class,'orders'])->name('account.order');
            Route::get("/order-details/{orderId}",[CartController::class,'orderDetails'])->name('account.orderdetails');
          
        });
    
        });

    
    
  