<?php

use 
App\Http\Controllers\Admin\DashboardController, App\Http\Controllers\Admin\SubCategoryController,
App\Http\Controllers\Admin\OrderController,
App\Http\Controllers\Admin\ProductController,
App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ClinetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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


Route::controller(HomeController::class)->group(function (){
    Route::get('/', 'index')->name('home');
    Route::get('/logout-user', 'logoutUser')->name('logoutUser');
});

Route::controller(ClinetController::class)->group(function (){

    Route::get('/category/{id}', 'categoryProducts')->name('categoryProducts');
    Route::get('/product-detail/{id}', 'productDetails')->name('productDetails');
    Route::get('/best-seller', 'bestSeller')->name('bestSeller');
    Route::get('/new-release', 'newRelease')->name('newRelease');
    Route::get('/customer-service', 'customerService')->name('customerService');
    Route::get('/search', 'search')->name('search');
});

Route::middleware(['auth', 'role:user'])->group(function() {
    
    Route::controller(ClinetController::class)->group(function (){

        Route::get('/user-profile', 'userProfile')->name('userProfile');
        Route::post('/add-to-cart', 'addToCart')->name('addToCart');
        Route::get('/cart-view', 'cartView')->name('cartView');
        Route::get('/remove-from-cart/{id}', 'removeFromCart')->name('removeFromCart');
        Route::match(['get', 'post'], '/shipping-address', 'shippingAddress')->name('shippingAddress');
        Route::match(['get', 'post'], '/confirm-order', 'confirmOrder')->name('confirmOrder');
        Route::get('/pending-orders', 'pendingOrders')->name('pendingOrders');
        Route::get('/user-orders', 'userOrders')->name('userOrders');
        Route::post('/update-cart-item-quantity', 'updateCartItemQuantity')->name('updateCartItemQuantity');

    });
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/admin/dashboard', 'index')->name('adminDashboard');
        Route::get('/admin/customer-list', 'customerList')->name('customerList');

    });

    Route::controller(CategoryController::class)->group(function (){
        Route::get('/admin/all-categories', 'index')->name('allCategories');
        Route::match(['get', 'post'],'/admin/add-category', 'addCategory')->name('addCategory');
        Route::match(['get','put', 'post'], '/admin/edit-category/{id}', 'editCategory')->name('editCategory');
        Route::get('/admin/delete-category/{id}', 'deleteCategory')->name('deleteCategory');
        Route::post('/get-subcategories', 'getSubcategories')->name('getSubcategories');

    });

    Route::controller(SubCategoryController::class)->group(function (){
        Route::get('/admin/all-subcategories', 'index')->name('allSubCategories');
        Route::match(['get', 'post'],'/admin/add-subcategory', 'addSubCategory')->name('addSubCategory');
        Route::match(['get','put', 'post'], '/admin/edit-subcategory/{id}', 'editSubCategory')->name('editSubCategory');
        Route::get('/admin/delete-subcategory/{id}', 'deleteSubCategory')->name('deleteSubCategory');
    });

    Route::controller(ProductController::class)->group(function (){
        Route::get('/admin/all-products', 'index')->name('allProducts');
        Route::match(['get', 'post'],'/admin/add-product', 'addProduct')->name('addProduct');
        Route::match(['get','put', 'post'], '/admin/edit-product/{id}', 'editProduct')->name('editProduct');
        Route::get('/admin/delete-product/{id}', 'deleteProduct')->name('deleteProduct');
    });

    Route::controller(OrderController::class)->group(function (){
        Route::get('/admin/all-orders', 'index')->name('allOrders');
        Route::get('/admin/pending-orders', 'adminPendingOrders')->name('adminPendingOrders');
        Route::get('/admin/delivered-orders', 'adminDeliveredOrders')->name('adminDeliveredOrders');
        Route::post('/update-order-status', 'updateOrderStatus')->name('updateOrderStatus');
        Route::get('admin/confirm-order/{id}', 'adminConfirmOrder')->name('adminConfirmOrder');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
