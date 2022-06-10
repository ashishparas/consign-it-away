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
            <li class="breadcrumb-item"><img src="{{asset('public/assets/img/supply-chain.svg')}}" alt="img">Staff Management</li>
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
                    <h3 class="mb-0">Staff Management</h3>
                    <span>
                        <a href="{{url('admin/add-staff')}}" class="btn green_btn">+ Add Staff</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-xl-12 mt-4">
          <div class="ms-panel">
            <div class="ms-panel-header">
                <h4 class="mb-0">Staff List</h4>
            </div>
            <div class="ms-panel-body table-responsive">
              <!----table---->
              <table id="example" class="running_order table table-striped dataTable_custom" style="width:100%">
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>Staff Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($AdminStaffs as $item)  
                    <tr>
                        <td>#{{$item->id}}</td>
                        <td class="product_tuc">
                          <div class="d-block d-lg-flex align-items-center product-img">
                            <img class="mr-3" src="{{asset('public/admin_staff/'.$item->image)}}" alt="image"/>
                            <h6 class="mb-0"></h6>
                          </div>
                        </td>
                        <td>{{$item->email}}</td>
                         <td>{{$item->mobile_no}}</td>
                        <td><?php
                            if($item->role == '1'){
                              echo 'Order-Management';
                            }elseif($item->role == '2'){
                              echo 'Vendor-management';
                            }elseif($item->role == '3'){
                              echo 'Subscription-management';
                            }elseif($item->role == '4'){
                              echo 'Product-Management';
                            }elseif($item->role == '5'){
                              echo 'Transaction-Management';
                            }elseif($item->role == '6'){
                              echo 'Staff-Management';
                            }elseif($item->role == '7'){
                                echo 'Return and Refund';
                            }elseif($item->role == '8'){
                              echo 'Report-Management';
                            }
                        ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                            <a class="btn orange_btn mr-1" href="javascript:;" data-toggle="modal" data-target="#view_detail">View</a>
                            <a href="{{url('/admin/delete/staff/'.$item->id)}}" class="btn delete_btn_red mt-0 px-2"><img src="{{asset('public/assets/img/delete_white.svg')}}" width="14px" height="14px" alt=""></a>
                    
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



@endsection