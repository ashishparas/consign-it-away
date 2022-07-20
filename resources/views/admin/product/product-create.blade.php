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
                      <select class="form-control" id="exampleSelect" name="store" required>
                          <option value="">Select store</option>
                        @foreach ($stores as $store)
                          <option value="{{ $store->id }}">{{ $store->name }}</option>  
                        @endforeach
                          
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
                      <span><a href="javascript:;"><img src="{{asset('public/assets/img/close_icon.svg')}}"/></a></span>
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
                    <input type="text" class="form-control" placeholder="Enter Product Name">
                  </div>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="validationCustom02" class="d-flex">Brand<span class="ml-auto"  data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Enter brand name">
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
                    <input type="text" class="form-control" placeholder="Enter color">
                  </div>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="validationCustom02" class="d-flex">Description<span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Type Here...">
                  </div>
                </div>
                 <div class="col-md-4 mb-3">
                  <label for="validationCustom02" class="d-flex">Quantity<span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Enter quantity">
                  </div>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="validationCustom02" class="d-flex">Weight<span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Enter weight">
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
                    <input class="form-check-input" value="1" type="radio" name="exampleRadios">
                    <div class="add-category-btn">
                    <h6>New</h6>
                    <p class="mb-0">Lorem ipsum dolor sit am et, consectetur dipiscing elit dolor sit amet.</p>
                  </div>
                  </div>
                </div>
                <div class="col-md-4 mb-2">
                  <div class="green_pargh">
                    <input class="form-check-input" value="1" type="radio" name="exampleRadios">
                    <div class="add-category-btn">
                    <h6>Like New</h6>
                    <p class="mb-0">Lorem ipsum dolor sit am et, consectetur dipiscing elit dolor sit amet.</p>
                  </div>
                  </div>
                </div>
                <div class="col-md-4 mb-2">
                  <div class="green_pargh">
                    <input class="form-check-input" value="1" type="radio" name="exampleRadios">
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
                <div class="col-md-4 mb-2">
                  <label>Length</label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Enter Length">
                  </div>
                </div>
                <div class="col-md-4 mb-2">
                  <label>Width</label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Enter Width">
                  </div>
                </div>
                <div class="col-md-4 mb-2">
                  <label>Height</label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Enter Height">
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
              <input type="checkbox"> <span class="ms-switch-slider round"></span>
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
      <a role="button" href="javascript:;" class="btn advance_btn mt-0 px-5" id="advance-block">Advance</a>
      <a role="button" href="vender-products.html" class="btn track_order_but mt-0 px-4">Add Product</a>
    </div>
  </div>
</div>
</div>
</div>
  </div>
  <!--shipping-orders-->


    <!--add new section-->
  <div class="row" id="add_advance" style="display:none;">
    <div class="col-xl-12 col-md-12">
      <div class="ms-panel">
          <div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
             <h5 class="mb-0 pb-0">Marketing</h5>
          </div>
          <div class="form-row px-4 pt-3">
              <div class="col-md-4 mb-2">
                <label class="d-flex font-weight-bold">Meta Tags
                   <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" data-original-title="Lorem Ipsum Lorem Ipsum">
                     <img src="{{asset('public/assets/img/question_mark.svg')}}">
                    </span>
                  </label>
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Add meta tags here...">
                </div>
              </div>
              <div class="col-md-4 mb-2">
                  <label class="d-flex font-weight-bold">Meta Keywords <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"></span></label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Add meta keywords here...">
                  </div>
                </div>
                <div class="col-md-4 mb-2">
                  <label class="d-flex font-weight-bold">Product Title <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"></span></label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Enter Title for marketing">
                  </div>
                </div>
                <div class="col-md-12 mb-2">
                  <label class="d-flex font-weight-bold">Meta Description <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"></span></label>
                  <div class="input-group">
                      <textarea rows="5" class="form-control" placeholder="Type Here..."></textarea>
                    </div>
                </div>
            </div>   
      </div>
  </div>

  <div class="col-md-4">
    <div class="ms-panel">
        <div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 pb-0">Attributes <span data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"></span></h5>
         </div>
        <div class="ms-panel-body">
            <div class="form-group">
                <label for="exampleEmail">Attribute</label>
                <input type="email" class="form-control" placeholder="Enter attribute">
              </div>
              <div class="form-group">
                <label for="exampleEmail">No. of Option</label>
                    <select class="form-control" id="validationCustom15" required="">
                      <option value="">Select Category</option>
                      <option value="">Select Category1</option>
                      <option value="">Select Category2</option>
                    </select>
              </div>
              <button type="button" class="btn btn-success py-2 px-2 mt-0 fs-16">Create </button>
              <div class="d-flex justify-content-between align-items-center pt-3">
                  <h5>Color</h5>
                  <span><img src="{{asset('public/assets/img/delete_icon.svg')}}" alt=""></span>
              </div>
              <h6>Attribute Option</h6>
              <div class="green_input">
                <div class="img_box">
                  <img src="{{asset('public/assets/img/upload_banner.svg')}}" alt="">
                  <div class="upload_input"><input type="file" class="custom-file-input" id="validatedCustomFile"></div>
                </div>
                <input type="text" class="form-control" placeholder="Green">
                <span><img src="{{asset('public/assets/img/delete_icon.svg')}}"></span>
              </div>
              <div class="green_input mt-3">
                <div class="img_box">
                  <img src="{{asset('public/assets/img/upload_banner.svg')}}" alt="">
                  <div class="upload_input"><input type="file" class="custom-file-input" id="validatedCustomFile"></div>
                </div>
                <input type="text" class="form-control" placeholder="Enter Color">
                <span><img src="{{asset('public/assets/img/delete_icon.svg')}}"></span>
              </div>
              <button type="button" class="btn btn-success py-2 px-2 mt-0 fs-16 mt-3">Add </button>
            </div>
    </div>
</div>
  

<div class="col-md-8">
  <div class="ms-panel">
      <div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
          <h5 class="mb-0 pb-0">Varients </h5>
       </div>
      <div class="ms-panel-body">
          <div class="table-responsive">
              <table class="table table-bordered advance_table">
                <thead>
                  <tr>
                    <th scope="col">
                        <label class="ms-checkbox-wrap">
                      <input type="checkbox" value=""> <i class="ms-checkbox-check"></i>
                    </label>
                      </th>
                    <th scope="col">Attritubes</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><label class="ms-checkbox-wrap">
                      <input type="checkbox" value=""> <i class="ms-checkbox-check"></i>
                    </label></td>
                    <td>Sizes</td>
                    <td>
                      <div class="size_small">s</div>
                      <div class="size_small">M</div>
                      <div class="size_small">L</div>
                      <div class="size_small">XL</div>
                    </td>    
                  </tr> 
                  <tr>
                    <td><label class="ms-checkbox-wrap">
                      <input type="checkbox" value=""> <i class="ms-checkbox-check"></i>
                    </label></td>
                    <td>Colors</td>
                    <td>
                      <div class="size_small">s</div>
                      <div class="size_small">M</div>
                      <div class="size_small">L</div>
                      <div class="size_small">XL</div>
                    </td>    
                  </tr> 
                </tbody>
              </table>
            </div>
          </div>
  </div>
</div>

<div class="col-md-4">
<div class="ms-panel">
    <div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
        <h5 class="mb-0 pb-0">Product Specifications <span data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"></span></h5>
     </div>
    <div class="ms-panel-body">
      <h6>State</h6>
        <div class="enter_spec">
          <div class="form-group">
            <input type="email" class="form-control" placeholder="Enter Specification">
          </div>
          <div class="form-group">
            <textarea class="form-control" rows="3">Type...</textarea>
          </div>
        </div>
          <button type="button" class="btn btn-success py-2 px-2 mt-0 fs-16 mt-0">Add </button>
        </div>
</div>
</div>


<div class="col-md-8">
<div class="ms-panel">
  <div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
      <h5 class="mb-0 pb-0">Specification List </h5>
   </div>
  <div class="ms-panel-body">
    <ul class="ms-list ms-task-block">
      <li class="ms-list-item ms-to-do-task ms-deletable mb-0 pb-1 border-bottom-0 d-flex">
        <label class="ms-todo-complete w-50 mb-0">
          Case Material
        </label>
        <div class="grey_cl text-right w-25"> 316l Stainless Steel</div>
        <button type="submit" class="close fs-14 red-text ml-auto">Delete</button>
      </li>
      <li class="ms-list-item ms-to-do-task ms-deletable mb-0 pb-1 border-bottom-0 d-flex">
        <label class="ms-todo-complete w-50 mb-0">
          Box thickness
        </label>
        <div class="grey_cl text-right w-25"> 11.8 mm</div>
        <button type="submit" class="close fs-14 red-text ml-auto">Delete</button>
      </li>
      <li class="ms-list-item ms-to-do-task ms-deletable mb-0 pb-1 border-bottom-0 d-flex">
        <label class="ms-todo-complete w-50 mb-0">
          Case shape
        </label>
        <div class="grey_cl text-right w-25">Round</div>
        <button type="submit" class="close fs-14 red-text ml-auto">Delete</button>
      </li>
      <li class="ms-list-item ms-to-do-task ms-deletable mb-0 pb-1 border-bottom-0 d-flex">
        <label class="ms-todo-complete w-50 mb-0">
          Case diameter
        </label>
        <div class="grey_cl text-right w-25"> 45.0 mm</div>
        <button type="submit" class="close fs-14 red-text ml-auto">Delete</button>
      </li>
      <li class="ms-list-item ms-to-do-task ms-deletable mb-0 pb-1 border-bottom-0 d-flex">
        <label class="ms-todo-complete w-50 mb-0">
          Crystal
        </label>
        <div class="grey_cl text-right w-25"> Mineral</div>
        <button type="submit" class="close fs-14 red-text ml-auto">Delete</button>
      </li>
      <li class="ms-list-item ms-to-do-task ms-deletable mb-0 pb-1 border-bottom-0 d-flex">
        <label class="ms-todo-complete w-50 mb-0">
          Sphere colour
        </label>
        <div class="grey_cl text-right w-25"> Green</div>
        <button type="submit" class="close fs-14 red-text ml-auto">Delete</button>
      </li>

    </ul>
</div>
</div>
</div>

<div class="col-xl-12 col-md-12">
<div class="ms-panel">
<div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
   <h5 class="mb-0 pb-0">Tags On Product <span data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"></span>
</h5>
</div>
<div class="form-row px-4 pt-3">
    <div class="col-md-6 mb-2">
      <label>Tags</label>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Enter Length">
        <button type="button" class="btn btn-success py-2 px-2 mt-0 fs-16 mt-0">Add </button>
      </div>
      <div class="pb-4">
        <a href="#" class="badge grey_badge black_cl px-3 font-weight-light">Clothing <img src="{{asset('public/assets/img/close_small.svg')}}" class="ml-2"></a>
        <a href="#" class="badge grey_badge black_cl px-3 font-weight-light">Other <img src="{{asset('public/assets/img/close_small.svg')}}" class="ml-2"></a>
      </div>
    </div>
  </div>   
</div>
</div>


<div class="col-xl-12 col-md-12">
<div class="ms-panel">
<div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
   <h5 class="mb-0 pb-0">More Details <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"></span></h5>
</div>
<div class="form-row px-4 pt-3">
    <div class="col-md-4 mb-2">
      <label class="d-flex">UPC <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" data-original-title="Lorem Ipsum Lorem Ipsum">
        <img src="{{asset('public/assets/img/question_mark.svg')}}">
       </span></label>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Enter UPC">
      </div>
    </div>
    <div class="col-md-4 mb-2">
      <label class="d-flex">SKU <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" data-original-title="Lorem Ipsum Lorem Ipsum">
        <img src="{{asset('public/assets/img/question_mark.svg')}}">
       </span></label>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Enter SKU">
      </div>
    </div>
    <div class="col-md-4 mb-2">
      <label class="d-flex">EAN<span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" data-original-title="Lorem Ipsum Lorem Ipsum">
        <img src="{{asset('public/assets/img/question_mark.svg')}}">
       </span></label>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Enter EAN">
      </div>
    </div>
    <div class="col-md-4 mb-2">
      <label class="d-flex">GTIN<span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" data-original-title="Lorem Ipsum Lorem Ipsum">
        <img src="{{asset('public/assets/img/question_mark.svg')}}">
       </span></label>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Enter GTIN">
      </div>
    </div>
    <div class="col-md-4 mb-2">
      <label class="d-flex">Ext.<span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" data-original-title="Lorem Ipsum Lorem Ipsum">
        <img src="{{asset('public/assets/img/question_mark.svg')}}">
       </span></label>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Enter Ext">
      </div>
    </div>
  </div>   
</div>
</div>

<div class="col-xl-12 col-md-12">
<div class="ms-panel">
<div class="ms-panel-body">
<div class="ms-panel-body mt-0 d-flex pl-0 align-items-center justify-content-between pb-3 pt-0">
<div>
<h6>Advertise Product on Various platform</h6>
<p>This will make you to advertise your product on various social media platform.</p>
</div>

<div>
<label class="ms-switch">
  <input type="checkbox"> <span class="ms-switch-slider round"></span>
</label>
</div>
</div>
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
<a role="button" href="vender-products.html" class="btn track_order_but mt-0 px-4">Add Product</a>
</div>
</div>
</div>
</div>
</div>
  </div>
</div>

</main>
<!-- MODALS -->
<div class="modal fade" id="reject_modal" tabindex="-1" role="dialog" aria-labelledby="reject_modal">
<div class="modal-dialog" role="document">
<div class="modal-content">

  <div class="modal-header">
    <h3 class="modal-title has-icon ms-icon-round">Reasons </h3>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  </div>

  <div class="modal-body">
    <ul class="ms-list ms-list-display lisitng-block">
      <li>
        <label class="ms-checkbox-wrap ms-checkbox-primary">
          <input type="radio" value="" name="radioExample2" checked=""> <i class="ms-checkbox-check"></i>
        </label> <span class="pl-2"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer in euismod mauris. </span>
      </li>
      <li>
        <label class="ms-checkbox-wrap ms-checkbox-secondary">
          <input type="radio" value="" name="radioExample2"> <i class="ms-checkbox-check"></i>
        </label> <span class="pl-2"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer in euismod mauris. </span>
      </li>
      <li>
        <label class="ms-checkbox-wrap ms-checkbox-success">
          <input type="radio" value="" name="radioExample2"> <i class="ms-checkbox-check"></i>
        </label> <span class="pl-2"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer in euismod mauris. </span>
      </li>
      <li>
        <label class="ms-checkbox-wrap ms-checkbox-danger">
          <input type="radio" value="" name="radioExample2"> <i class="ms-checkbox-check"></i>
        </label> <span class="pl-2"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer in euismod mauris. </span>
      </li>
      <li>
        <label class="ms-checkbox-wrap ms-checkbox-danger">
          <input type="radio" value="" name="radioExample2"> <i class="ms-checkbox-check"></i>
        </label> <span class="pl-2"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer in euismod mauris. </span>
      </li>
      <li>
        <label class="ms-checkbox-wrap ms-checkbox-danger">
          <input type="radio" value="" name="radioExample2"> <i class="ms-checkbox-check"></i>
        </label> <span class="pl-2"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer in euismod mauris. </span>
      </li>
    </ul>
    <p class="text-center"><button role="button" class="btn green_btn">Submit</button></p>
  </div>
</div>
</div>
</div>


@endsection