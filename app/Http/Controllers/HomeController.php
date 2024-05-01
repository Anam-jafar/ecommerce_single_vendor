<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $products = Product::where('deleted', '!=', 1)->latest()->get();
        return view('users_end.home', compact('products'));
    }

    public function logoutUser(){
        Auth::logout();
        return redirect()->route('home');
    }
}
