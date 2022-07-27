@extends('layouts.app')





@section('content')
<div class="ms-content-wrapper">
        <!--breadcrumbs-->
         @if(!empty($message))
            <div class="alert alert-success"> {{ $message }}</div>  
         @endif
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><img src="{{asset('public/assets/img/vendor.svg')}}">Category Management</li>
                <!-- <li class="breadcrumb-item">Running Orders</li>
                <li class="breadcrumb-item active">Shipping Orders Details</li> -->
              </ol>
            </nav>
          </div>
        </div>
        <!--breadcrumbs-->
        <!--shipping-orders-->
        <div class="row">
            
            <div class="col-xl-12 col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-header d-flex justify-content-between">
                        <h4 class="mb-0">Catergory Listing</h4>
                        <span>
                            <a href="{{url('admin/add-category')}}" class="btn green_btn">+ Add Category</a>
                        </span>
                    </div>
                    <div class="ms-panel-body">
                        <div class="running_orders_summary table-responsive">
                            <!----table---->
                            <table id="example" class="running_order table table-striped dataTable_custom" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>S.NO.</th>
                                        <th>Name</th>
                                        <th>Category Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Categories as $item) 
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->title}}</td>
                                        <td class="product_tuc">
                                            <div class="d-block d-lg-flex align-items-center product-img">
                                                <img class="mr-3" src="{{asset('public/category/'.$item->image)}}" alt="image">
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{url('/admin/add-subcategory/'.$item->id)}}" class="btn orange_btn">Add SubCategory</a>
                                            <a href="{{url('/admin/delete/category/'.$item->id)}}" class="ml-3"><img src="{{asset('public/assets/img/delete.svg')}}" alt=""></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    
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