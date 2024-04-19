<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(){
        return view('subcategory.allSubCategories'); 
    }

    public function addSubCategory(){
        return view('subcategory.addSubCategory');
    }
}
