<!--header start-->
<nav class="admin-header navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <!-- logo -->
    <div class="text-left navbar-brand-wrapper">
        <a class="navbar-brand brand-logo" href="{{ route('dashboard') }}">خدمتي</a>
   
    </div>
    <!-- Top bar left -->
    <ul class="nav navbar-nav mr-auto">
        <li class="nav-item">
            <a id="button-toggle" class="button-toggle-nav inline-block ml-20 pull-left" href="javascript:void(0);"><i
                    class="zmdi zmdi-menu ti-align-right"></i></a>
        </li>
    </ul>
    <!-- top bar right -->
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item fullscreen">
            <a id="btnFullscreen" href="#" class="nav-link"><i class="ti-fullscreen"></i></a>
        </li>
        <li class="nav-item dropdown mr-30">
            <a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="true" aria-expanded="false">
                <img src="@if (is_null(\Auth::user()->image))
                {{asset('images/login-banner.jpg')}}
                @else
                {{\Auth::user()->image->filename}}
                @endif " alt="avatar">
            </a>



            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header">
                    <div class="media">
                        <div class="media-body">
                            <h5 class="mt-0 mb-0">{{ \Auth::user()->first_name }} {{ \Auth::user()->second_name }}</h5>
                            <span>{{ \Auth::user()->email }}</span>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" id="form-logout" method="POST">@csrf
                    <button type="submit" class="dropdown-item"><i class="text-danger ti-unlock"
                            onclick="event.preventDefault();document.getElementById('form-logout').submit();"></i>تسجيل
                        الخروج</a></button>
                </form>
            </div>
        </li>
        <li>
        </li>
    </ul>

</nav>

<!--=================================
header End-->
