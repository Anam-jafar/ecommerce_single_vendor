@extends('users_end.layouts.userProfileTemplate')

@section('profile_content')

<div class="product-info">
    <dl>
        <dt>Name</dt>
        <dd>{{$user->name}}</dd>
        
        <dt>Email</dt>
        <dd>{{$user->email}}</dd>
        
        <dt>Account Created At</dt>
        <dd>{{$user->created_at}}</dd>
        
    </dl>
</div>


@endsection()