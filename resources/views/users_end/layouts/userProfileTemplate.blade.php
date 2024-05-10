@extends('users_end.layouts.template')

@section('title')
User Profile
@endsection()

@section('content')
<div class="fashion_section">
    <div id="main_slider">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-4">
                <div class="box_main">
                    <ul>
                        <li><a href="{{route('userProfile')}}">User Info</a></li>
                        <li><a href="{{route('userNotification')}}">Notification</a></li>
                        <li><a href="{{route('pendingOrders')}}">Pending Orders</a></li>
                        <li><a href="{{route('userOrders')}}">History</a></li>
                        <li><a href="{{route('logoutUser')}}">logout</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="box_main">
                    @yield('profile_content')
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection()