
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Consign</title>
  <!-- Iconic Fonts -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link href="{{asset('public/assets/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- Costic styles -->
  <link href="{{asset('public/assets/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/css/custom.css')}}" rel="stylesheet">
  <style>
 .error-message p img {
    width: 142px;
}
.error-message {
    width: 32%;
    text-align: center;
}
.error-message .btn {
    padding: 11px;
    width: 34%;
    margin: auto;
    font-size: 16px;
    border-radius: 8px;
    background-color: #FE9941;
}
.error-message h3 {
    font-size: 25px;
}
  </style>
</head>
<body class="ms-body ms-aside-left-open ms-primary-theme ms-has-quickbar">

  <main>
    <div class="ms-content-wrapper ms-auth back_loginbg">
        <div class="ms-auth-container">
           <div class="ms-auth-col">
            <div class="ms-auth-form">
              <div class="error-message">
              <p><img src="{{asset('assets/img/error.svg')}}" alt=""></p>
              <h3 class="text-white">You are not an Admin!. You don't have persmission to access this page</h3>


              <a  href="{{ url('/logout') }}" class="btn btn-primary mt-4 d-block"
              onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"> 
                  <span><i ></i> Go Back</span>
              </a>
              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            </div>
          </div>
        </div>
      </div>
  </main>
  <!-- MODALS -->
  <!-- Global Required Scripts Start -->
  <script src="{{asset('public/')}}assets/js/jquery-3.3.1.min.js"></script>
  <script src="{{asset('public/assets/js/popper.min.js')}}"></script>
  <script src="{{asset('public/assets/js/bootstrap.min.js')}}"></script>
  <!-- Costic core JavaScript -->
  <script src="{{asset('public/assets/js/framework.js')}}"></script> 
</body>

</html>
