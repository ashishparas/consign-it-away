@extends('layouts.app')


@section('content')


<div class="ms-content-wrapper">
    <!--breadcrumbs-->
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="javascript:void(0)" alt="img"><img src="{{asset('public/assets/img/shopping-bag.svg')}}"> Order Management</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)" alt="img" class="">Shipping Orders Details</a></li>
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
              <div class="d-block d-lg-flex">
                <div class="shipping_img mr-0 mr-lg-3">
                   
                    <img src="{{asset('public/products/'.$items->product->image[0])}}"  class="img-fulid" alt=""></div>
                <div class="pt-2 flex_1">
                    <h5 class="blue_cl">{{$items->product->name}}</h5>
                    <p class="black_cl fs-16 w-50 mb-2 font-weight-bold w-m-100">{{$items->product->description}}</p>
                        <div class="d-flex align-items-center pb-2">
                        <ul class="ms-star-rating rating-fill rating-circle ratings-new mb-0">
                            <?php
                            $rating = intval(ROUND($items->rating->rating));
                            
                            for($i = 1; $i<=$rating; $i++){ ?>
                                    <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                            <?php } ?>
                        
                            
                            {{-- <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li> --}}
                          </ul>
                          <span class="grey_cl fs-14 pt-2">({{$items->rating->RatingCount}})</span>
                        </div>
                          <p class="orange_cl mb-0 fs-16 p-1 font-weight-bold">{{$items->price}}</p>
                          <a role="button" href="javascript:;" class="btn btn-success">View Product</a>
                </div>
            </div>
            <div class="row pt-4">
            <div class="col-md-6 col-lg-6">
                <h5 class="font-weight-normal pb-3">Order Summary</h5>
                <h6>Order Details </h6>
                <div class="d-flex justify-content-between pb-2">
                    <span class="grey_cl">Order ID: <strong class="black_cl">#{{$items->order_id}}</strong></span>
                </div>
                <div class="d-flex justify-content-between pb-2">
                    <span class="grey_cl">{{$items->created_at}}</span>
                </div>
                <div class="d-flex justify-content-between pb-4">
                    <span class="grey_cl">Category: <strong class="black_cl">{{$items->product->category->title}}</strong></span>
                    <span>Quantity:<strong class="black_cl">{{$items->quantity}}</strong></span>
                </div>
                  <h5 class="border-bottom pb-2 mb-3">Customer Details </h5>
                  <div class="d-flex justify-content-between pb-3">
                    <span class="grey_cl">Name:</span>
                    <span class="black_cl">{{$items->customer->name}}</span>
                </div>
                <div class="d-flex justify-content-between pb-3">
                    <span class="grey_cl">Phone: </span>
                    <span class="black_cl">{{ $items->customer->phonecode.''.$items->customer->mobile_no }}</span>
                </div>
                <div class="pb-4">
                    <span class="grey_cl">Shipping Address: </span>
                    <h6 class="green_cl mb-1 pt-1">Home</h6>
                    <h6 class="black_cl w-75">{{$items->address->address}} {{ucfirst($items->address->city)}}, {{Ucfirst($items->address->state)}}, {{strtoupper($items->address->country)}}</h6>
                </div>
                  <h5 class="border-bottom pb-2 mb-3">Payment Details</h5>
                  <div class="d-flex justify-content-between pb-3">
                    <span>Subtotal:</span>
                      <span>${{number_format((float)$items->price,2)}}</span>
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
                    <h5><strong>${{number_format((float)$items->price,2)}}</strong></h5>
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
                        <h5 class="font-weight-normal pb-3">Shipping Deatils</h5>
                        <div class="d-flex justify-content-between pb-2">
                            <span class="grey_cl">Shipped: <strong class="black_cl">{{$items->updated_at}}</strong></span>
                            <span class="grey_cl">Status: <strong class="blue_cl">
                                @if($items->status === '1')
                                    Order Placed
                                @elseif($items->status === '2')
                                    Out for Delivery
                                    @elseif($items->status === '3')
                                    Product Delivered
                                    @elseif($items->status === '4')
                                    Request For cancel order
                                    @elseif($items->status === '5')
                                    Requested For Refund
                                    @endif
                            </strong></span>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <span class="grey_cl">Tracking ID: <strong class="black_cl">{{ ($items->tracking_id)? $items->tracking_id: 'Not Updated Yet' }}</strong></span>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <span class="grey_cl">Shipped With: <strong class="black_cl">{{
                                ($items->product)? $items->product->shipping_type: 'Shipping method Not specify';
                                }}</strong></span>
                        </div>
                        <div class="border-bottom py-2 mb-3"></div>
                        <h5 class="font-weight-normal pb-3">Label Information</h5> 
                        <div class="d-flex justify-content-between pb-2">
                            <span class="grey_cl">Weight </span>
                            <span><strong class="black_cl">{{$items->product->weight}} Pound</strong></span>
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
                            <div><img src="{{asset('public/assets/img/location_lined.png')}}"></div>
                            <div class="pl-2">
            <h6 class="grey_cl mb-1">{{$items->address->address}}, {{Ucfirst($items->address->city)}}      {{Ucfirst($items->address->state)}}, {{strtoupper($items->address->country)}}</h6>
            <p class="orange_cl">Customer</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline">
                            <div><img src="{{asset('public/assets/img/location_lined.png')}}"></div>
                            <div class="pl-2">
                                <h6 class="grey_cl mb-1">Deltas Warehouse, Industrial Area, Phase A, 120-999</h6>
                                <p class="orange_cl">Vendor</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <span class="badge bg-black  text-white p-2 rounded-pill mr-2">124 Miles</span>
                            <span class="badge green_bg text-white p-2 rounded-pill">Cost:$34.9</span>
                        </div>
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