@extends('layouts.app')



@section('content')

<div class="ms-content-wrapper">
    <!--breadcrumbs-->
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
                @php
                    $image = ($item->product)? $item->product->image[0]:'no_image.png';
                    $name =  ($item->product)? $item->product->name:'No Product Name found.!';
                    $ProductDescription =  ($item->product)? $item->product->description:'No Product Name found.!';
                    $ProductRatings  = ($item->rating)? $item->rating->rating:0;
                    $ProductRatingCount = ($item->rating)? $item->rating->RatingCount : 0;
                    $category = ($item->product)? $item->product->category->title:'No Category found.!';
                    $CustomerName = ($item->customer)? $item->customer->name : 'No-Name';
                    $CustomerPhone = ($item->customer)? $item->customer->phonecode.'-'.$item->customer->mobile_no : 'No-Name'; 
                    $ShippingAddress = ($item->address)? $item->address->address:'No Address found!'; 
                    $city = ($item->address)? $item->address->city:'City not found!'; 
                    $state = ($item->address)? $item->address->state:'State not found!'; 
                    $zipcode = ($item->address)? $item->address->zipcode:'Zipcode not found!'; 
                    $country = ($item->address)? $item->address->country:'Country not found!'; 
                   
                @endphp
                <li class="breadcrumb-item"><a href="order-mgt.html"><img src="{{ asset('public/assets/img/shopping-bag.svg') }}"> Order Management</a></li>
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
                {{-- public/assets/img/shipping_detail_img.png --}}
                
                <div class="shipping_img mr-3"><img src="{{ asset('public/products/'.$image)}}" class="img-fulid" alt=""></div>
                <div class="pt-2 flex_1">
                    <h5 class="blue_cl">{{ $name }}</h5>
                    <p class="black_cl fs-16 w-50 mb-2 font-weight-bold">{{ $ProductDescription }}</p>
                        <div class="d-flex align-items-center pb-2">
                        <ul class="ms-star-rating rating-fill rating-circle ratings-new mb-0">
                        @for ($i = 1; $i <= (int)$ProductRatings; $i++)
                        <li class="ms-rating-item rated"> <i class="material-icons">star</i> </li>
                        @endfor
                        
                          </ul>
                          <span class="grey_cl fs-14 py-2">({{ $ProductRatingCount }})</span>
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
                        @if (isset($tracking_status))
                        @foreach ($tracking_status as $tracking)
                           
                            <li class="li complete">
                                <div class="timestamp">
                                <p>{{ $tracking['status'] }}</p>
                                </div>
                                <div class="status timestamp pt-3">
                                <span class="author">{{ date('d, M, Y', strtotime($tracking['date'])) }}</span>
                                <span class="date">{{ $tracking['time'] }}<span>
                                </div>
                            </li>
                        @endforeach
                        @endif
                            
                      

                    

                   
                     </ul>  
                  </div>
                </div>
            </div>
            <div class="row pt-4">
            <div class="col-md-6 col-lg-6">
                <h4 class="font-weight-bold pb-3">Order Summary</h4>
                <h5>Order Details </h5>
                <div class="d-flex justify-content-between pb-2">
                    <span class="grey_cl">Order ID: <strong class="black_cl">#{{$item->id}}</strong></span>
                </div>
                <div class="d-flex justify-content-between pb-2">
                    {{-- 21 May, 2021 --}}
                    <span class="grey_cl">Order on {{date('d M,Y', strtotime($item->created_at))}}</span>
                </div>
                <div class="d-flex justify-content-between pb-4">
                    <span class="grey_cl">Category:  <strong class="black_cl"> {{ $category  }}</strong></span>
                    <span>Quantity:<strong class="black_cl"> {{ $item->quantity }}</strong></span>
                </div>
                  <h5 class="border-bottom pb-2 mb-3">Customer Details </h5>
                  <div class="d-flex justify-content-between pb-3">
                    <span class="grey_cl">Name:</span>
                    <span class="black_cl"> {{ $CustomerName }}</span>
                </div>
                <div class="d-flex justify-content-between pb-3">
                    <span class="grey_cl">Phone: </span>
                    <span class="black_cl"> {{ $CustomerPhone }}</span>
                </div>
                <div class="pb-4">
                    <span class="grey_cl">Shipping Address: </span>
                    <h6 class="green_cl mb-1 pt-1">Home</h6>
                   

                    <h6 class="black_cl w-75">{{$ShippingAddress}},   City {{ $city }},  <br>{{ $state }}, {{$country}},    {{$zipcode}}</h6>
                </div>
                  <h5 class="border-bottom pb-2 mb-3">Payment Details</h5>
                  <div class="d-flex justify-content-between pb-3">
                    <span>Subtotal:</span>
                      <span>${{$item->price}}</span>
                  </div>
                  <div class="d-flex justify-content-between pb-3">
                    <span>Coupon Applied-</span>
                    <span class="green_cl">00</span>
                </div>
                <div class="d-flex justify-content-between pb-3 borderdotted mb-3">
                    <span>Shipping cost:</span>
                    <span class="orange_cl"><strong>${{$shipping_fee}}</strong></span>
                </div>
                <div class="d-flex justify-content-between pb-1">
                    <h5 class="font-weight-normal">Total amount</h5>
                    <h5><strong>$ {{ $item->price + $shipping_fee  }}</strong></h5>
                </div>
                <div class="d-flex justify-content-between pb-3 borderdotted mb-3">
                    <h6 class="orange_cl">You earned</h6>
                    <h6 class="orange_cl"><strong>$00.00</strong></h6>
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
                            {{-- 24 May, 2021 --}}
                            <span class="grey_cl">Shipped: <strong class="black_cl">{{date('d, M , Y', strtotime('updated_at'))}}</strong></span>
                            <span class="grey_cl">Status: <strong class="blue_cl">
                            @if ($item->status === '1')
                                order Placed Shipped
                                @elseif($item->status === '2')
                                Order Shipped
                                @elseif($item->status === '3')
                                Order Delivered
                                @elseif($item->status === '4')
                                Requested for cancel order
                                @elseif($item->status === '5')
                                    Requested for Refund
                            @endif
                            </strong></span>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <span class="grey_cl">Tracking ID: <strong class="black_cl">{{$item->tracking_id}}</strong></span>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <span class="grey_cl">Shipped With: <strong class="black_cl">{{$item->product->shipping_type}}</strong></span>
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