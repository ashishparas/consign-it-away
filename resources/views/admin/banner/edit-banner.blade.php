@extends('layouts.app')



@section('content')



<div class="ms-content-wrapper">
        <!--breadcrumbs-->
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item active"><img src="{{asset('public/assets/img/star.svg')}}" alt="img">Edit Banner</li>
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
                    <h4 class="mb-0">Edit Banner</h4>
                </div>
                <div class="ms-panel-body">
                    <form action="{{url('/admin/edit/banner/'.$banner->id)}}"  method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="form-group">
                        <img src="{{  $banner->baseurl.'/'.$banner->photo }}" width="100px" height="100px" />
                    </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Upload Img</label>
                    <input type="file" name="photo" class="form-control-file border p-1" id="exampleFormControlFile1">
                    @error('photo')
                        <div class="alert alert-danger">{{ $message }}</div>    
                    @enderror
                </div>
                <button class="btn btn-primary" role="submit" >Submit</button>
                      </form>
                </div>
              </div>
            
        </div>
        <!--shipping-orders-->
    </div>
	</div>


@endsection