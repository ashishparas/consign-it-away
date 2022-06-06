@extends('layouts.app')


@section('content')



<div class="ms-content-wrapper">
    <!--breadcrumbs-->
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="vender-products.html"><img src="{{asset('public/assets/img/vendor.svg')}}"> Product Management</a></li>
            <li class="breadcrumb-item active">Product Details</li>
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
                    <h3 class="mb-0">Product Details</h3>
                    <span>
                        <a href="javascript:;" class="btn green_badge">Edit</a>
                        <a href="javascript:;" class="btn btn-danger">Delete</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xl-12 mt-4">
            <div class="ms-panel ms-panel-fh">
                <div class="ms-panel-body">
                    <div class="row">
                    <div class="col-md-5 col-xl-5">
                      <h6><span class="grey_cl">Product ID:</span> #00{{$product->id}}</h6>
                        <div class="exzoom hidden" id="exzoom">
                            <div class="exzoom_img_box">
                                <ul class='exzoom_img_ul'>
                                    @foreach ($product->image as $item)
                                   
                                    <li><img src="{{asset('public/products/'.$item)}}" alt="img"/></li>    
                                    @endforeach

                                    
                                    {{-- <li><img src="assets/img/clock.png" alt="img"/></li>
                                    <li><img src="assets/img/clock.png" alt="img"/></li>
                                    <li><img src="assets/img/clock.png" alt="img"/></li>
                                    <li><img src="assets/img/clock.png" alt="img"/></li>
                                    <li><img src="assets/img/clock.png" alt="img"/></li>
                                    <li><img src="assets/img/clock.png" alt="img"/></li>
                                    <li><img src="assets/img/clock.png" alt="img"/></li> --}}
                                </ul>
                            </div>
                            <div class="exzoom_nav"></div>
                            <p class="exzoom_btn">
                                <a href="javascript:void(0);" class="exzoom_prev_btn"><img src="{{asset('public/assets/img/left_arrow.svg')}}" alt="img"/></a>
                                <a href="javascript:void(0);" class="exzoom_next_btn"><img src="{{asset('public/assets/img/right_arrow.svg')}}" alt="img"/></a>
                            </p>
                        </div>
                        <div class="store_manager">
                            <h5 class="mb-4">Store Manager</h5>
                            <div class="media fs-14 pb-4 mb-3 border-bottom">
                              <div class="mr-2 align-self-center">
                                <img src="{{asset('public/assets/img/product-img1.png')}}" class="ms-img-round" alt="people">
                              </div>
                              <div class="media-body d-flex justify-content-between call_img align-items-center">
                                <div>
                                <h6 class="pb-0 mb-0">Rogger Estin</h6>
                                <p class="fs-13 my-1 text-disabled">rogger_estin@gmail.com</p>
                              </div>
                                </div>
                            </div>
                            <div class="text-center">
                              <div class="media fs-14 pb-0">
                                <div class="media-body d-flex justify-content-center call_img align-items-center">
                                <div class="call_img">
                                    <img src="assets/img/call.jpg" alt="" class="mr-2">
                                    <span class="green_cl">+91-9878765654</span>
                                </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 col-xl-7">
                        <h6 class="green_cl">{{$product->name}}</h6>
                        <h5 class="fs-15 pr-4">{{$product->description}}</h5>
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

                                <div class="d-flex pt-3 justify-content-between align-items-center">
                                    <h5 class="orange_cl fs-15 mb-0">$180.00</h5>
                                    <span class="badge red_badge p-2 px-3">Out Of Stock</span>
                                </div>
                                <p class="blue_cl pt-2 font-weight-bold">50% Discount Applied</p>
                                <div class="view_store d-flex align-items-center py-2 px-3 mt-4">
                                    <div class="shop_img mr-2"><img src="assets/img/shop_img.png" class="ms-img-round"/></div>
                                    <div>
                                        <h6 class="black_cl mb-0">Vendor</h6>
                                        <h5 class="blue_cl mb-0">Kevin Retail Private Ltd</h5>
                                    </div>
                                    <button type="button" class="btn btn-gradient-dark ml-auto mt-0 py-2 text-white">View Store</button>
                                </div>
                                <div class="row pt-4">
                                    <div class="col-md-4 col-lg-4 align-items-center">
                                        <h6 class="mb-0">Gender</h6>
                                    </div>
                                    <div class="col-md-8 col-lg-8 align-items-center">
                                       <span class="orange_cl">Man</span> 
                                    </div>
                                    <div class="col-md-4 col-lg-4 mt-4 align-items-center">
                                        <h6 class="mb-0">Select Size</h6>
                                    </div>
                                    <div class="col-md-8 col-lg-8 mt-4">
                                        <div class="d-flex align-items-center select_color_block">
                                        <button type="button" class="btn orange_btn mt-0">33 mm</button>
                                        <button type="button" class="btn btn-outline-dark mt-0 mx-2">35 mm</button>
                                        <button type="button" class="btn btn-outline-dark mt-0">37 mm</button>
                                    </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4 mt-4">
                                        <h6 class="mb-0">Tags</h6>
                                    </div>
                                    <div class="col-md-8 col-lg-8 mt-4">
                                        <div class="d-flex align-items-center">
                                        <button type="button" class="btn grey_badge black_cl mt-0">Watches</button>
                                        <button type="button" class="btn grey_badge black_cl mt-0 mx-2">Other</button>
                                    </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4 mt-4 align-items-start">
                                        <h6 class="mb-0">Description</h6>
                                    </div>
                                    <div class="col-md-8 col-lg-8 mt-4">
                                            <p class="fs-16 grey_cl">Festina men's watch F20560/4 with a stainless steel case and a 
                                                mineral glass fitted with a stainless steel bracelet.</p>
                                                <p class="mb-0 fs-16 grey_cl">Festina watches are the perfect blend of elegance and functionality. Festina offers distinguished designs, constant
                                                     technological innovation and excellent value for money.</p>
                             
                                    </div>
                                    <div class="col-md-4 col-lg-4 mt-4 align-items-start">
                                        <h6 class="mb-0">Specifications</h6>
                                    </div>
                                    <div class="col-md-8 col-lg-8 mt-4">
                                        <table class="p-2 fs-16 w-100 grey_cl">
                                            <tbody>
                            
                                              <tr>
                                                <td>Case Material</td>
                                                <td class="text-right">316l Stainless Steel</td>
                                              </tr>
                                              <tr>
                                                <td>Box thickness</td>
                                                <td class="text-right">11.8 mm</td>
                                              </tr>
                                              <tr>
                                                <td>Case shape</td>
                                                <td class="text-right">Round</td>
                                              </tr>
                                              <tr>
                                                <td>Case diameter</td>
                                                <td class="text-right">45.0 mm</td>
                                              </tr>
                                              <tr>
                                                <td>Crystal</td>
                                                <td class="text-right">Mineral</td>
                                              </tr>
                                              <tr>
                                                <td>Sphere colour</td>
                                                <td class="text-right">Green</td>
                                              </tr>
                                              <tr>
                                                <td>Strap colour</td>
                                                <td class="text-right">Grey Silver</td>
                                              </tr>
                                              <tr>
                                                <td>Strap Material</td>
                                                <td class="text-right">316l Stainless Steel</td>
                                              </tr>
                                              <tr>
                                                <td>Movement function</td>
                                                <td class="text-right">Chronograph</td>
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