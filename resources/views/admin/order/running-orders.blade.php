@extends('layouts.app')





@section('content')




<div class="ms-content-wrapper">
    <!--breadcrumbs-->
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="#"><img src="{{asset('public/assets/img/shopping-bag.svg')}}"> Order Management</a></li>
            <li class="breadcrumb-item active">Running Orders</li>
          </ol>
        </nav>
      </div>
    </div>
    <!--breadcrumbs-->
    <!--shipping-orders-->
    <div class="row">
      <div class="col-xl-12 col-md-12">
        <div class="ms-panel">
          <div class="ms-panel-header">
              <h4 class="mb-0">Running Orders Listing</h4>
          </div>
          <div class="ms-panel-body table-responsive">
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
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($items as $item)
                  <tr>
                      <td>#00 {{$item->id}}</td>
                      <td class="product_tuc">
                        <div class="product_full_img">
                            @if(!empty($item->product))
                                <img class="mr-3" src="{{asset('public/products/'.$item->product->image[0])}}" alt="image"/>
                            @else
                                <img class="mr-3" src="{{asset('public/asset/img/46-46.png')}}" alt="img"/>
                           @endif
                          <h6 class="mb-0">{{($item->product == null)?'No-name':$item->product->name}}</h6>
                        </div>
                      </td>
                      <td><a href="javascript:;" class="orange_cl">@php
                      if(!empty($item->product)) {
                          if($item->product->soldBy == null){
                              echo 'No Store Added';
                          }else{
                           echo $item->product->soldBy->name;
                          }
                      }
                          @endphp</td>
                      <td>2</td>
                      <td><span class="green_cl">Paid</span></td>
                      <td><span class="badge grey_badge">
                    @php
                    if($item->status == '1'){
                        echo 'Pending';
                    }else if($item->status == '2'){
                        echo 'Shipped';
                    }else if($item->status == '3'){
                        echo 'Delivered';
                    }
                    @endphp      
                    </span></td>
                      <td>$ {{$item->price}}</td>
                      <td>
                      @if (!empty($item->product))
                      <a class="btn orange_btn"href="{{url('/admin/vendor-edit-profile/'.$item->product->store_id )}}" >View</a>
                      @else
                      <a class="btn orange_btn"href="#" >View</a>
                      @endif
                      </td>
                  </tr>
@endforeach
                               
              </tbody>
            </table>
            <!----table---->
          </div>
        </div>
      </div>
    </div>
    <!--shipping-orders-->
</div>





@endsection