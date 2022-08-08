@extends('layouts.app')


@section('content')

<div class="ms-content-wrapper">
    <!--breadcrumbs-->
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><img src="{{asset('public/assets/img/warning.svg')}}" alt="img">Report Management</li>
          </ol>
        </nav>
      </div>
    </div>
    <!--shipping-orders-->
    <div class="row">
        <div class="col-xl-12 col-md-12">
          <div class="ms-panel">
            <div class="ms-panel-header d-flex justify-content-between">
                <h4 class="mb-0">Report Listing</h4>
            </div>

          @foreach($contacts as $contact)
          <div class="ms-panel-body d-flex mb-0 pb-2">
            <a href="{{url('/admin/report-detail/'.$contact->id)}}" class="d-flex">
                @php
                    $image = ($contact->image == null)? 'no-image.png':$contact->image;
                @endphp
            <div class="product_block mr-3 mt-2"><img src="{{asset('public/vendor/'.$image)}}" class="rounded-circle img-fluid" alt="img" /></div>
            <div class="flex_1">
                <h5 class="d-flex align-items-center">{{$contact->name}}<span class="ml-auto fs-14 grey_cl">{{date('d-M-Y', strtotime($contact->created_at))}}</span></h5>
                <p class="grey_cl mb-2 fs-16">{{$contact->comment}}</span>
            </div>
            </a>
          </div>
          @endforeach 
           
              

          
          </div>              
        </div>
    </div>
  </div>

@endsection