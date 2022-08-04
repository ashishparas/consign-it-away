@extends('layouts.app')


@section('content')

<div class="ms-content-wrapper">
        <!--breadcrumbs-->
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="transactions-mgt.html"><img src="{{ asset('public/assets/img/transaction.svg') }}">Transactions Management</a></li>
                <li class="breadcrumb-item active">Invoice Details</li>
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
                    <h3>Invoice Details</h3>
                    <span class="ml-auto">
                        <a href="{{url('admin/invoice-pdf/'.$transaction->id)}}" class="btn green_btn">Download PDF</a>
                        <a href="{{url('admin/invoice-email/'.$transaction->id)}}" class="btn green_badge">Email Vendor</a>
                    </span>
                </div>
                <div class="d-flex align-items-center w-100 py-2 px-4 border-bottom pb-3 mb-3">
                  <div class="font-weight-bold">Invoice No: #{{ $transaction->id }}</div>
                  <div class="ml-auto fs-14 grey_cl">Date: {{ date('d-m-Y',strtotime($transaction->created_at)) }}</div>
                </div>
                <div class="d-flex w-100 py-2 px-4">
                    <div class="flex-md-grow-1 pr-4 border-right">
                      <h6>Bill To:</h6>
                      <h5 class="green_cl">{{ $transaction->item->address->fname }}  {{ $transaction->item->address->lname }}</h5>
                      <p class="border-bottom pb-3 w-75">
                        <span class="float-left"><img src="{{ asset('public/assets/img/address_black.svg') }}" alt="img" class="mr-2"></span>
                        {{ $transaction->item->address->address }} {{ $transaction->item->address->city }} {{ $transaction->item->address->state }} {{ $transaction->item->address->zipcode }}</p>
                        <div class="d-flex align-items-center justify-content-between">
                          <span class="grey_cl">Fax No:</span>
                          <p>8578490303</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                          <span class="grey_cl"> Contact:</span>
                          <p>{{ $transaction->item->address->phonecode }} {{ $transaction->item->address->mobile_no }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                          <span class="grey_cl">Email:</span>
                          <p>{{ $transaction->item->address->email }}</p>
                        </div>
                        <span class="badge green_badge p-2 round mt-2">{{ ($transaction->payment_status == '1')? 'Success':'Pending Or Failed' }}</span>
                        
                    </div>
                    <div class="flex-md-grow-1 pr-5 pl-4">
                      <h6>Bill From:</h6>
                      <h5 class="green_cl">{{ $transaction->vendor->name }}</h5>
                      <p class="border-bottom pb-3 w-75">
                        <span class="float-left"><img src="{{ asset('public/assets/img/address_black.svg') }}" alt="img" class="mr-2"></span>
                        {{ ($transaction->product)?$transaction->product->store->location:'-'}}</p>
                        <div class="d-flex align-items-center justify-content-between">
                          <span class="grey_cl">Fax No:</span>
                          <p>{{ $transaction->vendor->fax }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                          <span class="grey_cl">Role Manager:</span>
                          <p>{{ ($transaction->product->store->manager)?$transaction->product->store->manager->name :'-' }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                          <span class="grey_cl">Manager Contact:</span>
                          <p>{{ ($transaction->product->store->manager)?$transaction->product->store->manager->phonecode :'' }} - {{ ($transaction->product->store->manager)?$transaction->product->store->manager->mobile_no:'' }}</p>
                        </div>
                        <!--<div class="d-flex align-items-center justify-content-between">-->
                        <!--  <span class="grey_cl">Admin Contact:</span>-->
                        <!--  <p>+91-9899897899</p>-->
                        <!--</div>-->
                        <div class="d-flex align-items-center justify-content-between">
                          <span class="grey_cl">Transaction ID:</span>
                          <p>#{{ $transaction->transaction_id }}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between border-top mt-3 pt-2">
                          <span class="grey_cl">Payment Status:</span>
                          <p class="mb-0 pb-0">{{ ($transaction->payment_status == '1')? 'Paid':'Pending Or Failed' }}</p>
                        </div>
                       
                    </div>
                  
                  </div>
                  <div class="receipt_bg mx-3 pb-1 mb-3 px-3 py-2">
                    Receipt
                  </div>
                  <div class="d-flex w-100 py-0 px-4 justify-content-between mb-2">
                    <span class="grey_cl">Total Amount</span>
                          <p class="green_cl mb-0 pb-0 green_cl">$ {{ $transaction->price }}</p>
                  </div>
                  <div class="d-flex w-100 py-0 px-4 justify-content-between mb-2">
                    <span class="grey_cl">Consignment(%)- 3%</span>
                          <p class="mb-0 pb-0 green_cl">- $ 0.00</p>
                  </div>
                  <div class="d-flex w-100 py-0 px-4 justify-content-between mb-2">
                    <span class="grey_cl">Paid Amount</span>
                          <p class="mb-0 pb-0 green_cl">$ {{ $transaction->price }}</p>
                  </div>
                  
                  
            </div>
        </div>
        </div>
        <!--shipping-orders-->
    </div>
    
@endsection