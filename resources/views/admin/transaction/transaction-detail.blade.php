@extends('layouts.app')


@section('content')

<div class="ms-content-wrapper">
        <!--breadcrumbs-->
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="#"><img src="{{ asset('public/assets/img/transaction.svg') }}">Transactions Management</a></li>
                <li class="breadcrumb-item active">Transaction Details</li>
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
                    <h3>Transaction Details</h3>
                    <span class="ml-auto">
                        <a href="transactions-mgt-invoice.html" class="btn green_btn">Generate Invoice</a>
                    </span>
                </div>
                <div class="d-flex align-items-center w-100 py-2 px-4 border-bottom pb-3 mb-3">
                  <div class="font-weight-bold">Transaction ID: #{{ $transaction->transaction_id }}</div>
                  <div class="ml-auto fs-14 grey_cl">Trans. Date: {{ date('d-m-Y',strtotime($transaction->created_at)) }}</div>
                </div>
                <div class="d-flex w-100 py-2 px-4 justify-content-between">
                    <div class="col-md-5">
                      <h6>Bill To:</h6>
                      <h5 class="green_cl">{{ $transaction->vendor->name }}</h5>
                      <p class="border-bottom pb-3">
                        <span class="float-left"><img src="{{ asset('public/assets/img/address_black.svg') }}" alt="img" class="mr-2"></span>
                        Second Floor, Plot No. 82, Okhla Industrial Estate, Phase - III.</p>
                        <div class="d-flex align-items-center justify-content-between">
                          <span class="grey_cl">Fax No:</span>
                          <p>8578490303</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                          <span class="grey_cl">Manager:</span>
                          <p>Rogger Smith</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                          <span class="grey_cl">Manager Contact:</span>
                          <p>+91-89876658678</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                          <span class="grey_cl">Vender Contact:</span>
                          <p>{{ $transaction->vendor->phonecode }}-{{ $transaction->vendor->mobile_no }}</p>
                        </div>
                        <span class="badge green_badge p-2 round mt-2">{{ ($transaction->payment_status == '1')? 'Success':'Pending Or Failed' }}</span>
                        <div class="d-flex justify-content-between border-top mt-3 pt-2">
                          <span class="grey_cl">Payment Mode:</span>
                          <p>987-098393<br/><span class="green_cl">PayPal ID</span></p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="receipt_bg pb-1 mb-3 px-3 py-2">
                            Receipt
                          </div>
                          <div class="d-flex w-100 py-0 px-2 justify-content-between pb-2">
                            <span class="grey_cl">Total Items</span>
                                  <p class="mb-0 pb-0">322</p>
                          </div>
                          <div class="d-flex w-100 py-0 px-2 justify-content-between pb-2">
                            <span class="grey_cl">Total Amount</span>
                                  <p class="green_cl mb-0 pb-0 green_cl">$ {{ $transaction->price }}</p>
                          </div>
                          <div class="d-flex w-100 py-0 px-2 justify-content-between border-top py-2 mt-2">
                            <span class="grey_cl">Consignment(%)- 3%</span>
                                  <p class="mb-0 pb-0 green_cl">- $ 43.98</p>
                          </div>
                          <div class="d-flex w-100 py-0 px-2 justify-content-between border-top py-2 mt-2">
                            <span class="grey_cl">Payable Amount</span>
                                  <p class="mb-0 pb-0 green_cl">$ 523.00</p>
                          </div>
                    </div>
                  </div>
                  <div class="receipt_bg mx-4 pb-1 mb-3 px-3 py-2 mt-2">
                    Any Note
                  </div>
                  <div class="d-flex w-100 py-0 px-4 justify-content-between pb-5">
                        <p class="mb-0 pb-0 pl-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus et metus eget leo semper
                        tincidunt in vitae erat. Ut vitae tortor quis quam vehicula laoreet eu sit amet odio.</p>
                  </div>
            </div>
        </div>
        </div>
        <!--shipping-orders-->
    </div>

@endsection