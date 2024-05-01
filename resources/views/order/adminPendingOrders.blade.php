@extends('admin.layouts.template')

@section('title')
Pending Orders
@endsection()

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="py-3 mb-4"><span class="text-muted fw-light">orders/</span> pending_orders</h4>
    <!-- Bootstrap Table with Caption -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <style>
                    ul {
                        list-style-type: none;
                        padding: 0;
                        margin: 0;
                    }
            </style>
            <table class="table">
                <caption class="ms-4">
                    List of pending orders
                </caption>
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>User Info</th>
                        <th>Shipping Address</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        @php 
                        $shipping_address = App\Models\ShippingInfo::find($order->shipping_address_id);
                        $products = App\Models\OrderItems::where('order_id', $order->id)->latest()->get();
                        $user = App\Models\User::find($order->user_id);
                        @endphp
                        
                        <td>
                            <ul>
                                <li>
                                @foreach($products as $product)
                                    ({{$product->product_name}})X{{$product->product_quantity}}
                                @endforeach
                                </li>
                            </ul>
                            
                        </td>
                        <td>
                            <ul>
                                <li>
                                    {{$user->name}}
                                </li>
                                <li>
                                    {{$user->email}}
                                </li>
                            </ul>
                        </td>
                        <td> 
                            <ul>
                                <li>City : {{$shipping_address->city}}</li>
                                <li>Street : {{$shipping_address->street}}</li>
                                <li>Number : {{$shipping_address->phone_number}}</li>
                            </ul>
                        </td>
                        <td>
                            TK. {{$totalAmount = $products->sum('total_price')}}
                        </td>
                        <td>
                            <a href="{{route('adminConfirmOrder', $order->id)}}" class="btn btn-primary">Confirm</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Bootstrap Table with Caption -->
</div>


@endsection()