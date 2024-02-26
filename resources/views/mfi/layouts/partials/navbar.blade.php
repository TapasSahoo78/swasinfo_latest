@php
 $code = Auth::user()->mfi->code;
@endphp
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        @yield('pagetitlesection')

    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-auto custom-serach-form">
        <div class="input-group input-group-md">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav">

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <!-- data here -->
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="far fa-envelope"></i>
                <span class="badge badge-danger navbar-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <!-- data here -->
            </div>
        </li>


        <li class="nav-item dropdown">
            <a class="nav-link height-unset" data-toggle="dropdown" href="#">
                <div class="profile-box">
                    <div class="img">
                        <img src="{{ auth()->user()?->profile_picture }}" alt="">
                    </div>
                    <p>{{ auth()->user()->username ?? auth()->user()?->first_name }}</p>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right custom-dropdown">
                
                <a href="{{ route('mfi.profile',['slug'=>$code]) }}">
                    Profile
                </a>
                <a href="{{ route('mfi.change.password',['slug'=>$code]) }}">
                    Change Password
                </a>
                <a href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
            </div>


            <form id="logout-form" action="{{ route('mfi.logout',['slug'=>$code]) }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
