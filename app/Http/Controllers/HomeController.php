<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $products = Product::where('deleted', '!=', 1)->latest()->get();
        return view('users_end.home', compact('products'));
    }
}
