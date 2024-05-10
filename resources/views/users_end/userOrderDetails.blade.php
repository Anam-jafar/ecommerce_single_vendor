@extends('users_end.layouts.template')

@section('title')
Provide shipping address
@endsection()

@section('content')
<div class="fashion_section">
    <div id="main_slider">
        <div class="container">
        <h1 class="fashion_taital m-3">Order Details</h1>
        <div class="col-12">
                    <div class="box_main">
                        <h3>Order Details</h3>
                        @if($order->status == 1)
                            <span class="badge badge-primary">In Progress</span>
                        @elseif($order->status == 0)
                            <span class="badge badge-warning">Pending</span>
                        @elseif($order->status == -1)
                            <span class="badge badge-danger">Canceled</span>
                        @elseif($order->status == 2)
                            <span class="badge badge-success">Delivered</span>
                        @endif
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart_items as $item)
                                <tr>
                                    @php 
                                    $product = App\Models\Product::find($item->product_id);
                                    @endphp
                                    <td><img src="{{asset($product->product_image)}}" alt="" class="img-thumbnail img-small" width="100px"></td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $item->product_quantity }}</td>
                                    <td>TK. {{ $item->total_price }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td>Delivery Charge</td>
                                    <td>Tk. 150</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Black line -->
                        
                        <hr style="border-top: 1px solid black;">

                        <!-- Display total price on the right side -->
                        <div class="row justify-content-end">
                            <div class="text-end">
                                <p><strong>Total Price:</strong> {{ $cart_items->sum('total_price')+150 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="box_main">
                    <h3>Delivery Address</h3>
                    <p><b>City :</b>  {{ $shipping_info->city }}</p> 
                    <p><b>Street :</b> {{ $shipping_info->street }}</p>
                    <p><b>Address :</b> {{ $shipping_info->address}}</p>
                    <p><b>Contact Number :</b> {{ $shipping_info->phone_number }}</p>

                    </div>
                </div>
        </div>
    </div>
</div>
@endsection()