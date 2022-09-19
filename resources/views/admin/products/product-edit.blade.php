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
          @if (Session::has('success'))
              
            <div class="alert alert-success">{{ Session::get('success') }}</div>
          @endif
            <div class="ms-panel-header border-0 d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Product Details</h3>
                <input type="text" name="url" id="url" value="{{asset('')}}" />
            </div>
        </div>
    </div>
    <form action="{{ url('admin/update/product/'. $product->id) }}" method="post" enctype="multipart/form-data">
      @csrf

        <div class="col-xl-12 col-md-12">
            <div class="ms-panel">
                <div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
                   <h5 class="mb-0 pb-0">Vendor Information</h5>
                </div>
                <div class="form-row px-4 pt-3">
                    <div class="col-md-4 mb-2">
                      <label>Vendor Name</label>
                      <div class="input-group">
                        <select class="form-control" id="exampleSelect" name="store_id">
                            <option value="{{$product->soldBy->id}}">{{ $product->soldBy->name }}</option>
                          </select>
                      </div>
                    </div>
                    <div class="col-md-4 mb-2">
                      <label>Manager Assigned</label>
                      <div class="input-group">
                        <input type="text" class="form-control" value="{{$product->soldBy->manager->name}}" placeholder="Marchel Rose" disabled>
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
                    <div class="input_upload">
                      <input type="file" name="image" class="custom-file-input" id="validatedCustomFile"></div>
                   </div>
                   <div>
                    <ul class="d-block d-lg-flex col-gap align-items-center">
                      @foreach($product->image as $key => $images)
                      <li>
                        <div class="more_infromation position-relative">
                          <img src="{{asset('public/products/'. $images)}}" alt="" />
                          <span><a href="javascript:;" data-image-id="{{ $product->id }}" data-image-key = "{{ $key }}"><img class="delete-image"  src="{{asset('public/assets/img/close_icon.svg')}}"/></a></span>
                         </div>
                      </li>
                      @endforeach
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
                      <select class="form-control" id="categories" name="category_id" required="">
                        <option value="">Select Category</option>
                        @foreach ($category as $categories)
                        <option value="{{ $categories->id }}" @if($categories->id === $product->category_id) selected @endif>{{ $categories->title }}</option>
                        @endforeach
                    
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="validationCustom01" class="d-flex">Product Sub-Category<span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                    <div class="input-group">
                      <select class="form-control" id="subCategory" name="subcategory_id" required="">
                       
                    
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
                    <label for="validationCustom02" class="d-flex">Weight
<span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum">
        <img src="{{asset('public/assets/img/question_mark.svg')}}"/>
                    </span>
                  </label>
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
                      <input class="form-check-input" value="new" type="radio" name="condition" @if($product->condition === 'new') checked @endif>
                      <div class="add-category-btn">
                      <h6>New</h6>
                      <p class="mb-0">123 Lorem ipsum dolor sit am et, consectetur dipiscing elit dolor sit amet.</p>
                    </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-2">
                    <div class="green_pargh">
                      <input class="form-check-input" value="like_new" type="radio" name="condition" @if($product->condition === 'like_new') checked @endif>
                      <div class="add-category-btn">
                      <h6>Like New</h6>
                      <p class="mb-0">Lorem ipsum dolor sit am et, consectetur dipiscing elit dolor sit amet.</p>
                    </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-2">
                    <div class="green_pargh">
                      <input class="form-check-input" value="old" type="radio" name="condition" @if($product->condition === 'old') checked @endif>
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
                <input type="checkbox" value="1" name="available_for_sale" @if($product->available_for_sale =='1') checked @endif> <span class="ms-switch-slider round"></span>
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
                  <input type="checkbox" checked="" value="1" name="customer_contact"> <span class="ms-switch-slider ms-switch-warning round" @if($product->customer_contact == '1') checked @endif></span>
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
                <input type="checkbox" value="1" name="inventory_track" @if($product->inventory_track ==='1') checked @endif> <span class="ms-switch-slider round"></span>
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
                <input type="checkbox" name="product_offer" value="1" @if ($product->product_offer=== '1') checked
                    
                @endif> <span class="ms-switch-slider round"></span>
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
              <input class="form-check-input" type="checkbox" value="1" name="free_shipping" id="invalidCheck" @if($product->free_shipping === '1') checked @endif>
              <i class="ms-checkbox-check"></i>
            </label>
            <span class="green_cl"> Free Shipping </span>
          </div>
          </div>
          <div class="form-row px-4 pt-3">
              <div class="col-md-6 mb-2">
                <label>Ships from (zip code) <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                <div class="input-group">
                  <input type="text" name="ships_from" value="{{ $product->ships_from}}" class="form-control" placeholder="Enter Length">
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <label>Shipping Type <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"/></span></label>
                <div class="input-group">
                  <select name="shipping_type" id="" class="form-control" required>
                    <option value="USPS" @if($product->shipping_type === 'USPS') selected @endif>USPS</option>
                    <option value="FEDEX" @if($product->shipping_type === 'FEDEX') selected @endif>FEDEX</option>
                    <option value="DHL" @if($product->shipping_type === 'DHL') selected @endif>DHL</option>
                    <option value="UPS" @if($product->shipping_type === 'UPS') selected @endif>UPS</option>
                  </select>
                  {{-- <input type="text" name="{{ $product-> }}" class="form-control" placeholder="Enter shiiping type"> --}}
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
                <input type="text" name="price" value="{{ $product->price }}" class="form-control" placeholder="Enter Price">
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


{{-- <div class="col-xl-12 col-md-12">
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
</div> --}}


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
                <button type="button" class="btn mt-0 px-5" id="edit-advance_btn">Advance</button>
                <input type="submit" value="Add Product"  class="btn track_order_but mt-0 px-4" >
                
            </div>
            </div>
        </div>
        </div>
        </div>
   
            <!--shipping-orders-->
        </div>
        
        {{-- Advance products --}}
         <div class="advice_block row" style="display:none;">
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
                <input type="text" class="form-control" value="{{ $product->meta_tags }}" name="meta_tags" placeholder="Add meta tags here...">
              </div>
                          </div>
            <div class="col-md-4 mb-2">
                <label class="d-flex font-weight-bold">Meta Keywords <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"></span></label>
                <div class="input-group">
                  <input type="text" class="form-control" value="{{ $product->meta_keywords }}" name="meta_keywords" placeholder="Add meta keywords here...">
                </div>
                              </div>
              <div class="col-md-4 mb-2">
                <label class="d-flex font-weight-bold">Product Title <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"></span></label>
                <div class="input-group">
                  <input type="text" class="form-control" value="{{ $product->title }}" name="title" placeholder="Enter Title for marketing">
                </div>
              </div>
              <div class="col-md-12 mb-2">
                <label class="d-flex font-weight-bold">Meta Description <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"></span></label>
                <div class="input-group">
                    <textarea rows="5" class="form-control" name="meta_description" placeholder="Type Here...">{{ $product->meta_description }}</textarea>
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
              <input type="text" class="form-control" id="attributeName" value="" placeholder="Enter attribute">
              <span id="attrError"></span>
            </div>
            <div class="form-group">
              <label for="exampleEmail">No. of Option</label>
                 <input type="text" id="optionName" value="" class="form-control">
                 <span id="optionError"></span>
                 <span class="optionSpan"></span>
                 <button type="button" id="addOption" class="btn btn-success py-2 px-2 mt-0 fs-16">Add Option </button>
            </div>
            <button type="button" id="createVariant" class="btn btn-success py-2 px-2 mt-0 fs-16">Create </button>
               
            <input type="text" id="variantsValue" name="variants" value="{{$product->variants}}">
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
              <tbody id="combination">
               
              </tbody>
            </table>
          </div>
        </div>
</div>
</div>

<div class="col-md-12">
<div class="ms-panel">
  <div class="ms-panel-header border-bottom d-flex justify-content-between align-items-center">
      <h5 class="mb-0 pb-0">Product Specifications <span data-toggle="tooltip" data-placement="left" title="" class="ms-add-task-to-block ms-btn-icon float-right" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="{{asset('public/assets/img/question_mark.svg')}}"></span></h5>
   </div>
  <div class="ms-panel-body">
    <h6>State</h6>
      <div class="enter_spec">
        <div class="form-group">
          <input type="text" name="state" value="{{ $product->state }}" class="form-control" placeholder="Enter Specification">
        </div>
        
      
</div>
</div>

<div class="col-xl-12 col-md-12 pb-3">
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
  <input type="submit" class="btn track_order_but mt-0 px-4" name="normal_product" value="Add Product">

</div>

</form>
{{-- Form End  --}}
</div>
</div>
</div>
</div>
</div>

</div>
</div>

@endsection
