@extends('admin.layouts.template')

@section('title')
Banner list
@endsection()

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h4 class="py-3 mb-4"><span class="text-muted fw-light">banner/</span> banners_list</h4>
    <!-- Bootstrap Table with Caption -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <caption class="ms-4">
                    List of Banners
                </caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($banners as $banner)
                    <tr>
                        <td class="fw-medium">
                            {{$banner->id}}
                        </td>
                        <td>
                            <img src="{{asset($banner->image)}}" alt="" class="img-thumbnail img-small" width="100px">
                        </td>
                        <td class="fw-medium">
                            {{$banner->name}}
                        </td>
                        <td>
                            @if ($banner->status == 1)
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
                                    <a class="dropdown-item" href="{{route('activateBanner',$banner->id)}}"><i class="bx bx-edit-alt me-1"></i> Activate</a>
                                    <a class="dropdown-item" href="{{route('deleteBanner',$banner->id)}}"><i class="bx bx-trash me-1"></i> Delete</a>
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