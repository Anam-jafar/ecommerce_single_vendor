<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::whereNotIn('status', [0, 2])->latest()->get();


        return view('order.allOrders', compact(['orders']));
    }

    public function addOrder(){
        return view('order.addOrder');
    }

    public function adminPendingOrders(){
        $orders = Order::where('status', 0)
                ->latest()
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

        $notification = new Notification();
        $notification->user_id = $order->user_id;
        $notification->order_id = $order->id;
        if($statusId==2){
            $notification->notification = 'Your order with '. $order->id.' has been delivered';
        }
        elseif($statusId==-1){
            $notification->notification = 'Your Order with '. $order->id.'has been cancelled';
        }

        $notification->save();

        return response()->json(['message' => 'Order status updated successfully']);
    }

    public function adminConfirmOrder($id = null){
        $order = Order::find($id);
        $order->status = 1;
        if($order->save()){
            $products = OrderItems::where('order_id', $id)->get();
            foreach($products as $product){
                Product::find($product->product_id)->decrement('quantity', $product->product_quantity);
            }
            $notification = new Notification();
            $notification->user_id = $order->user_id;
            $notification->notification = 'Your order with id'. $order->id.'has been confirmed';
            $notification->order_id = $order->id;
            $notification->save();
            return redirect()->back()->with('success', 'Order confirmed successfully');
        }
    }

    public function adminDeliveredOrders(){
        $orders = Order::where('status', 2)
        ->latest()
        ->get();


        return view('order.adminDeliveredOrders', compact(['orders']));
    }
}
