@extends('admin.layouts.template')

@section('title')
Category list
@endsection()

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="py-3 mb-4"><span class="text-muted fw-light">customers</h4>
    <!-- Bootstrap Table with Caption -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <caption class="ms-4">
                    List of Customers
                </caption>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Number of Orders</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                    <tr>
                        <td class="fw-medium">
                            {{$customer->name}}
                        </td>
                        <td class="fw-medium">
                            {{$customer->email}}
                        </td>
                        <td class="fw-medium">
                            {{$customer->order_count}}
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