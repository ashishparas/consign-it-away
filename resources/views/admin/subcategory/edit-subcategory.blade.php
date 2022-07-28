@extends('layouts.app')





@section('content')
<div class="ms-content-wrapper">
        <!--breadcrumbs-->
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><img src="{{asset('public/assets/img/vendor.svg')}}">Add SubCategory</li>
  
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
                          <h4 class="mb-0">SubCategory</h4>
                      </div>
                      <form action="{{url('/admin/update-subcategory')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$subcategory->id}}" />
                      <div class="ms-panel-body">
                              <div class="col-md-12 col-lg-12 mb-3">
                                <label for="validationCustom01">Sub Category Name</label>
                                <div class="input-group">
                                   
                                  <input type="text" class="@error('title') is-invalid @enderror form-control" name="title" placeholder="Enter name" value="{{$subcategory? $subcategory->title:''}}">
                                </div>
                              </div>
                              <div class="pb-2 col-md-12 col-lg-12">
                                <label for="validationCustom01">Sub Category Image</label>
                                <div class="position-relative">
                                    <div class="upload_green upload_new_block">
                                       <img src="{{asset('public/assets/img/upload_banner.svg')}}">
                                    </div>
                                    <div class="input_upload"><input type="file" name="image" class="@error('image') is-invalid @enderror custom-file-input" id="validatedCustomFile"></div>
                                   </div>
                                   </div>
                                   <div class="pb-2 col-md-12 col-lg-12">
                                      <?php $photo = ($subcategory->image)? $subcategory->image:"No_image.png"; ?>
                                      <img src="{{asset('public/category/'.$photo)}}" width="50" height="50">
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