@extends('users_end.layouts.template')

@section('title')
Cart view
@endsection()

@section('content')
<div class="fashion_section">
    <div id="main_slider">
    <div class="container">
    <h1 class="fashion_taital m-3">Cart Details</h1>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart_items as $item)
            <tr>
                @php 
                $product = App\Models\Product::find($item->product_id);
                @endphp
                <td><img src="{{ asset($product->product_image) }}" alt="" width="100"></td>
                <td>{{ $product->product_name }}</td>
                <td>
                    <input type="number" class="quantity-input" value="{{ $item->quantity }}" data-cart-id="{{ $item->id }}" data-product-id="{{ $item->product_id }}" style="border: none;width: 60px;">
                </td>

                <td id="total_price">{{ $item->total_price }}</td>
                <td>
                    <a class="btn btn-danger" href="{{route('removeFromCart',$item->id)}}"><i class="bx bx-trash me-1"></i> Remove</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
    $(document).ready(function(){
        $('.quantity-input').on('input', function(){
            var newQuantity = $(this).val();
            var cartId = $(this).data('cart-id');
            var productId = $(this).data('product-id');

            $.ajax({
                url: "{{ route('updateCartItemQuantity') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cart_id: cartId,
                    product_id: productId,
                    quantity: newQuantity
                },
                success: function(response){
                    $('#total_price').html(response.total_price);
                    $('#total_price_').html(response.total_price);
                },
                error: function(xhr){
                    // Handle error response if needed
                    console.error('Error updating quantity:', xhr.responseText);
                }
            });
        });
    });
</script>


    <!-- Black line -->
    

    @if($cart_items->sum('total_price') > 0)
        <hr style="border-top: 1px solid black;">

        <!-- Display total price on the right side -->
        <div class="row justify-content-end">
            <div class="col-md-4 text-end">
                <p><strong>Total Price:</strong> <span id="total_price_">{{ $cart_items->sum('total_price') }}</span></p>
            </div>
        </div>
        <a href="{{ route('shippingAddress')}}" class="btn btn-warning col-md-4 checkout-btn">Proceed to checkout</a>
    @else
        <p>No items in the cart</p>
    @endif

    
</div>

    </div>
</div>

@endsection()