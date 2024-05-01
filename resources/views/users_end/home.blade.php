@extends('users_end.layouts.template')

@section('title')
Online Shop
@endsection()

@section('banner')


         <!-- banner section start -->
         <div class="banner_section layout_padding">
            <div class="container">
               <div id="my_slider" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                     <div class="carousel-item active">
                        <div class="row">
                           <div class="col-sm-12">
                              <h1 class="banner_taital">Get Start <br>Your favriot shoping</h1>
                              <div class="buynow_bt"><a href="#1">Shop now</a></div>
                           </div>
                        </div>
                     </div>
                     <div class="carousel-item">
                        <div class="row">
                           <div class="col-sm-12">
                              <h1 class="banner_taital">New <br>Products Available</h1>
                              <div class="buynow_bt"><a href="{{route('newRelease')}}">New Releases</a></div>
                           </div>
                        </div>
                     </div>
                     <div class="carousel-item">
                        <div class="row">
                           <div class="col-sm-12">
                              <h1 class="banner_taital">Don't Miss out <br>the best sellers</h1>
                              <div class="buynow_bt"><a href="{{route('bestSeller')}}">Best Seller</a></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <a class="carousel-control-prev" href="#my_slider" role="button" data-slide="prev">
                  <i class="fa fa-angle-left"></i>
                  </a>
                  <a class="carousel-control-next" href="#my_slider" role="button" data-slide="next">
                  <i class="fa fa-angle-right"></i>
                  </a>
               </div>
            </div>
         </div>
         <!-- banner section end -->

@endsection()

@section('content')

      <div class="fashion_section">
         <div id="main_slider">
            <div class="container mt-5">
                  <div class="landscape-banner">
                     <img src="https://img.freepik.com/free-vector/end-season-big-sale-banner-origami-style_23-2148400576.jpg?w=1380&t=st=1714559315~exp=1714559915~hmac=38c4da402b3a725679c89cf87ad0e845d1fa3424b365171c4143cef012fdfcf3" alt="Banner Image" height="100px">
                  </div>
            </div>
         </div>
      </div>

      <!-- fashion section start -->
      <div class="fashion_section">
         <div id="main_slider">
            <div class="container" id="1">
            @if (session('success'))
         <div class="alert alert-success">
            {{ session('success') }}
         </div>
      @endif

      @if (session('error'))
         <div class="alert alert-danger">
            {{ session('error') }}
         </div>
      @endif
                <h1 class="fashion_taital">All Products</h1>
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
@endsection()