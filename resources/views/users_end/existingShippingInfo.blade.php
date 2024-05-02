@extends('users_end.layouts.template')

@section('title')
Select Address
@endsection()

@section('content')
<div class="fashion_section">
    <div id="main_slider">
        <div class="container">
            <h1 class="fashion_taital m-3">Select Existing Address</h1>

            @if(count($shippingInfos) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Phone Number</th>
                            <th>City</th>
                            <th>Street</th>
                            <th>Address</th>
                            <th>Instructions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shippingInfos as $shippingInfo)
                            <tr>
                                <td>{{ $shippingInfo->phone_number }}</td>
                                <td>{{ $shippingInfo->city }}</td>
                                <td>{{ $shippingInfo->street }}</td>
                                <td>{{ $shippingInfo->address }}</td>
                                <td>{{ $shippingInfo->instruction }}</td>
                                <td><a href="{{route('useExistingShippingInfo',$shippingInfo->id)}}">Select</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No existing addresses found.</p>
            @endif
        </div>
    </div>
</div>


@endsection()