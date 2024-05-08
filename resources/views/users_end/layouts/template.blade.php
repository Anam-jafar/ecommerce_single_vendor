@php
   $categories = App\Models\Category::where('deleted', '!=', 1)->latest()->get();
   $item_Count = App\Models\Cart::where('user_id', Auth::id())->count();
   $notifications = App\Models\Notification::where('user_id', Auth::id())->where('viewed',0)->latest()->get();
   $notification_count = $notifications->count();

@endphp
<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas --> 
      <title>@yield('title')</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('users_end/css/bootstrap.min.css')}}">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('users_end/css/style.css')}}">
      <!-- Responsive-->
      <link rel="stylesheet" href="{{ asset('users_end/css/responsive.css')}}">
      <!-- fevicon -->
      <link rel="icon" href="{{ asset('users_end/images/fevicon.png')}}" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="{{ asset('users_end/css/jquery.mCustomScrollbar.min.css')}}">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
      <!-- font awesome -->
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <!--  -->
      <!-- owl stylesheets -->
      <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:400,700&display=swap&subset=latin-ext" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('users_end/css/owl.carousel.min.css')}}">
      <link rel="stylesoeet" href="{{ asset('users_end/css/owl.theme.default.min.css')}}">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <style>
         html, body {
            height: 100%;
            margin: 0;
            padding: 0;
         }
         
         .content_wrapper {
            min-height: calc(100% - 50px); /* Adjust 50px according to your footer height */
            padding-bottom: 50px; /* Adjust according to your footer height */
         }

         .footer_section {
            position: relative;
            bottom: 0;
            width: 100%;
         }
      </style>
   </head>
   <body>
      <!-- banner bg main start -->
      <div class="banner_bg_main">
         <!-- header top section start -->
         <div class="container">
            <div class="header_section_top">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="custom_menu">
                        <ul>
                           <li><a href="{{route('bestSeller')}}">Best Sellers</a></li>
                           <li><a href="{{route('newRelease')}}">New Releases</a></li>
                           <li><a href="{{route('customerService')}}">Customer Service</a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- header top section start -->
         <!-- logo section start -->
         <div class="logo_section">
            <div class="container">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="logo"><a href="index.html"><img src="{{ asset('users_end/images/logo.png')}}"></a></div>
                  </div>
               </div>
            </div>
         </div>
         <!-- logo section end -->
         <!-- header section start -->
         <div class="header_section">
            <div class="container">
               <div class="containt_main">
                  <div id="mySidenav" class="sidenav">
                     <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                     <a href="{{route('home')}}">Home</a>
                     @foreach($categories as $category)
                           <a  href="{{route('categoryProducts',$category->id)}}">{{$category->category_name}}</a>
                     @endforeach
                  </div>
                  <span class="toggle_icon" onclick="openNav()"><img src="{{ asset('users_end/images/toggle-icon.png')}}"></span>
                  <div class="dropdown">
                     <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Category 
                     </button>
                     <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach($categories as $category)
                           <a class="dropdown-item" href="{{route('categoryProducts',$category->id)}}">{{$category->category_name}}</a>
                        @endforeach
                     </div>
                  </div>
                  <div class="main">
                     <!-- Another variation with a button -->
                     <div class="input-group">
                     <input type="text" id="searchInput" class="form-control" placeholder="Search Product">
                        <!-- Dropdown to display search results -->
                  <div id="searchResultsDropdown" class="dropdown-menu" style="display: none;"></div>
                     </div>
                  
                        <!-- Include jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

      <script>

      var productDetailsRoute = "{{ route('productDetails', ['id' => '__id__']) }}";


      $(document).ready(function(){
         $('#searchInput').on('input', function(){
            var query = $(this).val();
            var token = '{{ csrf_token() }}';
            if(query.length>0){
            $.ajax({
                  url: "{{ route('search') }}",
                  type: "GET",
                  data: {query: query},
                  headers: {
                     'X-CSRF-TOKEN': token
                  },
                  success: function(response){
                     // Update dropdown with search results
                     displaySearchResults(response);
                  },
                  error: function(xhr){
                     console.log(xhr.responseText);
                  }
            });
            }
            else{
               $('#searchResultsDropdown').hide();
            }
         });

         // Function to display search results in dropdown
         function displaySearchResults(products) {
            var dropdownContent = '';

            // Generate HTML for each product in the search results
            products.forEach(function(product) {
                  dropdownContent += '<a class="dropdown-item" href="' + productDetailsRoute.replace('__id__', product.id) + '">';

                  dropdownContent += '<img src="' + product.product_image + '" alt="' + product.product_name + '" class="mr-2" style="width: 50px;">';
                  dropdownContent += product.product_name;
                  dropdownContent += '</a>';

            });

            // Display dropdown with search results
            $('#searchResultsDropdown').html(dropdownContent);
            $('#searchResultsDropdown').show();
         }
      });
      </script>
                  </div>
                  <div class="header_box">
                     <div class="login_menu">
                        <ul>
                           <li style="margin-right: 10px;"> <!-- Adjust margin-right for space between icons -->
                              <a href="{{ route('cartView') }}">
                                 <i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i>
                                 @php
                                       if ($item_Count > 0) {
                                          echo '<span class="badge badge-pill badge-danger">' . $item_Count . '</span>';
                                       }
                                 @endphp
                              </a>
                           </li>
                           <li style="margin-right: 10px;"> <!-- Adjust margin-right for space between icons -->
                              <a href="{{ route('userNotification')}}">
                                 <i class="fa fa-bell fa-lg" aria-hidden="true"></i>
                                 @php
                                       if ($notification_count > 0) {
                                          echo '<span class="badge badge-pill badge-danger">' . $notification_count . '</span>';
                                       }
                                 @endphp
                              </a>
                           </li>

                           <li>
                                 <a href="{{ route('userProfile') }}">
                                    <i class="fa fa-user fa-lg" aria-hidden="true"></i> <!-- Added "fa-lg" class for larger size -->
                                 </a>
                           </li>
                        </ul>
                     </div>

                  </div>
               </div>
            </div>
         </div>
         <!-- header section end -->

      @yield('banner')
      
                  
      </div>
      <!-- banner bg main end -->
      

      <div class="content_wrapper">
      @yield('content')
      </div>
      <!-- footer section start -->
      <div class="footer_section">
         <div class="container">
            <div class="location_main">Help Line Number: <a href="#">+1 1800 1200 1200</a></div>
         </div>
         <div class="container">
            <p class="copyright_text">© 2024 All Rights Reserved. Developed by <a href="https://github.com/Anam-jafar">Anam Ibn Jafar</a></p>
         </div>
      </div>
      <!-- footer section end -->
      <!-- copyright section start -->

      <!-- copyright section end -->
      <!-- Javascript files-->
      <script src="{{ asset('users_end/js/jquery.min.js')}}"></script>
      <script src="{{ asset('users_end/js/popper.min.js')}}"></script>
      <script src="{{ asset('users_end/js/bootstrap.bundle.min.js')}}"></script>
      <script src="{{ asset('users_end/js/jquery-3.0.0.min.js')}}"></script>
      <script src="{{ asset('users_end/js/plugin.js')}}"></script>
      <!-- sidebar -->
      <script src="{{ asset('users_end/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
      <script src="{{ asset('users_end/js/custom.js')}}"></script>
      <script>
         function openNav() {
           document.getElementById("mySidenav").style.width = "250px";
         }
         
         function closeNav() {
           document.getElementById("mySidenav").style.width = "0";
         }
      </script>

   </body>
</html>