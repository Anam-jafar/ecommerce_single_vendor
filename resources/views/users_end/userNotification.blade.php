@extends('users_end.layouts.userProfileTemplate')

@section('profile_content')

<div class="product-info">
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Notification</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notifications as $notification)
            <tr>
                <td>
                    <a href="{{route('viewNotification', $notification->id)}}">
                    {{ $notification->notification }}
                    </a>
                </td>
                <td>
                    <a href="{{route('markAsReadNotification', $notification->id)}}"> mark as read</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($notifications->count()>0)
    <a href="{{route('markAllAsReadNotification')}}"> mark all as read</a>
    @endif
    
</div>


@endsection()