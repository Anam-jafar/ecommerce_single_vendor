@extends('users_end.layouts.template')

@section('title')
Provide shipping address
@endsection()

@section('content')
<div class="fashion_section">
    <div id="main_slider">
        <div class="container">
            <h1 class="fashion_taital m-3">Provide Shipping Address</h1>
                <div class="col-12">
                    <div class="box_main">
                    <dl>
                        <dt>Name</dt>
                        <dd>{{$user->name}}</dd>
                        
                        <dt>Email</dt>
                        <dd>{{$user->email}}</dd>
                        
                    </dl>
                    </div>
                </div>
                @php 
                    $shippinginfo = App\Models\ShippingInfo::where('user_id', $user->id)->count(); 
                @endphp

                @if($shippinginfo>0)
                <div class="col-12">
                    <div class="box_main">
                    <h3>Existing Shipping info</h3>
                    <a href="{{route('existingShippingInfo')}}" class="btn btn-warning col-md-4">Select from all exisiting</a>
                    </div>
                </div>
                @endif
                <div class="col-12">
                    <div class="box_main">
                        <form method="POST">
                            @csrf
                            <input type="hidden" value="{{$user->id}}" name="user_id">
                            <div class="form-group">
                                <label for="phone_number"> Phone Number</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number">                           
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="address"> City</label>
                                    <input type="text" class="form-control" id="address" name="city">                           
                                </div>
                                <div class="form-group col-6">
                                    <label for="address"> Street</label>
                                    <input type="text" class="form-control" id="address" name="street">                           
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address"> Address</label>
                                <input type="text" class="form-control" id="address" name="address">                           
                            </div>
                            <div class="form-group">
                                <label for="instruction"> Instructions for delivery man</label>
                                <input type="text" class="form-control" id="instruction" name="instruction">                           
                            </div>

                            <input type="submit" class="btn btn-warning col-md-4" value="Next">


                        </form>
                    </div>
                </div>
    
        </div>
    </div>
</div>

@endsection()