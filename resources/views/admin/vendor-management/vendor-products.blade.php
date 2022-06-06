@extends('layouts.app')


@section('content')

<div class="ms-content-wrapper">
    <!--breadcrumbs-->
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><img src="{{asset('public/assets/img/supply-chain.svg')}}" alt="img"> Product Management</li>
            <li class="breadcrumb-item active">Vender Products</li>
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
                    <h3 class="mb-0">Vendor Products</h3>
                    <span>
                        <a href="javascript:;" class="btn green_btn" data-toggle="modal" data-target="#addproductby_modal">+ Add Product</a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-xl-12 mt-4">
          <div class="ms-panel">
            <div class="ms-panel-header">
                <h4 class="mb-0">Product Listing</h4>
            </div>
            <div class="ms-panel-body table-responsive">
                <!----table---->
              <table id="example" class="running_order table table-striped dataTable_custom" style="width:100%">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>In Stock</th>
                        <th>Status</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        
                   
                    <tr>
                        <td>#{{$product->id}}</td>
                        <td class="product_tuc">
                          
                          <div class="d-block d-lg-flex align-items-center product-img">
                            <img class="mr-3" src="{{asset('public/products/'.$product->image[0])}}" alt="image"/>
                            <h6 class="mb-0">{{$product->name}}</h6>
                          </div>
                        </td>
                        <td>323</td>
                      <td><span class="badge grey_badge">{{($product->status =='1')?'Active':'Block'}}</span></td>
                        <td>${{$product->price}}</td>
                        <td><a class="btn orange_btn" href="{{url('/admin/product/detail/vendor/'. $product->id)}}">View</a></td>
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


@endsection