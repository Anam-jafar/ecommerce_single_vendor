<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ShippingInfo;
use App\Models\User;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ClinetController extends Controller
{
    public function categoryProducts($id=null){
        $products = Product::where('product_category_id', $id)->get();
        $category = Category::findOrFail($id);

        return view('users_end.categoryProducts', compact(['products', 'category']));
    }

    public function productDetails($id=null){
        $product = Product::findOrFail($id);
        $products = Product::where('product_sub_category_id', $product->product_sub_category_id)->get();
        
        return view('users_end.productDetails', compact(['product', 'products']));
    }

    public function addToCart(Request $request){

        $cart = Cart::where('user_id', Auth::id())
        ->where('product_id', $request->product_id)
        ->first();

        if ($cart) {
            $cart->quantity += 1;
            $cart->total_price = $cart->quantity * Product::where('id', $cart->product_id)->value('price');
        } else {
            $cart = new Cart();
            $cart->product_id = $request->product_id;
            $cart->user_id = Auth::id();
            $cart->quantity = 1;
            $cart->total_price = $cart->quantity * Product::where('id', $request->product_id)->value('price');

            
        }
        if ($cart->save()) {
            return redirect()->back()->with('success', 'Product added to cart');
        }

    }

    public function userProfile(){
        $user = auth()->user();

        return view('users_end.userProfile', compact(['user']));

    }

    public function cartView(){
        $cart_items = Cart::where('user_id', Auth::id())->get();
        return view('users_end.cartView', compact(['cart_items']));
    }

    public function removeFromCart($id=null){
        Cart::findOrFail($id)->delete();

        return  redirect()->back()->with('error', 'product removed from cart');
    }

    public function shippingAddress(Request $request){
        $user = auth()->user();

        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'phone_number' => ['required', 'string', 'regex:/^\+?[0-9]{10,13}$/'],
                'city' => 'required|string',
                'street' => 'required|string',
                'address' => 'required|string',
            ]);

            $shipping_info = new ShippingInfo();
            $shipping_info->phone_number = $validatedData[ 'phone_number' ];
            $shipping_info->city = $validatedData['city'];
            $shipping_info->street = $validatedData['street'];
            $shipping_info->address = $validatedData['address'];
            $shipping_info->instruction = $request->instruction;
            $shipping_info->user_id = $request->user_id;

            if($shipping_info->save()){
                return view('users_end.confirmOrder');
            }

        }else{
            return view('users_end.shippingAddress',  compact(['user']));
        }

        
    }
}
