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
            <table class="table">
                <caption class="ms-4">
                    List of orders
                </caption>
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>User Info</th>
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
                        @php
                            $statuses = [
                                1 => 'In Progress',
                                2 => 'Delivered',
                                -1 => 'Canceled'
                            ];
                            $orderStatus = $order->status;
                        @endphp

                        <td>
                            <select name="order_status" class="form-control" onchange="updateOrderStatus(this, {{$order->id}})">
                                @foreach ($statuses as $statusId => $statusName)
                                    <option value="{{ $statusId }}" {{ $orderStatus == $statusId ? 'selected' : '' }}>
                                        {{ $statusName }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
    <!-- Bootstrap Table with Caption -->
</div>


<script>
    function updateOrderStatus(selectElement, orderId) {
        var statusId = selectElement.value;

        // Get CSRF token
        var token = '{{ csrf_token() }}';

        // Make AJAX request with CSRF token
        $.ajax({
            url: '/update-order-status', // Replace this with your endpoint
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token
            },
            data: {
                orderId: orderId,
                statusId: statusId
            },
            success: function(response) {
                // Handle success response
                console.log('Order status updated successfully.');
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('Error updating order status:', error);
            }
        });
    }
</script>

@endsection()