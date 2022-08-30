@extends('layouts.app')

@section('content')
<div class="ms-content-wrapper">
    <!--breadcrumbs-->
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><img src="{{asset('public/assets/img/home.svg')}}" alt="img">Dashboard</li>
          </ol>
        </nav>
      </div>
      <div class="col-md-12">
        <h3>Welcome Back, <strong>{{Auth::user()->name}}!</strong></h3>
        <p class="grey_cl fs-16 pb-3">Last Update: 01 Aug, 2022 | 09:02 AM</p>
      </div>
    </div> 
    <!--breadcrumbs-->
    <div class="row">
            <div class="col-md-6">
                <div class="ms-panel">
                    <div class="ms-panel-header d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="mb-0 pb-0 fs-20">{{ $UserCount }}</h3>
                            <p class="mb-0 pb-0 pt-0">Total No. of
                                User</p>
                        </div>
                        <div>
                            <img src="{{asset('public/assets/img/user_icon.svg')}}" alt=""/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            <div class="ms-panel">
              <div class="ms-panel-header d-flex align-items-center justify-content-between">
                <div>
                  <h3 class="mb-0 pb-0 fs-20">{{ $trackUser; }}</h3>
                  <p class="mb-0 pb-0 pt-0">Total No. of
                  Visitors</p>
                </div>
              <div>
              <img src="{{asset('public/assets/img/radar.svg')}}" alt=""/>
              </div>
              </div>
            </div>
            </div>
            <div class="col-md-6">
                <div class="ms-panel">
                    <div class="ms-panel-header d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="mb-0 pb-0 fs-20">{{ $OrderCount }}</h3>
                            <p class="mb-0 pb-0 pt-0">Total No. of
                                Order Placed</p>
                        </div>
                        <div>
                            <img src="{{asset('public/assets/img/order-delivery.svg')}}" alt=""/>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!--shipping-orders-->
    <div class="row">
        <div class="col-md-6">
            <div class="ms-panel common_card_h">
                <div class="ms-panel-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Most Top Selling Product</h4>
                    <span class="requests_counts_two">00</span>
                </div>
               <div>No data</div>
               <div class="ms-panel-body border-bottom-0 auto_scroll">
            @foreach ($mostPopulars as $mostPopular)

                  <a href="" class="pb-3 mb-3 border-bottom d-block">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex mb-3 align-items-center">
                          @php
                        if(isset($mostPopular->product->image[0])):
                          $image = $mostPopular->product->image[0];
                        endif;
                          @endphp
                          <div class="mr-3"><img src="{{asset('public/products/'. $image)}}" alt="alt" width="90px" height="60px"></div>
                            <div class="chat_thread_data mt-3 flex_1">
                                <h5 class="mb-0 mr-2 pr-lg-5 pr-0">{{ ($mostPopular->Product)? $mostPopular->Product->name: 'No Name' }}</h5>
                                <p class="mb-1 fs-2 p">Vendor: <span class="green_cl">{{  ($mostPopular->SoldBy)? $mostPopular->SoldBy->name: 'No-Name' }}</span></p>
                            </div>
                        </div>
                    </div>
                    <p class="mb-1 fs-2 p">No. of Product sell: <span class="black_cl mb-2">{{ $mostPopular->count }}</span></p>                          
                  </a>

            @endforeach
                  

                </div>
               </div>
        </div>
        <div class="col-md-6">
                <div>
                  <div class="ms-panel">
                    <div class="ms-panel-header d-lg-flex d-block">
                      <div class="text-left w-25 w-m-50">
                        <label class="fs-12 grey_cl pb-0 mb-0">Month</label>
                        <select class="form-control p-0 px-2" id="exampleFormControlSelect1">
                          <option>August</option>
                          <option>Sept</option>
                          <option>Dec</option>
                        </select>
                      </div>
                      <div class="text-center w-50">
                        <p><img src="{{asset('public/assets/img/dollar-img.png')}}" alt=""/></p>
                        <h2>${{ $transaction }}</h2>
                        <p class="p">Total Revenue Generated</p>
                        <p class="grey_cl">August 2020</p>
                      </div>
                    </div>
                  </div>
                </div>
                <!--------right side------->
                <div>
                  <div class="ms-panel">
                    <div class="ms-panel-header d-lg-flex d-block">
                      <div class="text-left w-m-100">
                        <div class="pb-3">
                        <label class="fs-12 grey_cl pb-0 mb-0">Month</label>
                        <select class="form-control p-0 px-2 w-50">
                          <option>August</option>
                          <option>Sept</option>
                          <option>Dec</option>
                        </select>
                      </div>
                      <div>
                        <h5>Total Income Generated</h5>
                        <h6 class="grey_cl font-weight-normal fs-14">August 2020</h6>
                      </div>
                      </div>
                      <div class="text-center green_light d-flex align-items-center justify-content-center ml-auto w-50 rounded w-m-100 p-4 p-lg-3">
                        <h3 class="mb-0">${{ $transaction }}</h3>
                      </div>
                    </div>
                  </div>
                </div>
        </div>

        <div class="col-xl-12 col-md-12">
          <div class="ms-panel">
            <div class="ms-panel-header d-flex justify-content-between">
                <h4 class="mb-0">Tranactions</h4>
                <a class="btn green_btn" href="{{url('admin/view/transactions')}}">View All</a>
            </div>
            <div class="ms-panel-body">
              <div class="running_orders_summary table-responsive">
                  <!----table---->
                  <table class="running_order table table-striped dataTable_custom" style="width:100%">
                    <thead>
                        <tr>
                            <th>Trans. ID</th>
                            <th>Vendor</th>
                            <th>Date</th>
                            <th>Contact</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                      <tr>
                          <td>#{{ $transaction->transaction_id }}</td>
                          <td>
                            <div class="d-flex align-items-center product_tuc">
                              <div class="img-left mr-2">
                                  @if(!empty($transaction->vendor->profile_picture))
                                  <img class="mr-3" src="{{asset('public/vendor/'.$transaction->vendor->profile_picture)}}" alt="image"/>
                                  @else
                                  <img class="mr-3" src="{{asset('public/asset/img/46-46.png')}}" alt="img"/>
                                  @endif
                                  
                                  </div>
                              <div class="pargh-block"><h6 class="mb-0">{{ $transaction->vendor->name }}</h6></div>
                            </div>
                          </td>
                          <td>{{ date('d-m-Y',strtotime($transaction->order_date)) }}</td>
                          <td>{{ $transaction->vendor->phonecode }}-{{ $transaction->vendor->mobile_no }}</td>
                          <td>$ {{ $transaction->price }}</td>
                          <td>{{ ($transaction->payment_status == '1')? 'Success':'Pending Or Failed' }}</td>
                          
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
</div>
@endsection
