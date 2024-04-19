<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        return view('order.allOrders'); 
    }

    public function addOrder(){
        return view('order.addOrder');
    }
}
