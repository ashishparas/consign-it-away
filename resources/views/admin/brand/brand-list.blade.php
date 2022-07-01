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
                  <table id="example" class="running_order yajra-datatable table table-striped dataTable_custom" style="width:100%">
                   
                    <thead>
                      <tr>
                          <th>id</th>
                          <th>Brand Name</th>
                          <th>image</th>
                          <!--<th>Brand Logo</th>-->
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                </tbody>

                </table>
                  <!----table---->
                </div>
              </div>
            
        </div>
        <!--shipping-orders-->
    </div>
	</div>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

  <script type="text/javascript">
    $(function () {
     var baseUrl = "{{asset('public/brand')}}";
   
      var table = $('.yajra-datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('brand-list-data') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'image', name: 'image',
              render: function( data, type, full, meta ) {
              
                return '<img src="'+baseUrl+'/'+data+'" width="50" height="50">';
            }
          },
              {data: 'action', name: 'action',orderable: false,searchable: false },
          ]
      });
      
    });
  </script>


@endsection