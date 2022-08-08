@extends('layouts.app')


@section('content')
 <div class="ms-content-wrapper">
        <!--breadcrumbs-->
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="#"><img src="{{asset('public/assets/img/diamond.svg')}}"> Subscription Management</a></li>
                <li class="breadcrumb-item active">Add Plan</li>
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
                        <h3 class="mb-0">Add Plan</h3>
                      
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-12 mt-4">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-body">
                     <h5 class="pb-4">Fill The Following Details</h5>
                     <form class="needs-validation" action="{{url('/admin/create-plans')}}" method="post" enctype="multipart/form-data">
                         @csrf
                        <div class="form-row">
                          <div class="col-md-4 mb-3">
                            <label for="validationCustom02">Plan Name</label>
                            <div class="input-group">
                              <input type="text" class="@error('name') is-invalid @enderror form-control" placeholder="Enter name" name="name">
                            </div>
                          </div>
                            <div class="col-md-4 mb-3">
                            <label for="validationCustom01">Monthly Price</label>
                            <div class="input-group">
                                <input type="text" class="@error('monthly_price') is-invalid @enderror form-control" placeholder="Enter Price" name="monthly_price">
                            </div>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label for="validationCustom02">Yearly Price</label>
                            <div class="input-group">
                              <input type="text" class="@error('yearly_price') is-invalid @enderror form-control" placeholder="Enter Price" name="yearly_price">
                            </div>
                          </div>
                        </div>
                        <div class="">
                            <label for="validationCustom12">Description</label>
                            <div class="input-group">
                              <textarea rows="5" id="validationCustom12" class="@error('content') is-invalid @enderror form-control" placeholder="Description" name="content"></textarea>
                            </div>
                          </div>
                          <h5 class="py-3">Add Features</h5>
                          <div class="form-row">
                            <div class="col-xl-6 col-md-12 mb-3">
                              <label for="validationCustom10">Features</label>
                              <div class="input-group">
                                <input type="text"  class="@error('features') is-invalid @enderror form-control" placeholder="Features" name="features[]">
                                <input type="text"  class="@error('features') is-invalid @enderror form-control" placeholder="Features" name="features[]">

     
                                <!--<span class="ml-2"><img src="assets/img/plus_green.png" alt=""></span>-->
                              </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                              <div class="pargh_rightbg mt-2">
                                  <ul>
                                      <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                          <span><a href="javascript::"><img src="assets/img/close_gray.svg" alt=""></a></span>
                                        </li>

                                        <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                            <span><a href="javascript::"><img src="assets/img/close_gray.svg" alt=""></a></span>
                                          </li>
                                          <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                            <span><a href="javascript::"><img src="assets/img/close_gray.svg" alt=""></a></span>
                                          </li>
                                  </ul>
                              </div>
                            </div>
                            
                            <div class="col-md-12 text-center border-top pb-3">
                                <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                            </div> 
                       
                          </div>
                      </form>

                </div>
                

            </div>
            
        </div>
        <!--shipping-orders-->
        
    </div>
    </div>
@endsection