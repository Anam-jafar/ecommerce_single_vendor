<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\banner;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Sub_Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index() {
        $productCount = Product::where('deleted', '!=', 1)->count(); 
        $categoryCount = Category::where('deleted', '!=', 1)->count(); 
        $subcategoryCount =Sub_Category::where('deleted', '!=', 1)->count(); 
        $ongoingOrderCount = Order::where('status','!=', 0)
        ->count();
        $pendingOrderCount = Order::where('status', 0)
        ->count();
        $customerCount = User::join('role_user', 'users.id', '=', 'role_user.user_id')
        ->where('role_user.role_id', 2)
        ->count();

        $bestSellingProducts = OrderItems::select('product_id', DB::raw('count(*) as total_orders'))
        ->groupBy('product_id')
        ->orderByDesc('total_orders')
        ->take(5)
        ->get();

        $worstSellingProducts = OrderItems::select('product_id', DB::raw('count(*) as total_orders'))
        ->groupBy('product_id')
        ->orderBy('total_orders')
        ->take(5)
        ->get();

        $revenueLabels = [];
        $revenueData = [];
        
        $startDate = Carbon::now()->subDays(4)->toDateString(); // Start from 4 days ago
        
        for ($i = 0; $i < 5; $i++) {
            // Calculate the date for the current iteration
            $currentDate = Carbon::now()->subDays($i)->toDateString();
        
            // Query the total revenue for the current date
            $totalRevenue = OrderItems::whereDate('created_at', $currentDate)->sum('total_price');
        
            // Store the revenue date and revenue value in their respective arrays
            $revenueLabels[] = date('M d', strtotime($currentDate));
            $revenueData[] = $totalRevenue;
        }
        $revenueLabels = array_reverse($revenueLabels);
        $revenueData = array_reverse($revenueData);
        


        return view('admin.dashboard', compact(['productCount','categoryCount','subcategoryCount','ongoingOrderCount','pendingOrderCount','customerCount', 'bestSellingProducts', 'worstSellingProducts', 'revenueLabels', 'revenueData']));
    }

    public function customerList(){

        
        $customers = User::select('users.*', DB::raw('COUNT(orders.id) as order_count'))
            ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
            ->where('role_user.role_id', 2)
            ->groupBy('users.id')
            ->get();
        

        return view('admin.customers', compact('customers'));
    }

    public function bannerList(){
        $banners = banner::latest()->get();

        return view('admin.bannerList', compact('banners'));
    }

    public function addBanner(Request $request){
        
        if($request->isMethod('post')){
            $banner = new banner();
            $banner->name = $request->name;
            $image = $request->file('image');
            $image_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $image_name);
            $image_url = 'uploads/'.$image_name;
            $banner->image = $image_url;

            if($banner->save()){
                return redirect()->route('bannerList')->with('succes', 'Banner added successfully');
            }
        }else{
            return view('admin.addBanner');
        }
        
    }
    public function deleteBanner($id = null){
        banner::find($id)->delete();

        return redirect()->route('bannerList');
    }

    public function activateBanner($id = null){
        banner::where('status', 1)->update(['status' => 0]);
        banner::find($id)->update(['status' => 1]);
        return redirect()->route('bannerList');
    }

    public function markAllAsRead($id = null){
        Notification::where('user_id', $id)
                    ->where('viewed',0)
                    ->update(['viewed' => 1]);
        
        return redirect()->back();
    }
}
