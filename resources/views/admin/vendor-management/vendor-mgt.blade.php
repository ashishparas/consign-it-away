@extends('layouts.app')


@section('content')

<div class="ms-content-wrapper">
    <!--breadcrumbs-->
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><img src="{{asset('public/assets/img/vendor.svg')}}"> Vendor Management</li>
            <!-- <li class="breadcrumb-item">Running Orders</li>
            <li class="breadcrumb-item active">Shipping Orders Details</li> -->
          </ol>
        </nav>
      </div>
    </div>
    <!--breadcrumbs-->
    <!--shipping-orders-->
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="ms-panel">
                <div class="ms-panel-header border-0 d-flex justify-content-between">
                    <h3>Vendor Management</h3>
                    <a href="add-vendor.html" class="btn green_btn">+ Add Vendor</a>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="ms-panel">
                <div class="ms-panel-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Vendor Account Request</h4>
                    <span class="requests_counts">6</span>
                </div>
                <div class="ms-panel-body auto_scroll">
                    <div class="requests_scroll">
                        @foreach($vendors as $vendor)
                      
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="chat_thread d-flex mb-0">
                                <img class="mr-4" src="{{asset('public/vendor/'.$vendor->profile_picture)}}" alt="alt" />
                                <div class="chat_thread_data">
                                    <h5 class="mb-1">{{$vendor->name}}</h5>
                                    <p class="mb-0">{{$vendor->email}}</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <a href="#" class="mr-3">
                                    <img class="img-fluid" src="{{asset('public/assets/img/accept.svg')}}" alt="alt" />
                                </a>
                                <a href="#">
                                    <img class="img-fluid" src="{{asset('public/assets/img/decline.svg')}}" alt="alt" />
                                </a>
                            </div>
                        </div>
                 @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="ms-panel">
                <div class="ms-panel-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Vendor Account Request</h4>
                    <span class="requests_counts">43</span>
                </div>
                <div class="ms-panel-body auto_scroll">
                    <div class="requests_scroll">
                        @foreach($products as $product)
                        <div>
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="chat_thread d-flex mb-3">
                                    <img class="mr-3" src="{{asset('public/products/'.$product->image[0])}}" alt="alt" />
                                    <div class="chat_thread_data">
                                        <h6 class="mb-1 mr-2"><a href="#" class="black_cl">{{$product->name}}</a></h6>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <a href="#" class="mr-3">
                                        <img class="img-fluid" src="{{asset('public/assets/img/accept.svg')}}" alt="alt" />
                                    </a>
                                    <a href="#">
                                        <img class="img-fluid" src="{{asset('public/assets/img/decline.svg')}}" alt="alt" />
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-start">
                                <ul class="list-inline mb-0 products_added_list">
                                    <li class="list-inline-item mr-5 mb-2">Quantity: <span class="black_cl">{{$product->quantity}}</span></li>
                                    <li class="list-inline-item">Price: <span class="black_cl mb-2">$ {{(float)$product->price}} / per item</span></li>
                                    <li class="list-inline-item">Vendor: <a class="green_cl" href="#">{{
                                        ($product->soldBy == null)?'Not Added':$product->soldBy->name; }}</a></li>
                                </ul>
                                <small>{{date('d-m-Y',strtotime($product->created_at))}}</small>
                            </div>
                            <!-- <div class="product_add_info">
                                <p>Quantity: <span>12</span></p>
                            </div> -->

                            <hr />
                        </div>
@endforeach
               
                   

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-md-12">
            <div class="ms-panel">
                <div class="ms-panel-header d-flex justify-content-between">
                    <h4 class="mb-0">Vendor Listing</h4>
                </div>
                <div class="ms-panel-body">
                    <div class="running_orders_summary table-responsive">
                        <!----table---->
                        <table id="example" class="running_order table table-striped dataTable_custom" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Vendor</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>#{{$product->id}}</td>
                                    <td class="product_tuc">
                                        <div class="d-block d-lg-flex align-items-center">
                                            <img class="mr-3" src="{{asset('public/products/'.$product->image[0])}}" alt="image" />
                                            <div class="d-block d-lg-flex flex-column">
                                                <h6 class="mb-0">{{($product->soldBy == null)?'No Store Added':$product->soldBy->name}}</h6>
                                                <small class="grey_cl">{{($product->user ==null)?'No-name':$product->user->name}}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{($product->user==null)?'Mobile no not given':$product->user->phonecode.''.$product->user->mobile_no}}</td>
                                    <td>{{($product->user ==null)?'No Email':$product->user->email}}</td>
                                    <td><span class="green_cl">Active</span></td>
                                    <td><a href="{{url('admin/vendor-edit-profile/'.$product->user->id)}}" class="btn orange_btn">View</a></td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <!----table---->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--shipping-orders-->
</div>



@endsection