@extends('layouts.app')




@section('content')


<div class="ms-content-wrapper">
    <!--breadcrumbs-->
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><img src="{{asset('public/assets/img/supply-chain.svg')}}" alt="img">Staff Management</li>
            <li class="breadcrumb-item active">Add Staff</li>
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
                    <h3 class="mb-0">Add Staff</h3>
                    <span class="ml-auto">Auto Generate ID: #008</span>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xl-12 mt-4">
          <div class="ms-panel">
            <div class="ms-panel-header">
                <h4 class="mb-0">Details</h4>
            </div>
            <form action="{{url('/admin/create-staff')}}" method="post">
                @csrf
            <div class="ms-panel-body">
                <div class="w-25 pb-2">
                    <div class="position-relative">
                        <div class="upload_green upload_new_block">
                           <img src="{{asset('public/assets/img/upload_banner.svg')}}">
                        </div>
                        <div class="input_upload"><input type="file" class="custom-file-input" id="validatedCustomFile"></div>
                       </div>
                       <h6 class="green_cl">Upload Staff Image</h6>
                </div>
                
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom01">Staff Name</label>
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="Enter name">
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom02">Email</label>
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="Enter name">
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom02">Contact</label>
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="Enter Price">
                      </div>
                    </div>
                    <div class="col-md-4">
                        <label for="validationCustom02">Role</label>
                        <div class="input-group mb-2">
                                <select class="form-control">
                                    <option value="">Select Role</option>
                                    <option value="">Select Role 2</option>
                                    <option value="">Select Role 3</option>
                                    <option value="">Select Role 4</option>
                                  </select>
                        </div>
                      </div>
                      <div class="col-md-12 text-left">
                          <button class="btn btn-primary px-4" type="submit">Add</button>
                        </div>
                  </div>
            </div>
        </form>
          </div>
    </div>
    <!--shipping-orders-->
</div>



@endsection