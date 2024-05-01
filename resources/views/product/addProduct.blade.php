@extends('admin.layouts.template')

@section('title')
Add Product
@endsection()

@section('content')


            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="py-3 mb-4"><span class="text-muted fw-light">products/</span> add_product</h4>

              <!-- Basic Layout & Basic with Icons -->
              <div class="row">
                <!-- Basic Layout -->
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <p class="mb-0 text-muted">Add new product using the form below <i class='bx bx-chevron-down'></i></p>
                    </div>
                    <div class="card-body">
                      <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" placeholder="Product name" name= "product_name" />
                          </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <label class="col-form-label" for="product_price">Product Price</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="product_price" placeholder="Amount in BDT" name="price">
                            </div>
                            <div class="col-sm-2">
                                <label class="col-form-label" for="product_quantity">Product Quantity</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="product_quantity" placeholder="Quantity" name="quantity">
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
                                placeholder="Enter product description here."
                                aria-label="Enter product description here."
                                aria-describedby="basic-icon-default-message2"></textarea>
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
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label class="col-form-label" for="subcategory">Sub-category</label>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-select" id="subcategory" name="product_sub_category_id" disabled>
                                    <option value="">Select Sub Category</option> <!-- Default option -->
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="status">Status</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="status" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="formFile">Upload Product Image</label>
                            <div class="col-sm-10">
                            <input class="form-control" type="file" id="formFile" 
                            name="product_image"/>
                            </div>
                            
                        </div>



                        <div class="row justify-content-end">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary"><i class='bx bx-plus'></i>Add</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('#category').change(function () {
                        var categoryId = $(this).val();
                        if (categoryId) {
                            $('#subcategory').prop('disabled', false);
                            $('#subcategory').html('<option value="">Loading...</option>');
                            $.ajax({
                                type: "POST",
                                url: "{{ route('getSubcategories') }}",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    categoryId: categoryId
                                },
                                success: function (subcategories) {
                                    $('#subcategory').html('<option value="">Select Sub Category</option>');
                                    subcategories.forEach(function (subcategory) {
                                        $('#subcategory').append('<option value="' + subcategory.id + '">' + subcategory.sub_category_name + '</option>');
                                    });
                                }
                            });
                        } else {
                            $('#subcategory').prop('disabled', true);
                            $('#subcategory').html('<option value="">Select Sub Category</option>');
                        }
                    });
                });
            </script>


@endsection()