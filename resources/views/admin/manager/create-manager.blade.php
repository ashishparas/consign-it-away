@extends('layouts.app')


@section('content')

<div class="ms-content-wrapper">
        <!--breadcrumbs-->
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="vendor-mgt.html"><img src="{{asset('public/assets/img/vendor.svg')}}"> Manager Management</a></li>
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
                        <h3 class="mb-0">Add Manager</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-12 mt-4">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-body">
                        <div>
                            <div>
                              <form class="ms-form-wizard ms-wizard-pill style2-wizard add-vendor-block" method="post" enctype="multipart/form-data" action="{{url('/admin/create-manager')}}">
                               @csrf
                               <input type="hidden" name="store_id" value="{{ $user_id }}">
                                <!--<h3 class="text-left">Personal Information</h3>-->
                                <div class="ms-wizard-step">
                                    <h5 class="mb-4 mt-5">Fill The Following Details</h5>
                                    <div class="form-row">
                                    <div class="col-12 col-lg-6">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <img class="ms-profile-img" src="{{asset('public/assets/img/user_photo.png')}}" alt="img">
                                                        <div class="ms-profile-user-info store_img pb-0 mb-0 pl-2 position-relative">
                                                          <h6 class="ms-profile-username green_cl">Upload Manager Image</h6>
                                                          <span class="file_upload"><input type="file" class="custom-file-input" id="validatedCustomFile" name="profile_picture"></span>
                                                          </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleEmail">Manager Name</label>
                                                        <input type="text" class="@error('name') is-invalid @enderror form-control"  placeholder="Enter name" name="name">
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="examplePassword">Email</label> 
                                                        <input type="text" class="@error('email') is-invalid @enderror form-control" placeholder="Enter email" name="email">
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="exampleTextarea">Phonecode</label>
                                                        <input type="text" class="@error('phonecode') is-invalid @enderror form-control" placeholder="Enter Phonecode" name="phonecode">
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="exampleTextarea">Contact No.</label>
                                                        <input type="text" class="@error('mobile_no') is-invalid @enderror form-control" placeholder="Enter contact" name="mobile_no">
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