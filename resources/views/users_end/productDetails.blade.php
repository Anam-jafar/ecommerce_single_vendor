@extends('users_end.layouts.template')

@section('title')
Online Shop
@endsection()

@section('content')
<div class="fashion_section">
    <div id="main_slider">
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-4">
                <div class="box_main">
                    <div class="tshirt_img">
                        <img src="{{asset($product->product_image)}}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="box_main">
                    <div class="product-info">
                        <h4 class="shirt_text text-left">{{$product->product_name}}</h4>
                        <p class="price_text text-left">Price  <span style="color: #262626;">TK. {{$product->price}} </span></p>
                    </div>
                    <div class="my-3 product-details">
                        <p class="lead">
                            {{$product->description}}
                        </p>
                        <ul class="p-2 bg-light my-2">
                            <li> {{$product->product_category_name}} </li>
                            <li>{{$product->product_sub_category_name}}</li>
                            <li>Available Quantity {{$product->quantity}}</li>
                        </ul>
                    </div>

                    <div class="btn_main">
                        <form action="{{route('addToCart')}}" method="POST">
                            @csrf
                            <input type="hidden" value="{{$product->id}}" name="product_id">
                            <input class="btn btn-warning" type="submit" value="Add to cart">

                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
    <div class="fashion_section">
            <div id="main_slider">
                <div class="container">
                    <h1 class="fashion_taital">Related Products</h1>
                    <div class="fashion_section_2">
                        <div class="row">
                            <!-- // -->
                            @foreach($products as $product)
                            <div class="col-lg-4 col-sm-4">
                                <div class="box_main">
                                    <h4 class="shirt_text">{{$product->product_name}}</h4>
                                    <p class="price_text">Price  <span style="color: #262626;">TK. {{$product->price}} </span></p>
                                    <div class="tshirt_img"><img src="{{asset($product->product_image)}}"></div>
                                    <div class="btn_main">
                                    <div class="buy_bt"><a href="#">Buy Now</a></div>
                                    <div class="seemore_bt"><a href="{{route('productDetails',$product->id)}}">See More</a></div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
        </div>
        </div>
@endsection()