@extends('layouts.app')



@section('content')


<div class="ms-content-wrapper">
    <!--breadcrumbs-->
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="{{url('/admin/vendor-management')}}"><img src="{{asset('public/assets/img/vendor.svg')}}"> Vendor Management</a></li>
            <li class="breadcrumb-item active">Vendor Profile</li>
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
                    <h3 class="mb-0">Vendor Profile</h3>
                    <span>
                        <a href="javascript:;" class="btn green_btn bg-transparent green_cl">Edit Store</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-md-12">
            <div class="ms-profile-overview">
                <div class="ms-profile-cover">
                  <img class="ms-profile-img" src="{{asset('public/assets/img/vendor_img.png')}}" alt="img">
                  <div class="ms-profile-user-info">
                    <h4 class="ms-profile-username text-white">Kevin Retail Private Ltd</h4>
                    <h2 class="ms-profile-role address_icon mb-0"><img src="assets/img/address_white.svg" alt="img" class="address_img"><span class="text-white fs-14 pt-2">Second Floor, Plot No. 82, Okhla Industrial Estate, Phase - III.</span></h2>
                  </div>
                </div>
                </div>
        </div>
        
        <div class="col-md-4 col-xl-4 mt-4">
            <div class="ms-panel ms-panel-fh">
                <h5 class="border-bottom mb-0 p-3">Account Information</h5>
                <div class="ms-panel-body p-3">
                    <ul class="nav nav-tabs tabs-bordered left-tabs nav-justified" role="tablist" aria-orientation="vertical">
                        <li role="presentation"><a href="#tab7" aria-controls="tab7" class="show active" role="tab" data-toggle="tab" aria-selected="true">Store Information <span class="ml-auto"><svg xmlns="http://www.w3.org/2000/svg" width="6.751" height="11.808" viewBox="0 0 6.751 11.808">
                            <path id="right_arrow" d="M15.963,12.1,11.494,7.633a.84.84,0,0,1,0-1.192.851.851,0,0,1,1.2,0L17.752,11.5a.842.842,0,0,1,.025,1.164l-5.084,5.094a.844.844,0,1,1-1.2-1.192Z" transform="translate(-11.246 -6.196)" fill="#858585"/>
                          </svg></span></a></li>
                        <li role="presentation"><a href="#tab8" aria-controls="tab8" role="tab" data-toggle="tab" class="" aria-selected="false"> Vendor Information 
                            <span class="ml-auto"><svg xmlns="http://www.w3.org/2000/svg" width="6.751" height="11.808" viewBox="0 0 6.751 11.808">
                            <path id="right_arrow" d="M15.963,12.1,11.494,7.633a.84.84,0,0,1,0-1.192.851.851,0,0,1,1.2,0L17.752,11.5a.842.842,0,0,1,.025,1.164l-5.084,5.094a.844.844,0,1,1-1.2-1.192Z" transform="translate(-11.246 -6.196)" fill="#858585"/>
                          </svg></span></a></li>
                        <li role="presentation"><a href="#tab9" aria-controls="tab9" role="tab" data-toggle="tab" class="" aria-selected="false"> Products  <span class="ml-auto"><svg xmlns="http://www.w3.org/2000/svg" width="6.751" height="11.808" viewBox="0 0 6.751 11.808">
                            <path id="right_arrow" d="M15.963,12.1,11.494,7.633a.84.84,0,0,1,0-1.192.851.851,0,0,1,1.2,0L17.752,11.5a.842.842,0,0,1,.025,1.164l-5.084,5.094a.844.844,0,1,1-1.2-1.192Z" transform="translate(-11.246 -6.196)" fill="#858585"/>
                          </svg></span></a></li>
                        <li role="presentation"><a href="#tab10" aria-controls="tab10" role="tab" data-toggle="tab" class="" aria-selected="false"> Reviews   <span class="ml-auto"><svg xmlns="http://www.w3.org/2000/svg" width="6.751" height="11.808" viewBox="0 0 6.751 11.808">
                            <path id="right_arrow" d="M15.963,12.1,11.494,7.633a.84.84,0,0,1,0-1.192.851.851,0,0,1,1.2,0L17.752,11.5a.842.842,0,0,1,.025,1.164l-5.084,5.094a.844.844,0,1,1-1.2-1.192Z" transform="translate(-11.246 -6.196)" fill="#858585"/>
                          </svg></span></a></li>
                        <li role="presentation"><a href="#tab11" aria-controls="tab11" role="tab" data-toggle="tab" class="" aria-selected="false"> Gallery  <span class="ml-auto"><svg xmlns="http://www.w3.org/2000/svg" width="6.751" height="11.808" viewBox="0 0 6.751 11.808">
                            <path id="right_arrow" d="M15.963,12.1,11.494,7.633a.84.84,0,0,1,0-1.192.851.851,0,0,1,1.2,0L17.752,11.5a.842.842,0,0,1,.025,1.164l-5.084,5.094a.844.844,0,1,1-1.2-1.192Z" transform="translate(-11.246 -6.196)" fill="#858585"/>
                          </svg></span></a></li>
                          <li role="presentation"><a href="#tab12" aria-controls="tab12" role="tab" data-toggle="tab" class="" aria-selected="false"> Subscription  <span class="ml-auto"><svg xmlns="http://www.w3.org/2000/svg" width="6.751" height="11.808" viewBox="0 0 6.751 11.808">
                            <path id="right_arrow" d="M15.963,12.1,11.494,7.633a.84.84,0,0,1,0-1.192.851.851,0,0,1,1.2,0L17.752,11.5a.842.842,0,0,1,.025,1.164l-5.084,5.094a.844.844,0,1,1-1.2-1.192Z" transform="translate(-11.246 -6.196)" fill="#858585"/>
                          </svg></span></a></li>
                      </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-xl-8 mt-4">
            <div class="ms-panel ms-panel-fh">
                <div class="ms-panel-body p-0">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active show" id="tab7">
                          <h5 class="border-bottom mb-0 p-3 d-flex">Store Information
                            <span class="green_cl ml-auto fs-16"><img src="assets/img/green_circle.svg" class="mr-1">Active</span>
                          </h5>
                          <div class="p-3">
                          <h4 class="blue_cl">Kevin Retail Private Ltd</h4>
                          <h2 class="ms-profile-role address_icon mb-0 d-flex align-items-center pt-2 pb-3"><img src="{{asset('public/assets/img/address_black.svg')}}" alt="img" class="address_img"><span class="fs-16">Second Floor, Plot No. 82, Okhla Industrial Estate, Phase - III.</span></h2>
                          <p class="grey_cl">We allows you to walk away from the drudgery of grocery shopping and welcome an easy relaxed way of browsing and shopping for groceries. Discover new products and shop for all your food and grocery needs from the comfort of your home or office. No more getting stuck in traffic jams, paying for parking, standing in long queues and carrying heavy bags - get everything you need, when you need, right at your doorstep. Food shopping online is now easy as every product on your monthly shopping list, is now available online at bigbasket.com, India's best online grocery store.</p>
                          <h5 class="black_cl pt-2 pb-3">Manager Assigned</h5>
                          <div class="media fs-14 pb-3">
                            <div class="mr-2 align-self-center">
                              <img src="{{asset('public/assets/img/product-img1.png')}}" class="ms-img-round" alt="people">
                            </div>
                            <div class="media-body d-flex justify-content-between call_img align-items-center">
                              <div>
                              <h6 class="pb-0 mb-0">Rogger Estin</h6>
                              <p class="fs-12 my-1 text-disabled">rogger_estin@gmail.com</p>
                            </div>
                            <div class="call_img">
                                <img src="assets/img/call.jpg" alt="" class="mr-2">
                                <span class="green_cl">+91-9878765654</span>
                            </div>
                            </div>
                          </div>
                        </div>
                         </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab8">
                            <h5 class="border-bottom mb-0 p-3 d-flex">Vendor Information</h5>
                            <div class="p-3">
                            <div class="media fs-14 pb-3 media-img">
                                <div class="mr-2 align-self-center">
                                  <img src="assets/img/small_img72x72.jpg" class="" alt="people">
                                </div>
                                <div class="media-body">
                                  <h6 class="pb-0 mb-0">Roshan Girri</h6>
                                  <p class="fs-12 my-1 text-disabled">roshan_giri@gmail.com</p>
                                </div>
                               <div class="d-flex ml-auto call_img align-items-center">
                                <img src="assets/img/call.jpg" alt="" class="mr-2">
                                <span class="green_cl">+91-9878765654</span>
                               </div>
                              </div>
                              <div class="d-flex align-items-center justify-content-between pb-2">
                                  <span class="grey_cl">FAX:</span>
                                  <span class="black_cl">98378754</span>
                              </div>
                              <div class="d-flex align-items-center justify-content-between pb-2">
                                <span class="grey_cl">Bank Account No.:</span>
                                <span class="black_cl">3455-0988-788</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between pb-2">
                                <span class="grey_cl">Routing Number:</span>
                                <span class="black_cl">3455-0988-788</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="grey_cl">Address:</span>
                                <span class="black_cl">Salt Lake City, Utah, 84101, United States</span>
                            </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab9">
                            <h5 class="border-bottom mb-0 p-3 d-flex">Products</h5>
                            <div class="p-3">
                              <div class="chat_scroll shipping_scroll w-100">
                                <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="ms-card">
                                      <a href="product-details.html">
                                      <div class="ms-card-img card-img">
                                        <img src="assets/img/product_img_vector.jpg" alt="card_img">
                                      </div>
                                      <div class="ms-card-body">
                                        <h6 class="green_cl mb-1">Watch</h6>
                                        <p class="black_cl mb-0">Noise ColorFit Pro 2...</p>
                                        <div class="d-flex align-items-center pb-2">
                                            <ul class="ms-star-rating rating-fill-block mb-0">
                                                <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                              </ul>
                                              <span class="grey_cl fs-14 pt-0">(159)</span>
                                  
                                            </div>
                                            <div class="orange_cl fs-16 font-weight-bold">$180.00</div>
                                      </div>
                                      <div class="stock_block d-none">
                                        <div class="bg-white d-flex justify-content-between align-items-center p-2">
                                            <div class="d-flex flex-column fs-14">
                                              In Stock
                                              <span class="badge bg-black text-white px-3 py-2 mr-2">234</span>
                                            </div>
                                            <div class="delete_icon">
                                              <img src="assets/img/delete_icon.svg" alt="">
                                            </div>
                                        </div>
                                      </div>
                                    </a>
                                    </div>
                                  </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="ms-card">
                                      <a href="product-details.html">
                                      <div class="ms-card-img card-img">
                                        <img src="assets/img/product_img_vector.jpg" alt="card_img">
                                      </div>
                                      <div class="ms-card-body">
                                        <h6 class="green_cl mb-1">Watch</h6>
                                        <p class="black_cl mb-0">Noise ColorFit Pro 2...</p>
                                        <div class="d-flex align-items-center pb-2">
                                            <ul class="ms-star-rating rating-fill-block mb-0 rating-star">
                                                <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                              </ul>
                                              <span class="grey_cl fs-14 pt-0">(159)</span>
                                            </div>
                                            <div class="orange_cl fs-16 font-weight-bold">$180.00</div>
                                      </div>
                                      <div class="stock_block d-none">
                                        <div class="bg-white d-flex justify-content-between align-items-center p-2">
                                            <div class="d-flex flex-column fs-14">
                                              In Stock
                                              <span class="badge bg-black text-white px-3 py-2 mr-2">234</span>
                                            </div>
                                            <div class="delete_icon">
                                              <img src="assets/img/delete_icon.svg" alt="">
                                            </div>
                                        </div>
                                      </div>
                                      </a>
                                    </div>
                                  </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="ms-card">
                                      <a href="product-details.html">
                                      <div class="ms-card-img card-img">
                                        <img src="assets/img/product_img_vector.jpg" alt="card_img">
                                      </div>
                                      <div class="ms-card-body">
                                        <h6 class="green_cl mb-1">Watch</h6>
                                        <p class="black_cl mb-0">Noise ColorFit Pro 2...</p>
                                        <div class="d-flex align-items-center pb-2">
                                            <ul class="ms-star-rating rating-fill-block mb-0 rating-star">
                                                <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                              </ul>
                                              <span class="grey_cl fs-14 pt-1">(159)</span>
                                            </div>
                                            <div class="orange_cl fs-16 font-weight-bold">$180.00</div>
                                      </div>
                                      <div class="stock_block d-none">
                                        <div class="bg-white d-flex justify-content-between align-items-center p-2">
                                            <div class="d-flex flex-column fs-14">
                                              In Stock
                                              <span class="badge bg-black text-white px-3 py-2 mr-2">234</span>
                                            </div>
                                            <div class="delete_icon">
                                              <img src="assets/img/delete_icon.svg" alt="">
                                            </div>
                                        </div>
                                      </div>
                                      </a>
                                    </div>
                                  </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="ms-card">
                                      <a href="product-details.html">
                                      <div class="ms-card-img card-img">
                                        <img src="assets/img/product_img_vector.jpg" alt="card_img">
                                      </div>
                                      <div class="ms-card-body">
                                        <h6 class="green_cl mb-1">Watch</h6>
                                        <p class="black_cl mb-0">Noise ColorFit Pro 2...</p>
                                        <div class="d-flex align-items-center pb-2">
                                            <ul class="ms-star-rating rating-fill-block mb-0 rating-star">
                                                <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                              </ul>
                                              <span class="grey_cl fs-14 pt-1">(159)</span>
                                            </div>
                                            <div class="orange_cl fs-16 font-weight-bold">$180.00</div>
                                      </div>
                                      <div class="stock_block d-none">
                                        <div class="bg-white d-flex justify-content-between align-items-center p-2">
                                            <div class="d-flex flex-column fs-14">
                                              In Stock
                                              <span class="badge bg-black text-white px-3 py-2 mr-2">234</span>
                                            </div>
                                            <div class="delete_icon">
                                              <img src="assets/img/delete_icon.svg" alt="">
                                            </div>
                                        </div>
                                      </div>
                                      </a>
                                    </div>
                                  </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="ms-card">
                                      <a href="product-details.html">
                                      <div class="ms-card-img card-img">
                                        <img src="assets/img/product_img_vector.jpg" alt="card_img">
                                      </div>
                                      <div class="ms-card-body">
                                        <h6 class="green_cl mb-1">Watch</h6>
                                        <p class="black_cl mb-0">Noise ColorFit Pro 2...</p>
                                        <div class="d-flex align-items-center pb-2">
                                            <ul class="ms-star-rating rating-fill-block mb-0 rating-star">
                                                <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                              </ul>
                                              <span class="grey_cl fs-14 pt-1">(159)</span>
                                            </div>
                                            <div class="orange_cl fs-16 font-weight-bold">$180.00</div>
                                      </div>
                                      <div class="stock_block d-none">
                                        <div class="bg-white d-flex justify-content-between align-items-center p-2">
                                            <div class="d-flex flex-column fs-14">
                                              In Stock
                                              <span class="badge bg-black text-white px-3 py-2 mr-2">234</span>
                                            </div>
                                            <div class="delete_icon">
                                              <img src="assets/img/delete_icon.svg" alt="">
                                            </div>
                                        </div>
                                      </div>
                                      </a>
                                    </div>
                                  </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="ms-card">
                                      <a href="product-details.html">
                                      <div class="ms-card-img card-img">
                                        <img src="assets/img/product_img_vector.jpg" alt="card_img">
                                      </div>
                                      <div class="ms-card-body">
                                        <h6 class="green_cl mb-1">Watch</h6>
                                        <p class="black_cl mb-0">Noise ColorFit Pro 2...</p>
                                        <div class="d-flex align-items-center pb-2">
                                            <ul class="ms-star-rating rating-fill-block mb-0 rating-star">
                                                <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                              </ul>
                                              <span class="grey_cl fs-14 pt-1">(159)</span>
                                            </div>
                                            <div class="orange_cl fs-16 font-weight-bold">$180.00</div>
                                      </div>
                                      <div class="stock_block d-none">
                                      <div class="bg-white d-flex justify-content-between align-items-center p-2">
                                          <div class="d-flex flex-column fs-14">
                                            In Stock
                                            <span class="badge bg-black text-white px-3 py-2 mr-2">234</span>
                                          </div>
                                          <div class="delete_icon">
                                            <img src="assets/img/delete_icon.svg" alt="">
                                          </div>
                                      </div>
                                    </div>
                                    </a>
                                    </div>
                                  </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="ms-card">
                                      <a href="product-details.html">
                                      <div class="ms-card-img card-img">
                                        <img src="assets/img/product_img_vector.jpg" alt="card_img">
                                      </div>
                                      <div class="ms-card-body">
                                        <h6 class="green_cl mb-1">Watch</h6>
                                        <p class="black_cl mb-0">Noise ColorFit Pro 2...</p>
                                        <div class="d-flex align-items-center pb-2">
                                            <ul class="ms-star-rating rating-fill-block mb-0 rating-star">
                                                <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                              </ul>
                                              <span class="grey_cl fs-14 pt-1">(159)</span>
                                            </div>
                                            <div class="orange_cl fs-16 font-weight-bold">$180.00</div>
                                      </div>
                                      <div class="stock_block d-none">
                                      <div class="bg-white d-flex justify-content-between align-items-center p-2">
                                          <div class="d-flex flex-column fs-14">
                                            In Stock
                                            <span class="badge bg-black text-white px-3 py-2 mr-2">234</span>
                                          </div>
                                          <div class="delete_icon">
                                            <img src="assets/img/delete_icon.svg" alt="">
                                          </div>
                                      </div>
                                    </div>
                                    </a>
                                    </div>
                                  </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="ms-card">
                                      <a href="product-details.html">
                                      <div class="ms-card-img card-img">
                                        <img src="assets/img/product_img_vector.jpg" alt="card_img">
                                      </div>
                                      <div class="ms-card-body">
                                        <h6 class="green_cl mb-1">Watch</h6>
                                        <p class="black_cl mb-0">Noise ColorFit Pro 2...</p>
                                        <div class="d-flex align-items-center pb-2">
                                            <ul class="ms-star-rating rating-fill-block mb-0 rating-star">
                                                <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                              </ul>
                                              <span class="grey_cl fs-14 pt-1">(159)</span>
                                            </div>
                                            <div class="orange_cl fs-16 font-weight-bold">$180.00</div>
                                      </div>
                                      <div class="stock_block d-none">
                                      <div class="bg-white d-flex justify-content-between align-items-center p-2">
                                          <div class="d-flex flex-column fs-14">
                                            In Stock
                                            <span class="badge bg-black text-white px-3 py-2 mr-2">234</span>
                                          </div>
                                          <div class="delete_icon">
                                            <img src="assets/img/delete_icon.svg" alt="">
                                          </div>
                                      </div>
                                    </div>
                                    </a>
                                    </div>
                                  </div>
                                  <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="ms-card">
                                      <a href="product-details.html">
                                      <div class="ms-card-img card-img">
                                        <img src="assets/img/product_img_vector.jpg" alt="card_img">
                                      </div>
                                      <div class="ms-card-body">
                                        <h6 class="green_cl mb-1">Watch</h6>
                                        <p class="black_cl mb-0">Noise ColorFit Pro 2...</p>
                                        <div class="d-flex align-items-center pb-2">
                                            <ul class="ms-star-rating rating-fill-block mb-0 rating-star">
                                                <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                                <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                              </ul>
                                              <span class="grey_cl fs-14 pt-1">(159)</span>
                                            </div>
                                            <div class="orange_cl fs-16 font-weight-bold">$180.00</div>
                                      </div>
                                      <div class="stock_block d-none">
                                      <div class="bg-white d-flex justify-content-between align-items-center p-2">
                                          <div class="d-flex flex-column fs-14">
                                            In Stock
                                            <span class="badge bg-black text-white px-3 py-2 mr-2">234</span>
                                          </div>
                                          <div class="delete_icon">
                                            <img src="assets/img/delete_icon.svg" alt="">
                                          </div>
                                      </div>
                                    </div>
                                    </a>
                                    </div>
                                  </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab10">
                          <h5 class="border-bottom mb-0 p-3 d-flex">Reviews</h5>
                          <div class="p-3">
                            <div class="chat_scroll shipping_scroll w-100">
                              <div class="media clearfix">
                                <div class="py-3 pr-3"><h2 class="pb-0 mb-0">4.5<span class="small_text grey_cl">/5</span></h2></div>
                                <div class="media-body">
                                  <div class="customer-meta">
                                    <div class="new">
                                      <h6 class="ms-feed-user mb-0">3569 Ratings</h6>
                                    </div>
                                  </div>
                                  <div class="d-flex align-items-center pb-0">
                                    <ul class="ms-star-rating rating-fill-block mb-0 rating-star">
                                        <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                                        <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                        <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                        <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                        <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                      </ul>
                                      <span class="grey_cl fs-14 pt-1">(159)</span>
                                    </div>
                                </div>
                              </div>

                              <ul class="ms-list ms-feed ms-twitter-feed ms-recent-support-tickets">
                                <li class="ms-list-item pl-2">
                                  <a href="#" class="media clearfix">
                                    <img src="assets/img/51-51.png" class="ms-img-round ms-img-small" alt="">
                                    <div class="media-body">
                                      <div class="customer-meta">
                                        <div class="new">
                                          <h5 class="ms-feed-user mb-0">John Doe</h5>
                                        </div>
                                      </div>
                                      <div class="d-flex align-items-center pb-0">
                                        <ul class="ms-star-rating rating-fill-block mb-0 rating-star">
                                            <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                          </ul>
                                          <span class="grey_cl fs-14 pt-1">(159)</span>
                                        </div>
                                        <p class="d-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla luctus lectus a facilisis bibendum. Duis quis convallis sapien ...</p> 
                                      
                                    </div>
                                  </a>
                                </li>
                                
                                <li class="ms-list-item pl-2">
                                  <a href="#" class="media clearfix">
                                    <img src="assets/img/51-51.png" class="ms-img-round ms-img-small" alt="">
                                    <div class="media-body">
                                      <div class="customer-meta">
                                        <div class="new">
                                          <h5 class="ms-feed-user mb-0">John Doe</h5>
                                        </div>
                                      </div>
                                      <div class="d-flex align-items-center pb-0">
                                        <ul class="ms-star-rating rating-fill-block mb-0 rating-star">
                                            <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                          </ul>
                                 
                                        </div>
                                        <p class="d-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla luctus lectus a facilisis bibendum. Duis quis convallis sapien ...</p> 
                                      
                                      
                                    </div>
                                  </a>
                                </li>
                                <li class="ms-list-item pl-2">
                                  <a href="#" class="media clearfix">
                                    <img src="assets/img/51-51.png" class="ms-img-round ms-img-small" alt="">
                                    <div class="media-body">
                                      <div class="customer-meta">
                                        <div class="new">
                                          <h5 class="ms-feed-user mb-0">John Doe</h5>
                                          
                                        </div>
                                        
                                      </div>
                                      <div class="d-flex align-items-center pb-0">
                                        <ul class="ms-star-rating rating-fill-block mb-0 rating-star">
                                            <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                          </ul>
                                   
                                        </div>
                                        <p class="d-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla luctus lectus a facilisis bibendum. Duis quis convallis sapien ...</p> 
                                      
                                      
                                    </div>
                                  </a>
                                </li>
                                
                                <li class="ms-list-item pl-2">
                                  <a href="#" class="media clearfix">
                                    <img src="assets/img/51-51.png" class="ms-img-round ms-img-small" alt="">
                                    <div class="media-body">
                                      <div class="customer-meta">
                                        <div class="new">
                                          <h5 class="ms-feed-user mb-0">John Doe</h5>
                                          
                                        </div>
                                        
                                      </div>
                                      <div class="d-flex align-items-center pb-0">
                                        <ul class="ms-star-rating rating-fill-block mb-0 rating-star">
                                            <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                          </ul>
                                    
                                        </div>
                                        <p class="d-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla luctus lectus a facilisis bibendum. Duis quis convallis sapien ...</p> 
                                      
                                      
                                    </div>
                                  </a>
                                </li>

                                <li class="ms-list-item pl-2">
                                  <a href="#" class="media clearfix">
                                    <img src="assets/img/51-51.png" class="ms-img-round ms-img-small" alt="">
                                    <div class="media-body">
                                      <div class="customer-meta">
                                        <div class="new">
                                          <h5 class="ms-feed-user mb-0">John Doe</h5>
                                          
                                        </div>
                                        
                                      </div>
                                      <div class="d-flex align-items-center pb-0">
                                        <ul class="ms-star-rating rating-fill-block mb-0 rating-star">
                                            <li class="ms-rating-item"> <i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                            <li class="ms-rating-item rated"><i class="material-icons">star</i> </li>
                                          </ul>
                                          <span class="grey_cl fs-14 pt-1">(159)</span>
                                        </div>
                                        <p class="d-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla luctus lectus a facilisis bibendum. Duis quis convallis sapien ...</p> 
                                      
                                      
                                    </div>
                                  </a>
                                </li>
                              </ul>
                              </div>
                              </div>
                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="tab11">
                            <h5 class="border-bottom mb-0 p-3 d-flex">Gallery</h5>
                            <div class="p-3">
                            <div class="row">
                              <div class="col-md-4 col-lg-4">
                                <div class="mb-4 gallery_block"><img src="assets/img/gallery_product_img.png" class="img-fluid"></div>
                              </div>
                              <div class="col-md-4 col-lg-4">
                                <div class="mb-4 gallery_block"><img src="assets/img/gallery_product_img.png" class="img-fluid"></div>
                              </div>
                              <div class="col-md-4 col-lg-4">
                                <div class="mb-4 gallery_block"><img src="assets/img/gallery_product_img.png" class="img-fluid"></div>
                              </div>
                              <div class="col-md-4 col-lg-4">
                                <div class="mb-4 gallery_block"><img src="assets/img/gallery_product_img.png" class="img-fluid"></div>
                              </div>
                              <div class="col-md-4 col-lg-4">
                                <div class="mb-4 gallery_block"><img src="assets/img/gallery_product_img.png" class="img-fluid"></div>
                              </div>
                              <div class="col-md-4 col-lg-4">
                                <div class="mb-4 gallery_block"><img src="assets/img/gallery_product_img.png" class="img-fluid"></div>
                              </div>
                              <div class="col-md-4 col-lg-4">
                                <div class="mb-4 gallery_block"><img src="assets/img/gallery_product_img.png" class="img-fluid"></div>
                              </div>
                              <div class="col-md-4 col-lg-4">
                                <div class="mb-4 gallery_block"><img src="assets/img/gallery_product_img.png" class="img-fluid"></div>
                              </div>
                              <div class="col-md-4 col-lg-4">
                                <div class="mb-4 gallery_block"><img src="assets/img/gallery_product_img.png" class="img-fluid"></div>
                              </div>
                            </div>
                          </div>
                          </div>

                          <div role="tabpanel" class="tab-pane fade" id="tab12">
                            <h5 class="border-bottom mb-0 p-3 d-flex">Subscription</h5>
                            <div class="p-3">
                                  <h6 class="text-uppercase"><b>Free Plan</b></h6>
                                  <p class="grey_cl mb-1">Lorem Ipsum is simply dummy text of the printing & typesetting industry.</p>
                                  <span class="badge orange_btn p-2">$ 0.00 Only</span>
                                  <h5 class="pt-4 border-top mt-3 pb-3"><b>History</b></h5>
                                <div class="border history_block table-responsive">
                                  <table class="table">
                                    <thead class="thead-light">
                                      <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Plan</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Payment</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>23-09-2022</td>
                                        <td>Bronze [FREE]</td>
                                        <td>Monthy</td>
                                        <td>Active</td>
                                        <td>Paid</td>
                                      </tr>
                                      <tr>
                                        <td>12-08-2022</td>
                                        <td>Premium [$99.99]</td>
                                        <td>Monthy</td>
                                        <td>Expired</td>
                                        <td>Paid</td>
                                      </tr>
                                      <tr>
                                        <td>12-07-2022</td>
                                        <td>Unlimited [$999.00]</td>
                                        <td>Monthy</td>
                                        <td>Expired</td>
                                        <td>Paid</td>
                                      </tr>
                                      <tr>
                                        <td>23-09-2022</td>
                                        <td>Premium [FREE]</td>
                                        <td>Monthy</td>
                                        <td>Active</td>
                                        <td>Paid</td>
                                      </tr>
                                      <tr>
                                        <td>12-07-2022</td>
                                        <td>Unlimited [$999.00]</td>
                                        <td>Monthy</td>
                                        <td>Expired</td>
                                        <td>Paid</td>
                                      </tr>
                                      <tr>
                                        <td>23-09-2022</td>
                                        <td>Premium [FREE]</td>
                                        <td>Monthy</td>
                                        <td>Active</td>
                                        <td>Paid</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
        </div>
    </div>
    <!--shipping-orders-->
</div>



@endsection