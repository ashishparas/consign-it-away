<aside id="ms-side-nav" class="side-nav fixed ms-aside-scrollable ms-aside-left">
    <!-- Logo -->
    <div class="logo-sn ms-d-block-lg">
      <a class="pl-0 ml-0 text-center" href="#">
        <img src="{{asset('public/assets/img/logo.png')}}" alt="logo">
      </a>
    </div>
    <!-- Navigation -->
    <ul class="accordion ms-main-aside fs-14" id="side-nav-accordion">
      <li class="menu-item">
        <a href="{{url('/admin/home')}}"> <span class="d-flex align-items-center"><img src="{{asset('public/assets/img/home.svg')}}" alt="img">Dashboard </span>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{url('/admin/view/banner')}}"> <span class="d-flex align-items-center"><img src="{{asset('public/assets/img/home.svg')}}" alt="img">Banner</span>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{url('/admin/brand-list')}}"> <span class="d-flex align-items-center"><img src="{{asset('public/assets/img/star.svg')}}" alt="img">Brand</span>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{url('/admin/category-management')}}"> <span class="d-flex align-items-center"><img src="{{asset('public/assets/img/vendor.svg')}}" alt="img">Category Management</span>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{url('/admin/subcategory-management')}}"> <span class="d-flex align-items-center"><img src="{{asset('public/assets/img/vendor.svg')}}" alt="img">Sub Category Management</span>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{url('admin/order-management')}}"> <span class="d-flex align-items-center"><img src="{{asset('public/assets/img/shopping-bag.svg')}}" alt="img">Order Management </span>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{url('/admin/vendor-management')}}"> <span class="d-flex align-items-center"><img src="{{asset('public/assets/img/vendor.svg')}}" alt="img">Vendor Management </span>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{url('/admin/subscription-plan')}}"> <span class="d-flex align-items-center"><img src="{{asset('public/assets/img/diamond.svg')}}" alt="img">Subscription Management </span>
        </a>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0)" class="has-chevron collapsed" data-toggle="collapse" data-target="#invoice" aria-expanded="false" aria-controls="invoice"> <span class="d-flex align-items-center"><img src="{{asset('public/assets/img/supply-chain.svg')}}" alt="img">Product Management </span>
        </a>
        <ul id="invoice" class="collapse listing-nav pl-0" aria-labelledby="invoice" data-parent="#side-nav-accordion">
          <li> <a href="{{url('/admin/vendor-products')}}">Vender Products</a> </li>
          <li> <a href="javascript:void(0)">Third Party Products</a> </li>
          <li> <a href="javascript:void(0)">Consignment Percentage</a> </li>
          <li> <a href="javascript:void(0)">Manage Shipping</a> </li>
        </ul>
      </li>
      <li class="menu-item">
        <a href="{{url('admin/view/transactions')}}"> <span class="d-flex align-items-center"><img src="{{asset('public/assets/img/transaction.svg')}}" alt="img">Transactions Management</span>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{url('/admin/staff-management')}}"> <span class="d-flex align-items-center"><img src="{{asset('public/assets/img/staff-users.svg')}}" alt="img">Staff Management</span>
        </a>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0)"> <span class="d-flex align-items-center"><img src="{{asset('public/assets/img/return.svg')}}" alt="img">Returns & Refunds</span>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{url('/admin/report-management')}}"> <span class="d-flex align-items-center"><img src="{{asset('public/assets/img/warning.svg')}}" alt="img">Report Management</span>
        </a>
      </li>
      
      
      
    </ul>
  </aside>