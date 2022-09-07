@extends('layouts.app')




@section('content')
<div class="ms-content-wrapper">
    <!--breadcrumbs-->
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="vender-products.html"><img src="{{asset('public/assets/img/vendor.svg')}}"> Product Management</a></li>
            <li class="breadcrumb-item">Product Details</li>
            <li class="breadcrumb-item active">Add Product</li>
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
            </div>
        </div>
    </div>
        <div class="col-xl-12 col-md-12">
            <div class="ms-panel">
                <div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
                   <h5 class="mb-0 pb-0">Vendor Information</h5>
                </div>
                <div class="form-row px-4 pt-3">
                    <div class="col-md-4 mb-2">
                      <label>Vendor Name</label>
                      <div class="input-group">
                        <select class="form-control" id="exampleSelect">
                            <option value="1">Gupta Enterprises</option>
                            <option value="2">Gupta Enterprises 1</option>
                            <option value="3">Gupta Enterprises 2</option>
                            <option value="4">Gupta Enterprises 3</option>
                            <option value="5">Gupta Enterprises 4</option>
                          </select>
                      </div>
                    </div>
                    <div class="col-md-4 mb-2">
                      <label>Manager Assigned</label>
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="Marchel Rose" disabled>
                      </div>
                    </div>
                    <div class="col-md-4 mb-2">
                      <label>Contact</label>
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="+91-9878767487" disabled>
                      </div>
                    </div>
                  </div>   
            </div>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="ms-panel">
                <div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
                   <h5 class="mb-0 pb-0">Main information</h5>
                </div>
                <div class="ms-panel-body">
                <div class="row">
               <div class="col-md-12">
                 <div class="d-block d-lg-flex mb-3">
                  <div class="position-relative add_product">
                    <div class="upload_green">
                       <img src="{{asset('public/assets/img/upload_banner.svg')}}"/>
                    </div>
                    <div class="input_upload"><input type="file" class="custom-file-input" id="validatedCustomFile"></div>
                   </div>
                   <div>
                    <ul class="d-block d-lg-flex col-gap align-items-center">
                      <li>
                        <div class="more_infromation position-relative">
                          <img src="{{asset('public/assets/img/head_phone.png')}}" alt="" />
                          <span><a href="javascript:;"><img src="{{asset('public/assets/img/close_icon.svg')}}"/></a></span>
                         </div>
                      </li>
                      <li>
                        <div class="more_infromation position-relative">
                          <img src="{{asset('public/assets/img/head_phonethree.png')}}" alt="" />
                          <span><a href="javascript:;"><img src="{{asset('public/assets/img/close_icon.svg')}}"/></a></span>
                         </div>
                      </li>
                      <li>
                      <div class="more_infromation position-relative">
                        <img src="{{asset('public/assets/img/head_phonetwo.png')}}" alt="" />
                        <span><a href="javascript:;"><img src="{{ asset('public/assets/img/close_icon.svg') }}"/></a></span>
                      </div>
                      </li>
                    </ul>
                   </div>
                 </div>
               </div>
               <div class="col-md-12">
                <div class="form-row">
                  <div class="col-md-4 mb-3">
                    <label class="d-flex">Product name *
                      <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum">
                        <img src="{{asset('public/assets/img/question_mark.svg')}}"/>
                      </span>
                    </label>
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Enter Product Name" name="name" value="{{$product->name}}">
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="validationCustom02" class="d-flex">Brand<span class="ml-auto"  data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Enter brand name" name="brand" value="{{$product->brand}}">
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="validationCustom01" class="d-flex">Product Category *<span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                    <div class="input-group">
                      <select class="form-control" id="validationCustom15" required="">
                        <option value="">Select Category</option>
                        <option value="">Select Category1</option>
                        <option value="">Select Category2</option>
                    
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="validationCustom01" class="d-flex">Product Sub-Category<span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                    <div class="input-group">
                      <select class="form-control" id="validationCustom15" required="">
                        <option value="">Select Sub-Category</option>
                        <option value="">Select Sub-Category2</option>
                        <option value="">SSelect Sub-Category3</option>
                    
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="validationCustom02" class="d-flex">Color<span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="color" value="{{$product->color}}" placeholder="Enter color">
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="validationCustom02" class="d-flex">Description<span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                    <div class="input-group">
                      {{-- <textarea cols="5" rows="2" class="form-control" name="description">{{ $product->description }}</textarea> --}}
                      <input type="text" class="form-control" value="{{$product->description}}" name="description" placeholder="Type Here...">
                    </div>
                  </div>
                   <div class="col-md-4 mb-3">
                    <label for="validationCustom02" class="d-flex">Quantity<span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="quantity" value="{{ $product->quantity }}" placeholder="Enter quantity">
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="validationCustom02" class="d-flex">Weight<span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                    <div class="input-group">
                      <input type="text" name="weight" value="{{$product->weight}}" class="form-control" placeholder="Enter weight">
                    </div>
                  </div>
                </div>
               </div>
              </div>
            </div>
            </div>
        </div>
        <div class="col-xl-12 col-md-12">
          <div class="ms-panel">
              <div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
                 <h5 class="mb-0 pb-0">Conditions <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></h5>
              </div>
              <div class="form-row px-4 pt-3 pb-3">
                  <div class="col-md-4 mb-2">
                    <div class="green_pargh">
                      <input class="form-check-input" value="new" type="radio" name="condition">
                      <div class="add-category-btn">
                      <h6>New</h6>
                      <p class="mb-0">123 Lorem ipsum dolor sit am et, consectetur dipiscing elit dolor sit amet.</p>
                    </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-2">
                    <div class="green_pargh">
                      <input class="form-check-input" value="like_new" type="radio" name="condition">
                      <div class="add-category-btn">
                      <h6>Like New</h6>
                      <p class="mb-0">Lorem ipsum dolor sit am et, consectetur dipiscing elit dolor sit amet.</p>
                    </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-2">
                    <div class="green_pargh">
                      <input class="form-check-input" value="old" type="radio" name="condition">
                      <div class="add-category-btn">
                      <h6>Like New</h6>
                      <p class="mb-0">Lorem ipsum dolor sit am et, consectetur dipiscing elit dolor sit amet.</p>
                    </div>
                    </div>
                  </div>
                </div>   
          </div>
      </div>
        <div class="col-xl-12 col-md-12">
          <div class="ms-panel">
              <div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
                 <h5 class="mb-0 pb-0">Dimensions (Optional) <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></h5>
              </div>
              <div class="form-row px-4 pt-3">
                <div class="col-md-12">
                  <p class="fs-16 grey_cl">If this product needs to mention dimensions.</p>
                </div>
                @php
                    $dimensions = json_decode($product->dimensions, true);
                 
                @endphp
                  <div class="col-md-4 mb-2">
                    <label>Length (Inches)</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="Length" value="{{ $dimensions['Length'] }}" placeholder="Enter Length">
                    </div>
                  </div>
                  <div class="col-md-4 mb-2">
                    <label>Width (Inches)</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="Breadth" value="{{ $dimensions['Breadth'] }}" placeholder="Enter Width">
                    </div>
                  </div>
                  <div class="col-md-4 mb-2">
                    <label>Height (Inches)</label>
                    <div class="input-group">
                      <input type="text"  name="Height"  value="{{ $dimensions['Height'] }}" class="form-control" placeholder="Enter Height ">
                    </div>
                  </div>
                </div>   
          </div>
      </div>
        
      <div class="col-xl-12 col-md-12">
        <div class="ms-panel">
          <div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
             <h5 class="mb-0 pb-0">All Permissions Applied <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"></span></h5>
          </div>
          <div class="ms-panel-body mt-2 d-flex align-items-center justify-content-between pb-3">
            <div>
              <h6>Available For Sales</h6>
              <p>This will make this product available to purchase for users.</p>
            </div>
            <div>
              <label class="ms-switch">
                <input type="checkbox" name="available_for_sale" @if($product->available_for_sale =='1') checked @endif> <span class="ms-switch-slider round"></span>
              </label>
            </div>
          </div>
          <div class="ms-panel-body d-flex align-items-center justify-content-between pt-0 pb-3">
            <div>
              <h6>Can Customer Contact?</h6>
              <p>This will make user to contact with the store manager for any query.</p>
            </div>
            <div>
                <label class="ms-switch">
                  <input type="checkbox" checked=""> <span class="ms-switch-slider ms-switch-warning round"></span>
                </label>
            </div>
          </div>
          <div class="ms-panel-body d-flex align-items-center justify-content-between pt-0 pb-3">
            <div>
              <h6>Inventory Tracking </h6>
              <p>This will make you aware about the stock quantity left.</p>
            </div>
            <div>
              <label class="ms-switch">
                <input type="checkbox"> <span class="ms-switch-slider round"></span>
              </label>
            </div>
          </div>
          <div class="ms-panel-body d-flex align-items-center justify-content-between pt-0 pb-3">
            <div>
              <h6>Show/Hide Offer for this Product </h6>
              <p>This will make you aware about the stock quantity left.</p>
            </div>
            <div>
              <label class="ms-switch">
                <input type="checkbox"> <span class="ms-switch-slider round"></span>
              </label>
            </div>
          </div>
      </div>
    </div>

    <div class="col-xl-12 col-md-12">
      <div class="ms-panel">
          <div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
             <h5 class="mb-0 pb-0">Shipping 
          </h5>
          <div class="form-check pl-0">
            <label class="ms-checkbox-wrap mb-1">
              <input class="form-check-input" type="checkbox" value="" id="invalidCheck">
              <i class="ms-checkbox-check"></i>
            </label>
            <span class="green_cl"> Free Shipping </span>
          </div>
          </div>
          <div class="form-row px-4 pt-3">
              <div class="col-md-6 mb-2">
                <label>Ships from (zip code) <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Enter Length">
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <label>Shipping Type <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Enter Width">
                </div>
              </div>
           
            </div>   
      </div>
  </div>

  <div class="col-xl-12 col-md-12">
    <div class="ms-panel">
        <div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
           <h5 class="mb-0 pb-0">Pricing</h5>
        </div>
        <div class="form-row px-4 pt-3">
            <div class="col-md-6 mb-2">
              <label>Set Price <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Enter Length">
              </div>
            </div>
            <div class="col-md-6 mb-2">
              <label>Apply Discount (Optional) <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
              <div class="input-group">
                <select class="form-control">
                  <option value="">Select Category</option>
                  <option value="">Select Category1</option>
                  <option value="">Select Category2</option>
                </select>
              </div>
              
            </div>
         
          </div>   
    </div>
</div>


<div class="col-xl-12 col-md-12">
  <div class="ms-panel">
      <div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
         <h5 class="mb-0 pb-0">Return & Refund</h5>
      </div>
      <div class="form-row px-0 pt-3">
        <div class="ms-panel-body d-flex align-items-center justify-content-between pt-0 pb-3 w-100">
          <div>
            <h5>Allow Return & Refund for this product</h5>
            <h4 class="grey_cl mb-0 pb-0">This will allow customer to make return and refund request.</h4>
          </div>
          <div>
              <label class="ms-switch">
                <input type="checkbox" checked=""> <span class="ms-switch-slider ms-switch-warning round"></span>
              </label>
          </div>
        </div>
        <div class="ms-panel-body pt-3">
          <h5 class="fs-16">Date Till Refund & Return Applicable</h5>
          <div class="input-group">
            <input type="date" class="form-control" placeholder="dd-mm-yy">
          </div>
        </div>
        </div>   
  </div>
</div>


        <div class="col-xl-12 col-md-12">
        <div class="ms-panel">
            <div class="ms-panel-body">
            <div class="row">
            <div class="col-md-6">
                <div class="d-flex">
                <div>
                <p class="mb-0 black_cl fs-16">Selling fee (8%)</p>
                <h6 class="orange_cl">$9.12</h6>
                </div>
                <div class="pl-4">
                <p class="mb-0 black_cl fs-16">You earn (min-max):</p>
                <h6 class="orange_cl">$86.53 — $93.12</h6>
                </div>
            </div>
            </div>
            <div class="col-md-6 text-right">
                <a role="button" href="add-advance.html" class="btn advance_btn mt-0 px-5">Advance</a>
                <a role="button" href="vender-products.html" class="btn track_order_but mt-0 px-4">Add Product</a>
            </div>
            </div>
        </div>
        </div>
        </div>
            </div>
            <!--shipping-orders-->
        </div>
@endsection