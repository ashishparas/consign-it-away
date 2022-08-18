@extends('layouts.app')


@section('content')


    <div class="ms-content-wrapper">
        <!--breadcrumbs-->
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item active"><img src="{{asset('public/assets/img/star.svg')}}" alt="img"> App Banner</li>
              </ol>
              @if (Session::has('success'))
                  <div class="alert alert-success">{{ Session::get('success') }}</div>
              @endif
              @if (Session::has('error'))
              <div class="alert alert-danger">{{ Session::get('error') }}</div>
          @endif
            </nav>
          </div>
        </div>
        <!--breadcrumbs-->
        <!--shipping-orders-->
        <div class="row align-items-start">
            <div class="col-xl-12 col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-header border-0 d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">App Banner</h3>
                        <span>
                            <a href="{{url('admin/create/banner')}}" class="btn green_btn">+ Add Banner</a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-12 mt-4">
              <div class="ms-panel">
                <div class="ms-panel-header">
                    <h4 class="mb-0">Banner Listing</h4>
                </div>
                <div class="ms-panel-body table-responsive">
                    <!----table---->
                  <table id="example" class="running_order yajra-datatable table table-striped dataTable_custom" style="width:100%">
                   
                    <thead>
                      <tr>
                          <th>id</th>
                          <th>Photo</th>
                          <th>BaseUrl</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($banners as $banner)
                    <tr>
                        <td>{{ $banner->id }}</td>
                        <td><img src="{{asset('public/banner/'.$banner->photo)}}" width="50" height="50"></td>
                        <td>{{ $banner->baseurl }}</td>
                        <td><a class="btn btn-danger" href="{{url('admin/delete/banner', $banner->id)}}">Delete</a>
                          <a href="{{url('admin/update/banner/'.$banner->id)}}" class="btn btn-info">Edit</a>
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