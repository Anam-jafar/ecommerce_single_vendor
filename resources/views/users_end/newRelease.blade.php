@extends('users_end.layouts.template')

@section('title')
New Releases
@endsection()

@section('content')
      <!-- fashion section start -->
      <div class="fashion_section">
         <div id="main_slider">
            <div class="container">
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
                                <div class="buy_bt">
                                    <form action="{{route('addToCart')}}" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{$product->id}}" name="product_id">
                                        <a href="#"  onclick="document.forms[0].submit();">Add to cart</a>
                                    </form>
                                </div>
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
      <!-- fashion section end -->
@endsection()