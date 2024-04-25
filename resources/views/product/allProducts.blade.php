@extends('admin.layouts.template')

@section('title')
Product list
@endsection()

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="py-3 mb-4"><span class="text-muted fw-light">products/</span> products_list</h4>
    <!-- Bootstrap Table with Caption -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <caption class="ms-4">
                    List of Products
                </caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Sub-Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td class="fw-medium">
                            {{$product->id}}
                        </td>
                        <td>
                            <img src="{{asset($product->product_image)}}" alt="" class="img-thumbnail img-small">
                        </td>
                        <td class="fw-medium">
                            {{$product->product_name}}
                        </td>
                        <td>
                            TK. {{$product->price}}
                        </td>
                        <td class="fw-medium">
                            {{$product->quantity}}
                        </td>
                        <td class="fw-medium">
                            {{$product->product_category_name}}
                        </td>
                        <td class="fw-medium">
                            {{$product->product_sub_category_name}}
                        </td>
                        <td>
                            @if ($product->status == 1)
                                <span class="badge bg-label-primary me-1">Active</span>
                            @else
                                <span class="badge bg-label-danger me-1">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{route('editProduct',$product->id)}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                    <a class="dropdown-item" href="{{route('deleteProduct',$product->id)}}"><i class="bx bx-trash me-1"></i> Delete</a>
                                </div>
                            </div>
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