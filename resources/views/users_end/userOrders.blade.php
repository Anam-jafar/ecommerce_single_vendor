@extends('users_end.layouts.userProfileTemplate')

@section('profile_content')

<div class="product-info">
<h3 class="m-3">Orders</h3>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Order</th>
                <th>Shipping Address</th>
                <th>Total Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            
            <tr>
                @php 
                $shipping_address = App\Models\ShippingInfo::find($order->shipping_address_id);
                $products = App\Models\OrderItems::where('order_id', $order->id)->latest()->get();
                @endphp
                
                <td>
                    <a href="{{route('userOrderDetails', $order->id)}}">
                    <ul>
                        <li>
                        @foreach($products as $product)
                            ({{$product->product_name}})X{{$product->product_quantity}}
                        @endforeach
                        </li>
                    </ul>
                    </a>
                    
                </td>
                <td> 
                    <ul>
                        <li>City : {{$shipping_address->city}}</li>
                        <li>Street : {{$shipping_address->street}}</li>
                        <li>Number : {{$shipping_address->phone_number}}</li>
                    </ul>
                </td>
                <td>
                    {{$totalAmount = $products->sum('total_price')}}
                </td>
                <td>
                @if($order->status == 2)
                    <span class="badge badge-success">delivered</span>
                @elseif($order->status == 1)
                    <span class="badge badge-primary">in Progress</span>
                @elseif($order->status == -1)
                    <span class="badge badge-danger">canceled</span>
                @endif

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection()