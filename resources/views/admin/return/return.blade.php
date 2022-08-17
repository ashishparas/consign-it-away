@extends('layouts.app')





@section('content')

<div class="ms-content-wrapper">
        <!--breadcrumbs-->
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><img src="{{asset('public/assets/img/return.svg')}}" alt="img">Returns & Refunds</li>
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
                        <h3 class="mb-0">Returns & Refunds</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-xl-7 mt-4">
              <div class="ms-panel">
                <div class="ms-panel-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Returns & Refunds</h5>
                    <!--<span>-->
                    <!--  <div class="input-group mb-0">-->
                    <!--    <select class="form-control bg-light" id="exampleSelect">-->
                    <!--        <option value="1">Select Status</option>-->
                    <!--        <option value="2">Select Status 1</option>-->
                    <!--        <option value="3">Select Status 2</option>-->
                    <!--        <option value="4">Select Status 3</option>-->
                    <!--        <option value="5">Select Status 4</option>-->
                    <!--      </select>-->
                    <!--  </div>-->
                    <!--</span>-->
                </div>
                  <!--<div class="search_box mx-auto w-100 px-4 position-relative mt-3">-->
                  <!--  <input type="text" class="form-control px-5" placeholder="Search by vendor name, plan name etc...">-->
                  <!--  <span class="position-absolute"><img src="{{asset('public/assets/img/search_black.png')}}" alt="img"></span>-->
                  <!--</div>-->
                <div class="ms-panel-body auto_scroll h-100">
                    @foreach($return as $returns)
                  <div class="d-block d-lg-flex align-items-center mb-4">
                    <div class="mr-3 img_shop"><img src="{{asset('public/products/'.$returns->product->image[0])}}" alt="img"/></div>
                    <div class="flex_1">
                      <h6 class="green_cl">{{ $returns->product->category->title }}</h6>
                      <h5>{{ $returns->product->name }}</h5>
                      <div class="d-flex align-items-center justify-content-between">
                      <div>
                        <p class="fs-14 grey_cl mb-0">Fully Return & Refunds</p>
                        <span class="grey_cl font-weight-bold">{{ date('d M Y',strtotime($returns->created_at)) }}</span>
                        <span class="orange_cl font-weight-bold pl-0 d-block d-lg-inline pl-lg-5">$ {{ $returns->price }}</span>
                      </div>
                      <div>
                    <button type="button" class="btn green_btn_light_new rounded-btn" name="button">{{ ($returns->status == '4')? 'Return Request':'Cancel & Refund' }} </button>
                      </div>
                    </div>
                    </div>
                  </div>
                  @endforeach


                </div>
              </div>
            
        </div>
        <!--shipping-orders-->
        <div class="col-md-5 col-xl-5 mt-4">
          <div class="ms-panel">
            <div class="ms-panel-header">
                <h5 class="mb-0">Cancel & Refunds</h5>
            </div>
            <div class="ms-panel-body">
                @foreach($request as $refund)
                <div class="d-flex align-items-center mb-3">
                  <div class="mr-2 align-self-start mt-1"><img src="{{asset('public/assets/img/trans_mgt_img.png')}}" alt="img" class="rounded"></div>
                  <div>
                    <h6 class="mb-0 pb-1">{{ $refund->customer->name }}</h6>
                    <p class="mb-0 pb-0">Requested for Amount: <span class="green_cl font-weight-bold">${{ $refund->price }}</span></p>
                    <!--<p class="grey_cl">Status: <span class="orange_cl">accepted from vendor</span></p>-->
                  </div>
                  <!--<div class="ml-auto">-->
                  <!--  <a role="button" class="btn green_btn_light_new" name="button" href="return-refunds-request.html">View</a>-->
                  <!--    </div>-->
                </div>

                @endforeach
            </div>
          </div>
    </div>
    </div>
    
</div>

@endsection