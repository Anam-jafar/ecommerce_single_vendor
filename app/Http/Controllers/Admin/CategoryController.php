<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        return view('category.allCategories'); 
    }

    public function addCategory(){
        return view('category.addCategory');
    }
}
