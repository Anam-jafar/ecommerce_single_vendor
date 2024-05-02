@extends('users_end.layouts.template')

@section('title')
{{$subcategory->sub_category_name}}
@endsection()

@section('content')
      <!-- fashion section start -->
      <div class="fashion_section">
         <div id="main_slider">
            <div class="container" style="max-width: 1600px;">
                <h1 class="fashion_taital">{{$subcategory->sub_category_name}} - ({{$subcategory->product_count}})</h1>
                <div class="row">
                <div class="col-lg-2">
                <div class="box_main mt-5">
                    <h5>Sub Categories</h5>
                    <hr>
                    <ul>
                        @foreach($subcategories as $subcategory)
                        <li><a href="{{route('subCategoryProducts', $subcategory->id)}}">{{$subcategory->sub_category_name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-10">
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
                                    <a href="{{route('addToCart', $product->id)}}">Add to cart</a>
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
      </div>
      </div>
      <!-- fashion section end -->
@endsection()