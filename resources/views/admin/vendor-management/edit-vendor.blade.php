@extends('layouts.app')

@section('content')

<div class="ms-content-wrapper">
        <!--breadcrumbs-->
        @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="vendor-mgt.html"><img src="{{asset('public/assets/img/vendor.svg')}}"> Vendor Management</a></li>
                <li class="breadcrumb-item active">Edit Vendor</li>
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
                        <h3 class="mb-0">Edit Vendor</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-12 mt-4">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-body">
                        <div>
                            <div>
                              <form class="ms-form-wizard ms-wizard-pill style2-wizard add-vendor-block" method="post" enctype="multipart/form-data" action="{{route('update-details',$vendor->id)}}">
                               @csrf
                                <!--<h3 class="text-left">Personal Information</h3>-->
                                <div class="ms-wizard-step">
                                    <h5 class="mb-4 mt-5">Fill The Following Details</h5>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-2">
                                          <label for="validationCustom01">First Name</label>
                                          <div class="input-group">
                                            <input type="text" class="@error('fname') is-invalid @enderror form-control" placeholder="Enter first name" name="fname" value="{{$vendor->fname}}">
                                          </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                          <label for="validationCustom02">Last Name</label>
                                          <div class="input-group">
                                            <input type="text" class="@error('lname') is-invalid @enderror form-control" placeholder="Enter last name" name="lname" value="{{$vendor->lname}}">
                                          </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                          <label for="validationCustomUsername">Email</label>
                                          <div class="input-group">
                                            <input type="text" class="@error('email') is-invalid @enderror form-control" placeholder="Email" name="email" value="{{ $vendor->email }}">
                                              </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                          <label for="validationCustomUsername">Phone Code</label>
                                          <div class="input-group">
                                            <input type="text" class="@error('phonecode') is-invalid @enderror form-control" placeholder="Phone Code" name="phonecode" value="{{ $vendor->phonecode }}">
                                              </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                          <label for="validationCustomUsername">Phone Number</label>
                                          <div class="input-group">
                                            <input type="text" class="@error('mobile_no') is-invalid @enderror form-control" placeholder="Phone Number" name="mobile_no"  value="{{$vendor->mobile_no}}">
                                              </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">FAX</label>
                                            <div class="input-group">
                                              <input type="text" class="form-control" placeholder="Enter fax number" name="fax" value="{{ $vendor->fax }}">
                                            </div>
                                          </div>
                                          <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">PayPal ID</label>
                                            <div class="input-group">
                                              <input type="text" class="@error('paypal_id') is-invalid @enderror form-control" placeholder="Enter payPal ID" name="paypal_id" value="{{$vendor->paypal_id}}">
                                            </div>
                                          </div>
                                          <div class="col-md-4 mb-3">
                                            <label for="validationCustomUsername">Bank Account No.</label>
                                            <div class="input-group">
                                              <input type="text" class="@error('bank_ac_no') is-invalid @enderror form-control" placeholder="Enter account no." name="bank_ac_no"  value="{{ $vendor->bank_ac_no }}">
                                                </div>
                                          </div>
                                          <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">Routing Number</label>
                                            <div class="input-group">
                                              <input type="text" class="@error('routing_no') is-invalid @enderror form-control" placeholder="Enter routing no." name="routing_no" value="{{ $vendor->routing_no }}">
                                            </div>
                                          </div>
                                          <div class="col-md-8 mb-3">
                                            <label for="validationCustom02">Street Address</label>
                                            <div class="input-group">
                                              <input type="text" class="@error('street_address') is-invalid @enderror form-control" placeholder="Enter Address" name="street_address" value="{{ $vendor->street_address }}">
                                            </div>
                                          </div>
                                          <div class="col-md-4 mb-3">
                                            <label for="validationCustom02">City</label>
                                            <div class="input-group">
                                              <input type="text" class="@error('city') is-invalid @enderror form-control" placeholder="Enter city" name="city" value="{{ $vendor->city}}">
                                            </div>
                                          </div>
                                          <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">State</label>
                                            <div class="input-group">
                                              <input type="text" class="@error('state') is-invalid @enderror form-control" placeholder="Enter State" name="state" value="{{ $vendor->state }}">
                                            </div>
                                          </div>
                                          <div class="col-md-4 mb-3">
                                            <label for="validationCustomUsername">Country</label>
                                            <div class="input-group">
                                              <input type="text" class="@error('country') is-invalid @enderror form-control" placeholder="Select Country" name="country" value="{{ $vendor->country }}">
                                                </div>
                                          </div>
                                          
                                          <div class="col-md-4 mb-3">
                                            <label for="validationCustom01">Zip Code</label>
                                            <div class="input-group">
                                              <input type="text" class="@error('zipcode') is-invalid @enderror form-control" placeholder="Enter zip-code" name="zipcode" value="{{ $vendor->zipcode }}">
                                            </div>
                                          </div>
                                      </div>
                                       <button class="btn btn-primary px-4" type="submit" >Submit</button>
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