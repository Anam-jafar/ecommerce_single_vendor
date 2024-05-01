@extends('admin.layouts.template')

@section('title')
Orders
@endsection()

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="py-3 mb-4"><span class="text-muted fw-light">orders/</span> orders</h4>
    <!-- Bootstrap Table with Caption -->
    <div class="card">
        <div class="table-responsive text-nowrap">
        <style>
    .table {
        width: 100%;
    }

    .order-column {
        width: 30%;
    }

    .user-info-column {
        width: 20%;
    }

    .shipping-address-column {
        width: 25%;
    }

    .total-amount-column {
        width: 10%;
    }

    .status-column {
        width: 15%;
    }

    /* Remove bullets from unordered lists */
    ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
</style>

<table class="table">
    <caption class="ms-4">List of delivered orders</caption>
    <thead>
        <tr>
            <th class="order-column">Order</th>
            <th class="user-info-column">User Info</th>
            <th class="shipping-address-column">Shipping Address</th>
            <th class="total-amount-column">Total Amount</th>
            <th class="status-column">Status</th>
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

            <td class="order-column">
                <ul>
                    <li>
                        @foreach($products as $product)
                        ({{$product->product_name}})X{{$product->product_quantity}}
                        @endforeach
                    </li>
                </ul>
            </td>
            <td class="user-info-column">
                <ul>
                    <li>{{$user->name}}</li>
                    <li>{{$user->email}}</li>
                </ul>
            </td>
            <td class="shipping-address-column">
                <ul>
                    <li>City : {{$shipping_address->city}}</li>
                    <li>Street : {{$shipping_address->street}}</li>
                    <li>Number : {{$shipping_address->phone_number}}</li>
                </ul>
            </td>
            <td class="total-amount-column">TK. {{$totalAmount = $products->sum('total_price')}}</td>
            
            <td class="status-column">
                <span class="badge bg-success">Delivered</span>
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