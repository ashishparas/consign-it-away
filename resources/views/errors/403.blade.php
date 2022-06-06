<p>You are not an Admin!. You don't have persmission to access this page</p>



<a  href="{{ url('/logout') }}"
              onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"> 
                  <span><i ></i> Go Back</span>
              </a>
              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>