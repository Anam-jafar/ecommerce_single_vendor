@extends('admin.layouts.template')

@section('title')
Add banner
@endsection()

@section('content')


            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="py-3 mb-4"><span class="text-muted fw-light">bannner/</span> add_banner</h4>

              <!-- Basic Layout & Basic with Icons -->
              <div class="row">
                <!-- Basic Layout -->
                <div class="col-xxl">
                  <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <p class="mb-0 text-muted">Add new banner using the form below <i class='bx bx-chevron-down'></i></p>
                    </div>
                    <div class="card-body">
                      <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" placeholder="Banner name" name= "name" />
                          </div>
                        </div>



                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="formFile">Upload Banner Image</label>
                            <div class="col-sm-10">
                            <input class="form-control" type="file" id="formFile" 
                            name="image"/>
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
@endsection()