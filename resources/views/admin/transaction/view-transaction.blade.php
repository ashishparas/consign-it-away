@extends('layouts.app')


@section('content')

<div class="ms-content-wrapper">
    <!--breadcrumbs-->
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><img src="{{ asset('public/assets/img/transaction.svg') }}">Transactions Management</li>
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
                <h3>Transactions Management</h3>
            </div>
        </div>
    </div>
      <div class="col-xl-6 col-md-6">
        <div class="ms-panel">
          <div class="ms-panel-header border-bottom">
              <h5 class="mb-0">Withdraw Requests</h5>
          </div>
          <div class="ms-panel-body pt-2 platform_scroll">
              <ul class="ms-followers ms-list platform_scroll ps">
                @foreach ($withdraws as $withdraw)
            
                    <li class="ms-list-item media list-block mb-2 px-0">
                <img src="{{ asset('public/vendor/'.$withdraw->user->profile_picture) }}" class="ms-img-small ms-img-round" alt="people">
                <div class="media-body">
                
                  <h6 class="pb-0">{!! $withdraw->user->name !!}</h6>
                  <h5 class="fs-16 mb-0"><span class="grey_cl font-weight-normal">Amount: </span><span class="green_cl">${{ $withdraw->amount }}</span></h5>
                  <p class="orange_cl fs-16">3 days to relies payment</p>
                </div>
                <button type="button" class="btn green_btn_light_new mr-2" name="button">Accept</button>
                <button type="button" class="btn reject_btn" name="button">Reject</button>
              </li>     
                @endforeach
               

            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-6">
        <div class="ms-panel">
            <div class="ms-panel-header border-bottom pb-2">
                <h5 class="mb-0 pb-0 d-flex">Generated Invoices <span class="ml-auto input-date-right"><input type="date" id="birthday" name="birthday"></span></h5>
            </div>
            <div class="ms-panel-body platform_scroll">
                <a href="transactions-mgt-invoice.html" class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h6 class="grey_cl mb-0 font-weight-normal fs-14">23 April 2022</h6>
                        <h6 class="mb-0 py-1">Primis Vendor's</h6>
                        <p class="blue_cl mb-0">Early Pay Out</p>
                    </div>
                    <div>
                        <p class="mb-2"><span class="grey_cl">Transaction ID: </span><strong><u>#83002GDE92E</u></strong></p>
                        <h5 class="green_cl">$ 56.70</h5>
                    </div>
                  </a>
                <a href="transactions-mgt-invoice.html" class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h6 class="grey_cl mb-0 font-weight-normal fs-14">23 April 2022</h6>
                        <h6 class="mb-0 py-1">Elder Rose Enterprises</h6>
                        <p class="blue_cl mb-0">Early Pay Out</p>
                    </div>
                    <div>
                        <p class="mb-2"><span class="grey_cl">Transaction ID: </span><strong><u>#83002GDE92E</u></strong></p>
                        <h5 class="green_cl">$ 56.70</h5>
                    </div>
                  </a>
                <a href="transactions-mgt-invoice.html" class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h6 class="grey_cl mb-0 font-weight-normal fs-14">23 April 2022</h6>
                        <h6 class="mb-0 py-1">Zumin Store</h6>
                        <p class="blue_cl mb-0">Early Pay Out</p>
                    </div>
                    <div>
                        <p class="mb-2"><span class="grey_cl">Transaction ID: </span><strong><u>#83002GDE92E</u></strong></p>
                        <h5 class="green_cl">$ 56.70</h5>
                    </div>
                  </a>
                <a href="transactions-mgt-invoice.html" class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h6 class="grey_cl mb-0 font-weight-normal fs-14">23 April 2022</h6>
                        <h6 class="mb-0 py-1">Brother's Enterprises</h6>
                        <p class="blue_cl mb-0">Early Pay Out</p>
                    </div>
                    <div>
                        <p class="mb-2"><span class="grey_cl">Transaction ID: </span><strong><u>#83002GDE92E</u></strong></p>
                        <h5 class="green_cl">$ 56.70</h5>
                    </div>
                  </a>
                <a href="transactions-mgt-invoice.html" class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h6 class="grey_cl mb-0 font-weight-normal fs-14">23 April 2022</h6>
                        <h6 class="mb-0 py-1">Brother's Enterprises</h6>
                        <p class="blue_cl mb-0">Early Pay Out</p>
                    </div>
                    <div>
                        <p class="mb-2"><span class="grey_cl">Transaction ID: </span><strong><u>#83002GDE92E</u></strong></p>
                        <h5 class="green_cl">$ 56.70</h5>
                    </div>
                  </a>
                </div>
            </div>
      </div>
      <div class="col-xl-12 col-md-12">
        <div class="ms-panel">
          <div class="ms-panel-header d-flex justify-content-between">
              <h4 class="mb-0">Tranactions</h4>
              <span class="ml-auto input-date-right"><input type="date" id="birthday" name="birthday"> To <input type="date" id="birthday" name="birthday"></span>
          </div>
          <div class="ms-panel-body">
            <div class="running_orders_summary table-responsive">
                <!----table---->
                <table id="example" class="running_order table table-striped dataTable_custom" style="width:100%">
                  <thead>
                      <tr>
                          <th>Trans. ID</th>
                          <th>Vendor</th>
                          <th>Date</th>
                          <th>Contact</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>#B2343</td>
                          <td>
                            <div class="d-flex align-items-center product_tuc">
                              <div class="img-left mr-2"><img class="mr-3" src="{{asset('public/assets/img/46-46.png')}}" alt="image"/></div>
                              <div class="pargh-block"><h6 class="mb-0">Robbies Pvt Ltd.</h6></div>
                            </div>
                          </td>
                          <td>23-09-2022</td>
                          <td>+91-9878767656</td>
                          <td>$ 76.98</td>
                          <td>Early Pay Out</td>
                          <td><a class="btn orange_btn" href="transaction-details.html">View</a></td>
                      </tr>
                      <tr>
                        <td>#B2343</td>
                        <td>
                          <div class="d-flex align-items-center product_tuc">
                            <div class="img-left mr-2"><img class="mr-3" src="{{ asset('public/assets/img/46-46.png') }}" alt="image"/></div>
                            <div class="pargh-block"><h6 class="mb-0">Robbies Pvt Ltd.</h6></div>
                          </div>
                        </td>
                        <td>23-09-2022</td>
                        <td>+91-9878767656</td>
                        <td>$ 76.98</td>
                        <td>Early Pay Out</td>
                        <td><a class="btn orange_btn" href="transaction-details.html">View</a></td>
                    </tr>
                    <tr>
                        <td>#B2343</td>
                        <td>
                          <div class="d-flex align-items-center product_tuc">
                            <div class="img-left mr-2"><img class="mr-3" src="{{ asset('public/assets/img/46-46.png') }}" alt="image"/></div>
                            <div class="pargh-block"><h6 class="mb-0">Robbies Pvt Ltd.</h6></div>
                          </div>
                        </td>
                        <td>23-09-2022</td>
                        <td>+91-9878767656</td>
                        <td>$ 76.98</td>
                        <td>Early Pay Out</td>
                        <td><a class="btn orange_btn" href="transaction-details.html">View</a></td>
                    </tr>
                    <tr>
                      <td>#B2343</td>
                      <td>
                        <div class="d-flex align-items-center product_tuc">
                          <div class="img-left mr-2"><img class="mr-3" src="{{ asset('public/assets/img/46-46.png') }}" alt="image"/></div>
                          <div class="pargh-block"><h6 class="mb-0">Robbies Pvt Ltd.</h6></div>
                        </div>
                      </td>
                      <td>23-09-2022</td>
                      <td>+91-9878767656</td>
                      <td>$ 76.98</td>
                      <td>Early Pay Out</td>
                      <td><a class="btn orange_btn" href="transaction-details.html">View</a></td>
                  </tr>
                  <tr>
                    <td>#B2343</td>
                    <td>
                      <div class="d-flex align-items-center product_tuc">
                        <div class="img-left mr-2"><img class="mr-3" src="{{ asset('public/assets/img/46-46.png') }}" alt="image"/></div>
                        <div class="pargh-block"><h6 class="mb-0">Robbies Pvt Ltd.</h6></div>
                      </div>
                    </td>
                    <td>23-09-2022</td>
                    <td>+91-9878767656</td>
                    <td>$ 76.98</td>
                    <td>Early Pay Out</td>
                    <td><a class="btn orange_btn" href="transaction-details.html">View</a></td>
                </tr>
                <tr>
                  <td>#B2343</td>
                  <td>
                    <div class="d-flex align-items-center product_tuc">
                      <div class="img-left mr-2"><img class="mr-3" src="{{ asset('public/assets/img/46-46.png') }}" alt="image"/></div>
                      <div class="pargh-block"><h6 class="mb-0">Robbies Pvt Ltd.</h6></div>
                    </div>
                  </td>
                  <td>23-09-2022</td>
                  <td>+91-9878767656</td>
                  <td>$ 76.98</td>
                  <td>Early Pay Out</td>
                  <td><a class="btn orange_btn" href="transaction-details.html">View</a></td>
              </tr>
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