<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{config('app.name')}}</title>
  <!-- Iconic Fonts -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link href="{{asset('public/assets/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- Costic styles -->
  <link href="{{asset('public/assets/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/css/custom.css')}}" rel="stylesheet">
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
  <!-- Main Content -->
  <main>
    <div class="ms-content-wrapper ms-auth back_loginbg">
        <div class="ms-auth-container">
           <div class="ms-auth-col">
            <div class="ms-auth-form">
              <div class="logo_block w-100 text-center pb-4"><img src="{{asset('public/assets/img/logo.png')}}" alt="" width="280px"></div>
        
			  <form method="POST" action="{{ route('login') }}" class="needs-validation">
                        @csrf
                <h3 class="text-center">Login to Account</h3>
                <p class="pb-4 text-center">Please enter your email and password to continue</p>
                <div class="mb-3">
                  <label for="validationCustom08">Email Address</label>
                  <div class="input-group">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    <div class="invalid-feedback">Please provide a valid email.</div>
                  </div>
                </div>
                <div class="mb-2">
                  <label for="validationCustom09">Password</label>
                  <div class="input-group">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    <div class="invalid-feedback">Please provide a password.</div>
                  </div>
                </div>
				<button type="submit" class="btn btn-primary mt-4 d-block w-100 p-2">
                                    {{ __('Sign In') }}
                                </button>
                
              </form>
            </div>
          </div>
        </div>
      </div>
  </main>
  <!-- MODALS -->
  <!-- Global Required Scripts Start -->
  <script src="{{asset('public/assets/js/jquery-3.3.1.min.js')}}"></script>
  <script src="{{asset('public/assets/js/popper.min.js')}}"></script>
  <script src="{{asset('public/assets/js/bootstrap.min.js')}}"></script>
  <!-- Costic core JavaScript -->
  <script src="{{asset('public/assets/js/framework.js')}}"></script>  
</body>

</html>
