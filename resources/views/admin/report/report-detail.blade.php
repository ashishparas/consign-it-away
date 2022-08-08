@extends('layouts.app')


@section('content')

 <div class="ms-content-wrapper">
        <!--breadcrumbs-->
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><img src="{{asset('public/assets/img/warning.svg')}}">Report Management</li>
                <li class="breadcrumb-item active">Report Details</li>
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
                    <h3>Report Details</h3>
                    <!--<span class="ml-auto">-->
                    <!--    <a href="javascript:;" class="btn green_btn_light">Resolved</a>-->
                    <!--</span>-->
                </div>
                <div class="d-flex align-items-center w-100 py-2 px-4 border-bottom pb-3 mb-3">
                  <div class="font-weight-bold black_cl fs-16">Report No: #{{ $contact->id }}</div>
                  <div class="ml-auto fs-14 grey_cl">Date : {{date('d-M-Y', strtotime($contact->created_at))}}</div>
                </div>
                <div class="d-block d-lg-flex w-100 py-2 px-4">
                  <div class="flex-md-grow-1 pr-4">
                    <h6>Reported By</h6>
                    <h5 class="green_cl">{{$contact->name}}</h5>
                    <p class="border-bottom pb-3 w-100">
                     </p>
                      <div class="d-flex align-items-center justify-content-between pb-2">
                        <span class="grey_cl">Contact:</span>
                        <p class="mb-0 pb-0">{{$contact->phonecode}} {{$contact->mobile_no}}</p>
                      </div>
                      <div class="d-flex align-items-center justify-content-between pb-2">
                        <span class="grey_cl">Email:</span>
                        <p class="mb-0 pb-0">{{$contact->email}}</p>
                      </div>
                      <div class="d-flex align-items-center justify-content-between pb-2">
                        <span class="grey_cl">Order No:</span>
                        <p class="blue_cl mb-0 pb-0">#{{$contact->order_no}}</p>
                      </div>
                    
                  </div>
                 
                 
                </div>
                  <div class="receipt_bg mx-4 pb-1 mb-3 px-3 py-2 mt-2">
                    Message
                  </div>
                  <div class="d-flex w-100 py-0 px-4 justify-content-between pb-5">
                    <p class="mb-0 pb-0 px-4 fs-16">{{$contact->comment}}.</p>
                  </div>
            </div>
        </div>
        </div>
        <!--shipping-orders-->
    </div>

@endsection