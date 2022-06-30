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
            <div class="col-md-12 col-xl-12 mt-4">
              <div class="ms-panel">
                <div class="ms-panel-header">
                    <h4 class="mb-0">Edit Brand</h4>
                </div>
                <div class="ms-panel-body">
                    <form action="{{url('/admin/update-brand')}}"  method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$brand->id}}" />
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Brand Name</label>
                            <input type="type" class="form-control" placeholder="" name="name" value="{{$brand? $brand->name:''}}">
                          </div>
                          <div class="form-group">
                            
                            <img src="{{asset('public/brand/'.$brand->image)}}" width="50" height="50">
                        </div>
                          <div class="form-group">
                            <label for="exampleFormControlInput1">Upload Img</label>
                            <input type="file" name="image" class="form-control-file border p-1" id="exampleFormControlFile1">
                        </div>
                        <!--<div class="form-group">-->
                        <!--    <label for="exampleFormControlInput1">Upload Logo</label>-->
                        <!--    <input type="file" class="form-control-file border p-1" id="exampleFormControlFile1">-->
                        <!--</div>-->
                        <button class="btn btn-primary" role="submit" >Submit</button>
                      </form>
                </div>
              </div>
            
        </div>
        <!--shipping-orders-->
    </div>
	</div>




@endsection