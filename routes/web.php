<?php

use 
App\Http\Controllers\Admin\DashboardController, App\Http\Controllers\Admin\SubCategoryController,
App\Http\Controllers\Admin\OrderController,
App\Http\Controllers\Admin\ProductController,
App\Http\Controllers\Admin\CategoryController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/admin/dashboard', 'index')->name('adminDashboard');
    });

    Route::controller(CategoryController::class)->group(function (){
        Route::get('/admin/all-categories', 'index')->name('allCategories');
        Route::get('/admin/add-category', 'addCategory')->name('addCategory');
    });

    Route::controller(SubCategoryController::class)->group(function (){
        Route::get('/admin/all-subcategories', 'index')->name('allSubCategories');
        Route::get('/admin/add-subcategory', 'addSubCategory')->name('addSubCategory');
    });

    Route::controller(ProductController::class)->group(function (){
        Route::get('/admin/all-products', 'index')->name('allProducts');
        Route::get('/admin/add-product', 'addProduct')->name('addProduct');
    });

    Route::controller(OrderController::class)->group(function (){
        Route::get('/admin/all-orders', 'index')->name('allOrders');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
