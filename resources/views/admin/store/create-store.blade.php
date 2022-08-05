@extends('layouts.app')


@section('content')

<div class="ms-content-wrapper">
        <!--breadcrumbs-->
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="vendor-mgt.html"><img src="{{asset('public/assets/img/vendor.svg')}}"> Store Management</a></li>
                <li class="breadcrumb-item active">Add Store</li>
              </ol>
            </nav>
          </div>
        </div>
        <!--breadcrumbs-->
        <!--shipping-orders-->
        <div class="row align-items-start">
            <div class="col-xl-12 col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-header border-0 d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Add Store</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-12 mt-4">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-body">
                        <div>
                            <div>
                              <form class="ms-form-wizard ms-wizard-pill style2-wizard add-vendor-block" method="post" enctype="multipart/form-data" action="{{url('/admin/create-store')}}">
                               @csrf
                                <!--<h3 class="text-left">Personal Information</h3>-->
                                <div class="ms-wizard-step">
                                    <h5 class="mb-4 mt-5">Fill The Following Details</h5>
                                    <div class="form-row">
                                        <div class="addbanner-block col-12 mt-4">
                                            <div class="ms-profile-overview">
                                                <div class="ms-backbg h-75 d-flex align-items-center justify-content-center position-relative">
                                                    <div class="position-relative text-center">
                                                        <img src="{{asset('public/assets/img/upload_banner.svg')}}" class="bordernone" alt="">
                                                        <p class="green_cl">Add Banner Image</p>
                                                        <span class="file_upload_gallergy"><input type="file" class="custom-file-input" id="validatedCustomFile" name="banner"></span>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end store_block">
                                                    <img class="ms-profile-img" src="{{asset('public/assets/img/upload_store_img.png')}}" alt="img">
                                                    <div class="ms-profile-user-info store_img pb-0 mb-0 pl-2 position-relative">
                                                      <h6 class="ms-profile-username green_cl">Upload Store Image</h6>
                                                      <span class="file_upload"><input type="file" class="custom-file-input" id="validatedCustomFile" name="store_image"></span>
                                                      </div>
                                                </div>
                                                </div>
                                        </div>
                                        <div class="col-12">
                                            <h5 class="pt-4">Store Details</h5>
                                            <p class="pb-4">Upload all the details of store along with the manager details assign to the store.</p>
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <label for="exampleEmail">Store Name</label>
                                                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                                                        <input type="text" class="@error('name') is-invalid @enderror form-control"  placeholder="Enter your store name" name="name">
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="examplePassword">Location</label>
                                                         <input type="text" class="@error('location') is-invalid @enderror form-control" placeholder="Enter location" name="location">
                                                      </div>
                                                          <div class="form-group">
                                                        <label for="exampleTextarea">Description</label>
                                                        <textarea class="form-control" id="exampleTextarea" rows="6" name="description"></textarea>
                                                      </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                  </div>
                                       <button class="btn btn-primary px-4" type="submit" name="submit">Submit</button>
                                </div>
                                
                              </form>
                            </div>
                          </div>
                        
                    </div>
                
                </div>
            </div>
            
        </div>
        <!--shipping-orders-->
    </div>

@endsection