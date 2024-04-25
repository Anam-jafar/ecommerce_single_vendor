@extends('admin.layouts.template')

@section('title')
Sub-Category list
@endsection()

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="py-3 mb-4"><span class="text-muted fw-light">categories/</span> sub_category_list</h4>
    <!-- Bootstrap Table with Caption -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <caption class="ms-4">
                    List of Sub-Categories
                </caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Products</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($subcategories as $subcategory)
                    <tr>
                        <td class="fw-medium">
                            {{$subcategory->id}}
                        </td>
                        <td class="fw-medium">
                            {{$subcategory->sub_category_name}}
                        </td>
                        <td class="fw-medium">
                            {{$subcategory->category_name}}
                        </td>
                        <td class="fw-medium">
                            {{$subcategory->product_count}}
                        </td>
                        <td>
                            @if ($subcategory->status == 1)
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
                                    <a class="dropdown-item" href="{{route('editSubCategory',$subcategory->id)}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                    <a class="dropdown-item" href="{{route('deleteSubCategory',$subcategory->id)}}"><i class="bx bx-trash me-1"></i> Delete</a>
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