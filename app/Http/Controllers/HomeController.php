<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $products = Product::where('deleted', '!=', 1)->latest()->get();
        $banner = banner::where('status', 1)->first();
        return view('users_end.home', compact(['products', 'banner']));
    }

    public function logoutUser(){
        Auth::logout();
        return redirect()->route('home');
    }
}
