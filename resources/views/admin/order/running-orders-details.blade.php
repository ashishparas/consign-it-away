@extends('layouts.app')



@section('content')

<div class="ms-content-wrapper">
    <!--breadcrumbs-->
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="order-mgt.html"><img src="{{ asset('assets/img/shopping-bag.svg') }}"> Order Management</a></li>
                <li class="breadcrumb-item"><a href="running-orders.html">Running Orders</a></li>
                <li class="breadcrumb-item active">Running Orders Details</li>
              </ol>
        </nav>
      </div>
    </div>
    <!--breadcrumbs-->
    <!--shipping-orders-->
    <div class="row">
      <div class="col-xl-12 col-md-12">
        <div class="ms-panel">
          <div class="ms-panel-header border-0">
              <h3 class="mb-0">Shipping Details</h3>
          </div>
        </div>
      </div>
      <div class="col-xl-12 col-md-12">
        <div class="ms-panel">
          <div class="ms-panel-body">
              <div class="d-flex">
                <div class="shipping_img mr-3"><img src="{{ asset('assets/img/shipping_detail_img.png') }}" class="img-fulid" alt=""></div>
                <div class="pt-2 flex_1">
                    <h5 class="blue_cl">Watch</h5>
                    <p class="black_cl fs-16 w-50 mb-2 font-weight-bold">Noise ColorFit Pro 2 Full Touch Control Smart Watch with 35g Weight & Upgraded LCD Display,
                        IP68 Waterproof,Heart Rate...</p>
                        <div class="d-flex align-items-center pb-2">
                        <ul class="ms-star-rating rating-fill rating-circle ratings-new mb-0">
                            <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                          </ul>
                          <span class="grey_cl fs-14 py-2">(159)</span>
                        </div>
                          <p class="orange_cl mb-0 fs-16 p-1 font-weight-bold">$180.00</p>
                          <a role="button" href="javascript:;" class="btn btn-success">View Product</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-4">
                  <div class="border p-3">
                    <h5 class="mb-4">Order Tracking</h5>
                    <ul class="timeline" id="timeline">
                      <li class="li complete">
                        <div class="timestamp">
                          <h4> Order Placed</h4>
                        </div>
                        <div class="status timestamp pt-3">
                          <span class="author">1 Jan, 2022</span>
                          <span class="date">10:07 AM<span>
                        </div>
                      </li>
                      <li class="li complete">
                        <div class="timestamp">
                          <h4>Confirmed</h4>
                        </div>
                        <div class="status timestamp pt-3">
                          <span class="author">2 Jan, 2022</span>
                          <span class="date">10:15 AM<span>
                        </div>
                      </li>
                      <li class="li">
                        <div class="timestamp">
                          <h4>Processing</h4>
                        </div>
                        <div class="status statusheight pt-3">
                          <span class="author">&nbsp;</span>
                          <span class="date">&nbsp;<span>
                        </div>
                      </li>
                      <li class="li">
                        <div class="timestamp">
                          <h4>Out of Delivery</h4>
                        </div>
                        <div class="status statusheight pt-3">
                          <span class="author">&nbsp;</span>
                          <span class="date">&nbsp;<span>
                        </div>
                      </li>
                      <li class="li">
                        <div class="timestamp">
                          <h4>Order Delivered</h4>
                        </div>
                        <div class="status statusheight pt-3">
                          <span class="author">&nbsp;</span>
                          <span class="date">&nbsp;<span>
                        </div>
                      </li>
                     </ul>  
                  </div>
                </div>
            </div>
            <div class="row pt-4">
            <div class="col-md-6 col-lg-6">
                <h4 class="font-weight-bold pb-3">Order Summary</h4>
                <h5>Order Details </h5>
                <div class="d-flex justify-content-between pb-2">
                    <span class="grey_cl">Order ID: <strong class="black_cl">#87387399220</strong></span>
                </div>
                <div class="d-flex justify-content-between pb-2">
                    <span class="grey_cl">Order on 21 May, 2021</span>
                </div>
                <div class="d-flex justify-content-between pb-4">
                    <span class="grey_cl">Category: <strong class="black_cl">Shoe</strong></span>
                    <span>Quantity:<strong class="black_cl">1</strong></span>
                </div>
                  <h5 class="border-bottom pb-2 mb-3">Customer Details </h5>
                  <div class="d-flex justify-content-between pb-3">
                    <span class="grey_cl">Name:</span>
                    <span class="black_cl">Michal Jonson</span>
                </div>
                <div class="d-flex justify-content-between pb-3">
                    <span class="grey_cl">Phone: </span>
                    <span class="black_cl">+1 (415) 555 2671</span>
                </div>
                <div class="pb-4">
                    <span class="grey_cl">Shipping Address: </span>
                    <h6 class="green_cl mb-1 pt-1">Home</h6>
                    <h6 class="black_cl w-75">NO 256, City Avenue, City San Francisco, Province California, USA</h6>
                </div>
                  <h5 class="border-bottom pb-2 mb-3">Payment Details</h5>
                  <div class="d-flex justify-content-between pb-3">
                    <span>Subtotal:</span>
                      <span>$2115.00</span>
                  </div>
                  <div class="d-flex justify-content-between pb-3">
                    <span>Coupon Applied</span>
                    <span class="green_cl">- $100.00</span>
                </div>
                <div class="d-flex justify-content-between pb-3 borderdotted mb-3">
                    <span>Shipping cost:</span>
                    <span class="orange_cl"><strong>$35.00</strong></span>
                </div>
                <div class="d-flex justify-content-between pb-1">
                    <h5 class="font-weight-normal">Total amount</h5>
                    <h5><strong>$2050.00</strong></h5>
                </div>
                <div class="d-flex justify-content-between pb-3 borderdotted mb-3">
                    <h6 class="orange_cl">You earned</h6>
                    <h6 class="orange_cl"><strong>$50.00</strong></h6>
                </div>
                <div class="d-flex justify-content-between pb-3">
                    <h6>Payment Method</h6>
                    <h6 class="orange_lt">Mastercard</h6>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                    <div class="shipping_detail_bg p-3">
                        <h4 class="font-weight-bold pb-3">Shipping Deatils</h4>
                        <div class="d-flex justify-content-between pb-2">
                            <span class="grey_cl">Shipped: <strong class="black_cl">24 May, 2021</strong></span>
                            <span class="grey_cl">Status: <strong class="blue_cl">Out For Delivery</strong></span>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <span class="grey_cl">Tracking ID: <strong class="black_cl">DHTC05588</strong></span>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <span class="grey_cl">Shipped With: <strong class="black_cl">DTDC</strong></span>
                        </div>
                        <div class="border-bottom py-2 mb-3"></div>
                        <h4 class="font-weight-bold pb-3">Label Information</h4> 
                        <div class="d-flex justify-content-between pb-2">
                            <span class="grey_cl">Weight </span>
                            <span><strong class="black_cl">24 May, 2021</strong></span>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <span class="grey_cl">Dimensions </span>
                            <div class="d-flex">
                                <p class="black_cl text-center fs-16">
                                    <span class="d-block"><strong>L</strong></span>
                                    <span><strong>12cm</strong></span>
                                </p>
                                <p class="black_cl text-center fs-16 mx-3">
                                    <span class="d-block"><strong>W</strong></span>
                                    <span><strong>12cm</strong></span>
                                </p>
                                <p class="black_cl text-center fs-16">
                                    <span class="d-block"><strong>H</strong></span>
                                    <span><strong>12cm</strong></span>
                                </p>
                
                </div>
                        </div>
                        <div class="border-bottom py-2 mb-3"></div>
                        <h6 class="pb-2">Distance</h6>
                        <div class="d-flex align-items-baseline">
                            <div><img src="assets/img/location_lined.png"></div>
                            <div class="pl-2">
                                <h6 class="grey_cl mb-1">NO 256, City Avenue, City San Francisco, Province California, USA</h6>
                                <p class="orange_cl">Customer</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline">
                            <div><img src="assets/img/location_lined.png"></div>
                            <div class="pl-2">
                                <h6 class="grey_cl mb-1">Deltas Warehouse, Industrial Area, Phase A, 120-999</h6>
                                <p class="orange_cl">Vendor</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <span class="badge bg-black  text-white p-2 badge-pill mr-2">124 Miles</span>
                            <span class="badge green_bg text-white p-2 badge-pill">Cost:$34.9</span>
                        </div>
                        <!-- <button type="button" class="btn track_order_but mt-4 w-100">Track Order</button> -->
                    </div>
                  
            </div>
        </div>
            </div>  
            
         
          </div>
        </div>
      </div>
  
    </div>
    <!--shipping-orders-->
</div>

@endsection