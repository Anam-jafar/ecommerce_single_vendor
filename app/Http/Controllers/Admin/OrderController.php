<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::whereNotIn('status', [0, 2])->get();


        return view('order.allOrders', compact(['orders']));
    }

    public function addOrder(){
        return view('order.addOrder');
    }

    public function adminPendingOrders(){
        $orders = Order::where('status', 0)
               ->get();

        return view('order.adminPendingOrders', compact(['orders']));
    }

    public function updateOrderStatus(Request $request)
    {
        $orderId = $request->input('orderId');
        $statusId = $request->input('statusId');

        // Update order status in the database
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Assuming you have a 'status' column in your orders table
        $order->status = $statusId;
        $order->save();

        return response()->json(['message' => 'Order status updated successfully']);
    }

    public function adminConfirmOrder($id = null){
        $order = Order::find($id);
        $order->status = 1;
        if($order->save()){
            return redirect()->back()->with('success', 'Order confirmed successfully');
        }
    }

    public function adminDeliveredOrders(){
        $orders = Order::where('status', 2)
        ->get();

        return view('order.adminDeliveredOrders', compact(['orders']));
    }
}
