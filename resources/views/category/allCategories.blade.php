@extends('admin.layouts.template')

@section('title')
Category list
@endsection()

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="py-3 mb-4"><span class="text-muted fw-light">categories/</span> category_list</h4>
    <!-- Bootstrap Table with Caption -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <caption class="ms-4">
                    List of Categories
                </caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Sub Categories</th>
                        <th>Products</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            1
                        </td>
                        <td class="fw-medium">
                            Angular Project
                        </td>
                        <td>
                            <span class="fw-medium">Angular Project</span>
                        </td>
                        <td>
                            <span class="fw-medium">Angular Project</span>
                        </td>
                        <td><span class="badge bg-label-primary me-1">Active</span></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
    <!-- Bootstrap Table with Caption -->
</div>


@endsection()