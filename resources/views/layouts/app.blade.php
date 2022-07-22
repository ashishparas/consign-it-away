<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <!-- Iconic Fonts -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link href="{{asset('public/assets/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- Costic styles -->
  <link href="{{asset('public/assets/css/style.css')}}" rel="stylesheet">
  {{-- <link href="{{asset('public/assets/css/custom.css')}}" rel="stylesheet"> --}}
  <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
 
</head>
<body class="ms-body ms-aside-left-open ms-primary-theme ms-has-quickbar">
  <!-- Preloader -->
  <div id="preloader-wrap">
    <div class="spinner spinner-8">
      <div class="ms-circle1 ms-child"></div>
      <div class="ms-circle2 ms-child"></div>
      <div class="ms-circle3 ms-child"></div>
      <div class="ms-circle4 ms-child"></div>
      <div class="ms-circle5 ms-child"></div>
      <div class="ms-circle6 ms-child"></div>
      <div class="ms-circle7 ms-child"></div>
      <div class="ms-circle8 ms-child"></div>
      <div class="ms-circle9 ms-child"></div>
      <div class="ms-circle10 ms-child"></div>
      <div class="ms-circle11 ms-child"></div>
      <div class="ms-circle12 ms-child"></div>
    </div>
  </div>
  <!-- Overlays -->
  <div class="ms-aside-overlay ms-overlay-left ms-toggler" data-target="#ms-side-nav" data-toggle="slideLeft"></div>
  <div class="ms-aside-overlay ms-overlay-right ms-toggler" data-target="#ms-recent-activity" data-toggle="slideRight"></div>
  <!-- Sidebar Navigation Left -->
  @include('layouts.sidebar')
  <!-- Main Content -->
  <main class="body-content">
    <!-- Navigation Bar -->
    <nav class="navbar ms-navbar">
      <div class="ms-aside-toggler ms-toggler pl-0" data-target="#ms-side-nav" data-toggle="slideLeft"> <span class="ms-toggler-bar bg-primary"></span>
        <span class="ms-toggler-bar bg-primary"></span>
        <span class="ms-toggler-bar bg-primary"></span>
      </div>
      <div class="logo-sn logo-sm ms-d-block-sm">
        <a class="pl-0 ml-0 text-center navbar-brand mr-0" href="dashboard.html"><img src="{{asset('public/assets/img/logo.png')}}" alt="logo"></a>
      </div>
      <ul class="ms-nav-list ms-inline mb-0" id="ms-nav-options">
        <li class="ms-nav-item dropdown"> <a href="#" class="text-disabled ms-has-notification notification_block" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="{{asset('public/assets/img/notification.png')}}" alt="notification">
        </a>
          <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
            <li class="dropdown-menu-header">
              <h6 class="dropdown-header ms-inline m-0"><span class="text-disabled">Notifications</span></h6><span class="badge badge-pill badge-info">4 New</span>
            </li>
            <li class="dropdown-divider"></li>
            <li class="ms-scrollable ms-dropdown-list">
              <a class="media p-2" href="#">
                <div class="media-body"> <span>12 ways to improve your crypto dashboard</span>
                  <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 30 seconds ago</p>
                </div>
              </a>
              <a class="media p-2" href="#">
                <div class="media-body"> <span>You have newly registered users</span>
                  <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 45 minutes ago</p>
                </div>
              </a>
              <a class="media p-2" href="#">
                <div class="media-body"> <span>Your account was logged in from an unauthorized IP</span>
                  <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 2 hours ago</p>
                </div>
              </a>
              <a class="media p-2" href="#">
                <div class="media-body"> <span>An application form has been submitted</span>
                  <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 1 day ago</p>
                </div>
              </a>
            </li>
            <li class="dropdown-divider"></li>
            <li class="dropdown-menu-footer text-center"> <a href="#">View all Notifications</a>
            </li>
          </ul>
        </li>
        @if(Auth::check())
        <li class="ms-nav-item ms-nav-user dropdown">
          <a href="#" id="userDropdown" class="d-flex align-items-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="ms-user-img ms-img-round" src="{{asset('public/assets/img/customer-6.jpg')}}" alt="people">
            <span class="px-2 fs-16">{{Auth::user()->name}}</span>
            <span><img src="{{asset('public/assets/img/drop_down_arrow.svg')}}" alt=""></span>
          </a>
        
          <ul class="dropdown-menu dropdown-menu-right user-dropdown" aria-labelledby="userDropdown">
         
            <li class="ms-dropdown-list">
              <a class="media fs-14 p-2" href=""> <span><i class="flaticon-user mr-2"></i> Profile</span>
              </a>
              <a class="media fs-14 p-2" href="pages/prebuilt-pages/user-profile.html"> <span><i class="flaticon-gear mr-2"></i> Account Settings</span>
              </a>
            </li>
          
            <li class="dropdown-divider"></li>
            <li class="dropdown-menu-footer">
              <a class="media fs-14 p-2" href="{{ url('/logout') }}"
              onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"> 
                  <span><i class="flaticon-shut-down mr-2"></i> Logout</span>
              </a>
              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            </li>
          </ul>
        </li>
        @endif
      </ul>
      <div class="ms-toggler ms-d-block-sm pr-0 ms-nav-toggler" data-toggle="slideDown" data-target="#ms-nav-options"> <span class="ms-toggler-bar bg-primary"></span>
        <span class="ms-toggler-bar bg-primary"></span>
        <span class="ms-toggler-bar bg-primary"></span>
      </div>
    </nav>
   @yield('content')
  </main>
  
  <!-- Order Tracking  -->
  <div class="modal fade" id="view_tracking" tabindex="-1" role="dialog" aria-labelledby="view_tracking">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title has-icon ms-icon-round">Order Tracking  </h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
         <h5 class="pt-2 pb-0 mb-0">Track Order</h5>
            <p class="grey_cl mb-0">Tracking ID: p817735980 </p>
            <p class="grey_cl">Shipped with DTDC </p>
            <div class="d-flex align-items-stretch order_track active">
                <div class="items_block">
                    <h6>12 Jan, 2022</h6>
                    <p class="grey_cl">10:07 AM</p>
                </div>
                <div class="items_right">
                    <h6>Order Placed</h6>
                    <p class="grey_cl">Your order has been placed successfully.</p>
                </div>
            </div>
            <div class="d-flex align-items-stretch order_track active">
                <div class="items_block">
                    <h6>13 Jan, 2022</h6>
                    <p class="grey_cl">10:15 AM</p>
                </div>
                <div class="items_right">
                    <h6>Confirmed</h6>
                    <p class="grey_cl">Your order has been confirmed</p>
                </div>
            </div>
            <div class="d-flex align-items-stretch order_track active">
                <div class="items_block">
                    <h6>13 Jan, 2022</h6>
                    <p class="grey_cl">10:15 AM</p>
                </div>
                <div class="items_right">
                    <h6>Processing</h6>
                    <p class="grey_cl">Your product is processing to deliver you on time.</p>
                </div>
            </div>
            <div class="d-flex align-items-stretch order_track active">
                <div class="items_block">
                    <h6>13 Jan, 2022</h6>
                    <p class="grey_cl">10:15 AM</p>
                </div>
                <div class="items_right">
                    <h6>Out of Delivery</h6>
                    <p class="grey_cl">Your order delivered by Monday 17 Jan, 2022  </p>
                </div>
            </div>
            <div class="d-flex align-items-stretch order_track active">
                <div class="items_block">
                    <h6>13 Jan, 2022</h6>
                    <p class="grey_cl">10:15 AM</p>
                </div>
                <div class="items_right">
                    <h6>Order Delivered</h6>
                    <p class="grey_cl">Product deliver to you and marked as delivered </p>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>



  <!-- Refund Tracking  -->
  <div class="modal fade" id="view_tracking_two" tabindex="-1" role="dialog" aria-labelledby="view_tracking_two">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title has-icon ms-icon-round">Refund Tracking</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
         <h5 class="pt-2 pb-0 mb-0">Track Order</h5>
            <p class="grey_cl mb-0">Tracking ID: p817735980 </p>
            <p class="grey_cl">Shipped with DTDC </p>
            <div class="d-flex align-items-stretch order_track active">
                <div class="items_block">
                    <h6>12 Jan, 2022</h6>
                    <p class="grey_cl">10:07 AM</p>
                </div>
                <div class="items_right">
                    <h6>Return pickup</h6>
                    <p class="grey_cl">&nbsp;</p>
                </div>
            </div>
            <div class="d-flex align-items-stretch order_track active">
                <div class="items_block">
                    <h6>13 Jan, 2022</h6>
                    <p class="grey_cl">10:15 AM</p>
                </div>
                <div class="items_right">
                    <h6>Picked up</h6>
                    <p class="grey_cl">&nbsp;</p>
                </div>
            </div>
            <div class="d-flex align-items-stretch order_track">
                <div class="items_block">
                  <h6 class="invisible">13 Jan, 2022</h6>
                  <p  class="invisible">10:15 AM</p>
                </div>
                <div class="items_right">
                    <h5>Product Recieved</h5>
                    <p class="orange_cl">Pending From Vendor</p>
                </div>
            </div>
            <div class="d-flex align-items-stretch order_track">
                <div class="items_block">
                  <h6 class="invisible">13 Jan, 2022</h6>
                  <p class="invisible">10:15 AM</p>
                </div>
                <div class="items_right">
                    <h5>Process the Refund</h5>
                    <p class="orange_cl">Pending From Vendor </p>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>


   <!-- Edit Refund Amount -->
   <div class="modal fade" id="refund_tracking" tabindex="-1" role="dialog" aria-labelledby="refund_tracking">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title has-icon ms-icon-round">Edit Refund Amount</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body pb-0">
          <div class="form-group">
            <label class="col-md-12 pl-0 font-weight-bold">Refund Preference</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
              <label class="form-check-label" for="inlineRadio1">Fully</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
              <label class="form-check-label" for="inlineRadio2">Partially</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option3">
              <label class="form-check-label" for="inlineRadio3">Not Refund</label>
            </div>
          </div>
          <div class="mb-2">
            <label class="d-flex font-weight-bold">Fill Amount to Return </label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="$ 35.9">
            </div>
          </div>
          <div class="mb-2">
            <label class="d-flex font-weight-bold">Reason </label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Type...">
            </div>
          </div>
          <div class="mb-2">
            <label class="d-flex font-weight-bold">Ships from (zip code) <span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="assets/img/question_mark.svg"></span></label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Enter Zip Code">
            </div>
          </div>
          <div class="mb-3">
            <label for="validationCustom01" class="d-flex font-weight-bold">Shipping Type<span class="ml-auto" data-toggle="tooltip" data-placement="left" title="" data-original-title="Lorem Ipsum Lorem Ipsum"><img src="assets/img/question_mark.svg"></span></label>
            <div class="input-group">
              <select class="form-control" id="validationCustom15" required="">
                <option value="">Select Shipping</option>
                <option value="">Select Shipping 1</option>
                <option value="">Select Shipping 2</option>
              </select>
            </div>
          </div>

        </div>
        <div class="d-block col-12 pb-4">
          <button type="button" class="btn btn-primary mt-0">Submit Changes</button>
        </div>
      </div>
    </div>
  </div>

  


  <!-- Global Required Scripts Start -->
  <script src="{{asset('public/assets/js/jquery-3.3.1.min.js')}}"></script>
  <script src="{{asset('public/assets/js/popper.min.js')}}"></script>
  <script src="{{asset('public/assets/js/bootstrap.min.js')}}"></script>
  <!-- Costic core JavaScript -->
  <script src="{{asset('public/assets/js/framework.js')}}"></script>  
  <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
  <script src="https://www.jqueryscript.net/demo/Product-Carousel-Magnifying-Effect-exzoom/jquery.exzoom.css"></script>
  <!-- Page Specific Scripts Start -->
  <script src="{{asset('public/assets/js/jquery.steps.min.js')}}">
</script>
<script src="{{asset('public/assets/js/form-wizard.js')}}">
</script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"> </script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"> </script>
<script src="{{asset('public/js/custom.js')}}"></script>
<script>
  $(document).ready(function() {
      $('#example').DataTable();
  } );
</script>
<script>
  $("a[href='#finish']").click(function () {
    $('#information_modal').modal('show'); 
    // $('#modal_view_right').modal({
    //     show: 'false'
    // });
           });
      
  </script>

<script>
  $(document).ready(function(){
    $("#advance-block").click(function(){
      $("#add_advance").toggle();
    });

  });
  </script>




</body>

</html>
