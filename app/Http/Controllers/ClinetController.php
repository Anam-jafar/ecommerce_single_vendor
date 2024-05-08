<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItems;
use App\Models\ShippingInfo;
use App\Models\Sub_Category;
use App\Models\User;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ClinetController extends Controller
{
    public function categoryProducts($id=null){
        $products = Product::where('product_category_id', $id)->get();
        $category = Category::findOrFail($id);
        $subcategories = Sub_Category::where('category_id',$id)->get();

        return view('users_end.categoryProducts', compact(['products', 'category', 'subcategories']));
    }

    public function subCategoryProducts($id = null){
        $products = Product::where('product_sub_category_id', $id)->get();
        $subcategory = Sub_Category::findOrFail($id);
        $subcategories = Sub_Category::where('category_id',$subcategory->category_id)->get();
        return view('users_end.subCategoryProducts', compact(['products', 'subcategories', 'subcategory']));
    }

    public function productDetails($id=null){
        $product = Product::findOrFail($id);
        $products = Product::where('product_sub_category_id', $product->product_sub_category_id)->get();
        
        return view('users_end.productDetails', compact(['product', 'products']));
    }

    public function addToCart($id=null){

        $cart = Cart::where('user_id', Auth::id())
        ->where('product_id', $id)
        ->first();

        if ($cart) {
            $cart->quantity += 1;
            $cart->total_price = $cart->quantity * Product::where('id', $cart->product_id)->value('price');
        } else {
            $cart = new Cart();
            $cart->product_id = $id;
            $cart->user_id = Auth::id();
            $cart->quantity = 1;
            $cart->total_price = $cart->quantity * Product::where('id', $id)->value('price');

            
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
                $cart_items = Cart::where('user_id', Auth::id())->get();

                return view('users_end.confirmOrder', compact(['shipping_info', 'cart_items']));
            }

        }else{
            return view('users_end.shippingAddress',  compact(['user']));
        } 
    }

    public function existingShippingInfo(){
        $shippingInfos = ShippingInfo::where('user_id', Auth::id())->get();

        return view('users_end.existingShippingInfo', compact('shippingInfos'));
    }

    public function useExistingShippingInfo($id = null){
        $cart_items = Cart::where('user_id', Auth::id())->get();
        $shipping_info = ShippingInfo::find($id);

        return view('users_end.confirmOrder', compact(['shipping_info', 'cart_items']));
    }

    public function confirmOrder(Request $request){
        $user = auth()->user();

        if ($request->isMethod('post')){

        $order = new Order();

        $order->user_id = Auth::id();
        $order->shipping_address_id = $request->shipping_info_id;
        $order->status = 0;
        
        $cart_items = Cart::where('user_id', Auth::id())->get();

        if($order->save()){
            foreach($cart_items as $items){
                $order_items = new OrderItems();
                $order_items->order_id= $order->id;
                $order_items->product_id = $items->product_id;
                $order_items->product_name = Product::where('id', $items->product_id)->value('product_name');
                $order_items->product_quantity = $items->quantity;
                $order_items->total_price = $items->total_price+150;
                $order_items->save();
            }
            Cart::where('user_id', Auth::id())->delete();
            $notification = new Notification();
            $notification->user_id = 1;
            $notification->notification = 'New pending order';
            $notification->order_id= $order->id;
            $notification->save();
            return redirect()->route('pendingOrders');
            
        }
    }
    }

    public function pendingOrders(){
        $orders = Order::where('status', 0)
               ->where('user_id', Auth::id())
               ->latest()
               ->get();

        return view('users_end.pendingOrders', compact(['orders']));
        
    }

    public function bestSeller(){
        $products = OrderItems::select('product_id', DB::raw('count(*) as total_orders'))
        ->groupBy('product_id')
        ->orderByDesc('total_orders')
        ->take(6)
        ->get();

        return view('users_end.bestSeller', compact('products'));
    }

    public function newRelease(){


        $threeDaysAgo = Carbon::now()->subDays(3)->toDateString();

        $products = Product::whereDate('created_at', '>=', $threeDaysAgo)
                        ->get();

        return view('users_end.newRelease', compact('products'));
    }

    public function customerService(){

        return view('users_end.customerService');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('product_name', 'like', "$query%")->get();

        return response()->json($products);
    }

    public function userOrders(){
        $orders = Order::where('status', '!=', 0)
               ->where('user_id', Auth::id())
               ->latest()
               ->get();

        return view('users_end.userOrders', compact(['orders']));
        
    }

    public function updateCartItemQuantity(Request $request)
    {
        $cartItem = Cart::where('id', $request->cart_id)
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->total_price = $cartItem->quantity * Product::where('id', $cartItem->product_id)->value('price');
            $cartItem->save();

            return response()->json($cartItem);
        }

        return response()->json(['success' => false, 'message' => 'Cart item not found.']);
    }

    public function userNotification(){
        $notifications = Notification::where('user_id', Auth::id())->where('viewed', 0)->latest()->get();

        return view('users_end.userNotification', compact(['notifications']));
    }

    public function viewNotification($id= null){
        $notification = Notification::find($id);
        $notification->viewed = 1;
        $notification->save();

        $order = Order::find($notification->order_id);
        $cart_items = OrderItems::where('order_id', $order->id)->get();
    
        $shipping_info = ShippingInfo::find($order->shipping_address_id);

        return view('users_end.userOrderDetails', compact(['shipping_info', 'cart_items', 'order']));
    }
    public function markAsReadNotification($id=null){
        $notification = Notification::find($id);
        $notification->viewed = 1;
        $notification->save();
        return redirect()->back(); 
    }
    public function markAllAsReadNotification(){
        Notification::where('user_id', Auth::id())
        ->where('viewed',0)
        ->update(['viewed' => 1]);
        return redirect()->back();
    }

    public function userOrderDetails($id = null){
        $order = Order::find($id);
        $cart_items = OrderItems::where('order_id', $id)->get();
    
        $shipping_info = ShippingInfo::find($order->shipping_address_id);

        return view('users_end.userOrderDetails', compact(['shipping_info', 'cart_items', 'order']));
    }
}
