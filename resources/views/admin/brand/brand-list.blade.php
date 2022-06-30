@extends('layouts.app')


@section('content')


    <div class="ms-content-wrapper">
        <!--breadcrumbs-->
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item active"><img src="{{asset('public/assets/img/star.svg')}}" alt="img"> Brand</li>
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
                        <h3 class="mb-0">Products Brand</h3>
                        <span>
                            <!--<a href="javascript:;" class="btn green_btn" data-toggle="modal" data-target="#addproductby_modal">+ Add Brand</a>-->
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-12 mt-4">
              <div class="ms-panel">
                <div class="ms-panel-header">
                    <h4 class="mb-0">Brand Listing</h4>
                </div>
                <div class="ms-panel-body table-responsive">
                    <!----table---->
                  <table id="example" class="running_order table table-striped dataTable_custom" style="width:100%">
                    <thead>
                        <tr>
                            <th>Brand Name</th>
                            <th>Brand Img</th>
                            <!--<th>Brand Logo</th>-->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $brand)
                        <tr>
                            <td>{{ $brand->name }}</td>
                            <td class="product_tuc">
                              <div class="d-block d-lg-flex align-items-center product-img">
                                <img class="mr-3" src="{{asset('public/brand/'.$brand->image)}}" alt="image"/>
                              </div>
                            </td>
                            <!--<td>-->
                            <!--    <img src="assets/img/fedex.png" alt="" width="120px">-->
                            <!--</td>-->
                            <td>
                              <div class="ml-auto pr-2">
                                <a href="{{url('/admin/edit-brand/'. $brand->id)}}"><img src="{{asset('public/assets/img/pen.svg')}}"  alt="">Edit</a>
                                <!--<a href="javascript:;" class="ml-3"><img src="{{asset('public/assets/img/delete.svg')}}" alt="">Delete</a>-->
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                  <!----table---->
                </div>
              </div>
            
        </div>
        <!--shipping-orders-->
    </div>
	</div>







@endsection