@extends('users_end.layouts.template')

@section('title')
Best Seller
@endsection()

@section('content')


      <!-- fashion section start -->
      <div class="fashion_section">
         <div id="main_slider">
            <div class="container">
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
                <h1 class="fashion_taital">Best Seller Products</h1>
                <div class="fashion_section_2">
                    <div class="row">
                        <!-- // -->
                        @foreach($products as $product)
                        <div class="col-lg-4 col-sm-4">
                            <div class="box_main">
                                <h4 class="shirt_text">{{$product->product_name}}</h4>
                                @php 
                                    $productDetail = App\Models\Product::find($product->product_id);
                                @endphp
                                <p class="price_text">Price  <span style="color: #262626;">TK. {{ ($productDetail->price)}} </span></p>
                                <div class="tshirt_img"><img src="{{asset($productDetail->product_image)}}"></div>
                                <div class="btn_main">
                                
                                    <div class="buy_bt">
                                    <form action="{{route('addToCart')}}" method="POST">
                                       @csrf
                                    <input type="hidden" value="{{$productDetail->id}}" name="product_id">
                                       <a href="#"  onclick="document.forms[0].submit();">Add to cart</a>
                                       </form>
                                    </div>

                                 

                                <div class="seemore_bt"><a href="{{route('productDetails',$productDetail->id)}}">See More</a></div>
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