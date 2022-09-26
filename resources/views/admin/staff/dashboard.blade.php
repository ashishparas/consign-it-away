@extends('layouts.app')




@section('content')

<div class="ms-content-wrapper">
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
          <p class="grey_cl fs-16 pb-3">Last Update: {{date('d M, Y', strtotime(Auth::user()->updated_at))}} | {{date('h:i A', strtotime(Auth::user()->updated_at))}}</p>
        </div>
      </div> 

 <!--breadcrumbs-->
 <div class="row">
    <div class="col-md-6">
        <div class="ms-panel">
            <div class="ms-panel-header d-flex align-items-center justify-content-between">
                <div>
                    <h3 class="mb-0 pb-0 fs-20">00</h3>
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
          <h3 class="mb-0 pb-0 fs-20">00</h3>
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
                    <h3 class="mb-0 pb-0 fs-20">00</h3>
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
{{-- end --}}


</div>

@endsection