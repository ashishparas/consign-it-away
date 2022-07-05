@extends('layouts.app')
@section('content');
<div class="ms-content-wrapper">
    <!--breadcrumbs-->
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><img src="{{asset('public/assets/img/shopping-bag.svg')}}"> Order Management</li>
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
          <div class="ms-panel-header border-0">
              <h3 class="mb-0">Order Management</h3>
          </div>
        </div>
      </div>
      <div class="col-xl-7 col-md-7">
        <div class="ms-panel">
          <div class="ms-panel-header border_tab border-0">
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation"><a href="#shipping-orders" aria-controls="shipping-orders" class="active" role="tab" data-toggle="tab">Shipping Orders</a></li>
              <li class="center_divider"></li>
              <li role="presentation"><a href="#past-orders" aria-controls="past-orders" role="tab" data-toggle="tab">Past Orders</a></li>
            </ul>
          </div>
          <div class="ms-panel-body pt-0">
            <div class="shipping_scroll">
              <div class="tab-content">
                <!-- Start shipping-orders-->
                <div role="tabpanel" class="tab-pane active show fade in" id="shipping-orders">
                    @foreach ($items as $item)
                    <div class="shipping_wrap">
                        <a href="{{url('/admin/shipping-order-details/'.$item->id)}}" class="d-flex">
                          <img class="mr-3" src="{{asset('public/products/'.$item->product->image[0])}}" alt="img"/>
                          <div class="shipping_info pt-0">
                              <h5 class="mb-2">{{ $item->product->name }}</h5>
                              <div class="d-flex justify-content-between align-items-end">
                                <ul class="list-inline mb-0 black_cl">
                                  <li class="list-inline-item mr-3">Quantity: <span class="black_cl">{{$item->quantity }}</span></li>
                                  <li class="list-inline-item mr-3">Price: <span class="black_cl">$ {{$item->price}}</span></li>
                                  <li class="list-inline-item"><span><img class="img_none mr-1 align-middle" src="{{asset('public/assets/img/calender.png')}}" alt="icon"/>{{ date('d-m-Y',strtotime($item->created_at)) }}</span></li>
                                </ul>
                              </div>                           
                          </div>
                        </a>
                      </div>      
                    @endforeach
                  
 

                </div>
                <!--End shipping-orders-->
                <!--past-orders-->
                <div role="tabpanel" class="tab-pane fade" id="past-orders">
                @foreach($PastOrders as $PastOrder)
                  <div class="shipping_wrap">
                    <a href="complete-orders-details.html" class="d-flex">
                      @if(!empty($PastOrder->product))
                    <img class="mr-3" src="{{asset('public/products/'.$PastOrder->product->image[0])}}" alt="img"/>
                    @else
                    <img class="mr-3" src="{{asset('public/asset/img/46-46.png')}}" alt="img"/>
                    @endif
                    <div class="shipping_info pt-0">
                        <h5 class="mb-2">{{$PastOrder->product->name}}</h5>
                        <div class="d-flex justify-content-between align-items-end">
                          <ul class="list-inline mb-0 black_cl">
                            <li class="list-inline-item mr-3">Quantity: <span class="black_cl">{{$PastOrder->quantity}}</span></li>
                            <li class="list-inline-item mr-3">Price: <span class="black_cl">$ {{$PastOrder->price}}</span></li>
                            <li class="list-inline-item"><span class="badge badge-pill orange_btn_light">{{ ($PastOrder->status == '3')? 'Delivered':'Cancel & Refund' }}</span></li>
                          </ul>
                        </div>                           
                    </div>
                    </a>
                  </div>
                 
                 @endforeach
                
               
                </div>
                <!--past-orders-->
              </div>
            </div>                
          </div>
        </div>
      </div>
      <div class="col-xl-5 col-md-5">
        <div class="ms-panel">
          <div class="ms-panel-header d-flex justify-content-between align-items-baseline">
              <h4 class="mb-0">Chat On Order</h4>
              <a href="messages.html" class="btn green_btn">View All</a>
          </div>
          <div class="ms-panel-body">
              <div class="chat_scroll shipping_scroll">
                <div class="chat_thread d-flex">
                  <img class="mr-3" src="assets/img/51-51.png" alt="alt"/>
                  <div class="chat_thread_data">
                      <h5>John Rimishe</h5>
                      <p class="mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam blandit egestas augue vitae sagittis. In maximus ornare sem...</p>
                      <small class="grey_cl">2 mins ago</small>
                  </div>
                </div>
                <div class="chat_thread d-flex">
                  <img class="mr-3" src="assets/img/51-51.png" alt="alt"/>
                  <div class="chat_thread_data">
                      <h5>John Rimishe</h5>
                      <p class="mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam blandit egestas augue vitae sagittis. In maximus ornare sem lacinia congue. </p>
                      <small class="grey_cl">2 mins ago</small>
                  </div>
                </div>
                <div class="chat_thread d-flex">
                  <img class="mr-3" src="assets/img/51-51.png" alt="alt"/>
                  <div class="chat_thread_data">
                      <h5>John Rimishe</h5>
                      <p class="mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam blandit egestas... </p>
                      <small class="grey_cl">2 mins ago</small>
                  </div>
                </div>
                <div class="chat_thread d-flex">
                  <img class="mr-3" src="assets/img/51-51.png" alt="alt"/>
                  <div class="chat_thread_data">
                      <h5>John Rimishe</h5>
                      <p class="mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam blandit egestas augue vitae sagittis. In maximus ornare sem lacinia congue. </p>
                      <small class="grey_cl">2 mins ago</small>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-xl-12 col-md-12">
        <div class="ms-panel">
          <div class="ms-panel-header d-flex justify-content-between">
              <h4 class="mb-0">Running Orders</h4>
              <a class="btn green_btn" href="{{url('/admin/running-orders')}}">View All</a>
          </div>
          <div class="ms-panel-body">
            <div class="running_orders_summary table-responsive">
                <!----table---->
                <table id="example" class="running_order table table-striped dataTable_custom" style="width:100%">
                  <thead>
                      <tr>
                          <th>Order ID</th>
                          <th>Product</th>
                          <th>Vendor</th>
                          <th>Quantity</th>
                          <th>Payment</th>
                          <th>Status</th>
                          <th>Price</th>
                      </tr>
                  </thead>
                  <tbody>
           @foreach($items as $item)
                      <tr>
                          <td>#000000{{$item->order_id}}</td>
                          <td class="product_tuc">
                            <div class="d-flex align-items-center">
                              <img class="mr-3" src="{{asset('public/products/'.$item->product->image[0])}}" alt="image"/>
                              <h6 class="mb-0">{{($item->product == null)?'No-name':$item->product->name}}</h6>
                            </div>
                          </td>
                          <td><span class="orange_cl">{{(isset($item->product->soldBy))?$item->product->soldBy->name:'NO-Name'}}</span></td>
                          <td>2</td>
                          <td><span class="green_cl">{{($item->price !==null)? 'Paid':'Cash-on-delivery'}}</span></td>
                          <td><span class="badge orange_badge"><?php 
                          if($item->status === '1'){
                            echo 'Pending';
                          }else if($item->status === '2'){
                            echo 'Shipped';
                          }else if($item->status === '3'){
                            echo 'Out for Delivery';
                          }
                          ?></span></td>
                          <td>$ {{$item->price}}</td>
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