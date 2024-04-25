@extends('admin.layouts.template')

@section('title')
Edit Product
@endsection()

@section('content')


            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="py-3 mb-4"><span class="text-muted fw-light">products/</span> edit_product</h4>

              <!-- Basic Layout & Basic with Icons -->
              <div class="row">
                <!-- Basic Layout -->
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <p class="mb-0 text-muted">Update product using the form below <i class='bx bx-chevron-down'></i></p>
                    </div>
                    <div class="card-body">
                      <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" value="{{ $product->product_name}}" name= "product_name" />
                          </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <label class="col-form-label" for="product_price">Product Price</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="product_price" value="{{ $product->price}}" name="price">
                            </div>
                            <div class="col-sm-2">
                                <label class="col-form-label" for="product_quantity">Product Quantity</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="product_quantity" value="{{ $product->quantity}}" name="quantity">
                            </div>
                        </div>

                        <div class="row mb-3">
                          <label class="col-sm-2 form-label" for="basic-icon-default-message">Description</label>
                          <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                              <textarea
                                name="description"
                                id="basic-icon-default-message"
                                class="form-control"
                                aria-label="Enter product description here."
                                aria-describedby="basic-icon-default-message2">{{ $product->description}}</textarea>
                            </div>
                          </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <label class="col-form-label" for="category">Category</label>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-select" id="category" name="product_category_id">
                                    <option value="">Select Category</option> <!-- Default option -->
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $product->product_category_id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label class="col-form-label" for="subcategory">Sub-category</label>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-select" id="subcategory" name="product_sub_category_id">
                                    <option value="">Select Sub Category</option> <!-- Default option -->
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}" {{ $subcategory->id == $product->product_sub_category_id ? 'selected' : '' }}>
                                            {{ $subcategory->sub_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="status">Status</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="status" name="status">
                                    <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="formFile">Upload Product Image</label>
                            <div class="col-sm-10">
                                <!-- Show existing image if it exists -->
                                @if($product->product_image)
                                    <img src="{{ asset($product->product_image) }}" alt="Product Image" class="img-thumbnail img-fluid mb-2" style="max-height: 200px;">
                                @else
                                    <p>No image uploaded</p>
                                @endif

                                <!-- Input field for uploading new/replacing image -->
                                <input class="form-control" type="file" id="formFile" name="product_image"/>
                                <!-- Display the name of the currently uploaded image if exists -->
                                @if($product->product_image)
                                    <input type="text" class="form-control mt-2" value="{{ basename($product->product_image) }}" readonly>
                                @else
                                    <input type="text" class="form-control mt-2" placeholder="No image uploaded" readonly>
                                @endif
                            </div>
                        </div>




                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary"><i class='bx bxs-edit-alt'></i>Update</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="https://themeselection.com" target="_blank" class="footer-link fw-medium">ThemeSelection</a>
                </div>
                <div class="d-none d-lg-inline-block">
                  <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                  <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                  <a
                    href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >

                  <a
                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                    target="_blank"
                    class="footer-link"
                    >Support</a
                  >
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>


@endsection()