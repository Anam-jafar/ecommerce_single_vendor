@extends('users_end.layouts.template')

@section('title')
Provide shipping address
@endsection()

@section('content')
<div class="fashion_section">
    <div id="main_slider">
        <div class="container">
        <h1 class="fashion_taital m-3">Order Confirmation</h1>
            <div class="row">
                <div class="col-8">
                    <div class="box_main">
                    <h3>Delivery Address</h3>
                    <p><b>City :</b>  {{ $shipping_info->city }}</p> 
                    <p><b>Street :</b> {{ $shipping_info->street }}</p>
                    <p><b>Address :</b> {{ $shipping_info->address}}</p>
                    <p><b>Contact Number :</b> {{ $shipping_info->phone_number }}</p>

                    </div>
                </div>
                <div class="col-4">
                    <div class="box_main">
                        <h3>Cart Details</h3>
                        <table class="table mt-3">
                            <thead>
                                <tr>
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
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->total_price }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Black line -->
                        
                        <hr style="border-top: 1px solid black;">

                        <!-- Display total price on the right side -->
                        <div class="row justify-content-end">
                            <div class="text-end">
                                <p><strong>Total Price:</strong> {{ $cart_items->sum('total_price') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <form action="" method="POST">
                    @csrf
                    <input type="submit" value="Cancel" class="btn btn-danger mr-sm-3">
                </form>
                <form action="{{route('confirmOrder')}}" method="POST">
                    @csrf
                    <input type="hidden" name="shipping_info_id" value="{{$shipping_info->id}}">
                    <input type="submit" value="Place Order" class="btn btn-warning " >
                </form>

            </div>
            

        </div>
    </div>
</div>
@endsection()