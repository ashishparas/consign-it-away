@extends('layouts.app')





@section('content')

<div class="ms-content-wrapper">
        <!--breadcrumbs-->
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><img src="{{asset('public/assets/img/vendor.svg')}}">Add Category Management</li>
  
              </ol>
            </nav>
          </div>
        </div>
        <!--breadcrumbs-->
        <!--shipping-orders-->
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="col-md-6 col-xl-6 mt-4">
                    <div class="ms-panel">
                      <div class="ms-panel-header">
                          <h4 class="mb-0">Add Category</h4>
                      </div>
                      <form action="{{url('/admin/create-category')}}" method="post" enctype="multipart/form-data">
                        @csrf
                      <div class="ms-panel-body">
                              <div class="col-md-12 col-lg-12 mb-3">
                                <label for="validationCustom01">Category Name</label>
                                <div class="input-group">
                                  <input type="text" name="title" class="@error('title') is-invalid @enderror form-control" placeholder="">
                                </div>
                              </div>
                              <div class="pb-2 col-md-12 col-lg-12">
                                <label for="validationCustom01">Category Image</label>
                                <div class="position-relative">
                                    <div class="upload_green upload_new_block">
                                       <img src="{{asset('public/assets/img/upload_banner.svg')}}" >
                                    </div>
                                    <div class="input_upload"><input type="file" name="image" class="@error('image') is-invalid @enderror  custom-file-input" id="validatedCustomFile"></div>
                                   </div>
                                   </div>
                                <div class="col-md-12 text-left">
                                    <button class="btn btn-primary px-4" type="submit">Save</button>
                                  </div>
                      </div>
                      </form>
                    </div>
              </div>
            </div>
        </div>
        <!--shipping-orders-->
    </div>
    
@endsection