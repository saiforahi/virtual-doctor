<!-- Header -->
@php
$clinic = getClinicInfo();
@endphp
<header class="header">
    <nav class="navbar navbar-expand-lg header-nav">
        <div class="navbar-header">
            <a id="mobile_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <a href="{{ route('home') }}" class="navbar-brand logo">
                
                @foreach ($clinic as $c)
                    <strong>{{ $c->name }}</strong>
                    {{-- <img src="{{ asset('public/storage/clinics/' . $c->image) }}" class="img-fluid" alt="Logo"> --}}
                @endforeach
                
            </a>
        </div>
        <div class="main-menu-wrapper">
            <div class="menu-header">
                <a href="{{ route('home') }}" class="menu-logo">
                    <img src="{{ asset('assets/frontend/portal/img/VD.gif') }}" class="img-fluid" alt="Logo">
                </a>
                <a id="menu_close" class="menu-close" href="javascript:void(0);">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <ul class="main-nav">
                <li class="active">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                @if(auth()->user())
                    <li class="">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                @endif

                <li class="has-submenu">
                    <a href="#">Pages <i class="fas fa-chevron-down"></i></a>
                    <ul class="submenu">
                        <li><a href="{{ route('search-doctor') }}">Search Doctors</a></li>
                        <li><a href="{{ route('patient-login') }}">Login</a></li>
                        <li><a href="{{ route('new-patient-register') }}">Register</a></li>
                        <li><a href="{{ route('password.request') }}">Forgot Password</a></li>
                    </ul>
                </li>

                <li class="login-link">
                    <a href="{{ route('patient-login') }}">Login / Signup</a>
                </li>
            </ul>
        </div>
        <ul class="nav header-navbar-rht">
            <li class="nav-item contact-item">
                <div class="header-contact-img">
                    <i class="far fa-hospital"></i>
                </div>
                <div class="header-contact-detail">
                    <p class="contact-header">Contact</p>
                    <p class="contact-info-header">
                        @foreach ($clinic as $c)
                            {{ $c->phone }}
                        @endforeach

                    </p>
                </div>
            </li>
            @if(auth()->user())
                <li class="nav-item">
                    <a class="nav-link header-login" href="{{ url('patient-logout') }}">Logout</a>
                </li>
            @else
            <li class="nav-item">
                <a class="nav-link header-login" href="{{ route('patient-login') }}">login / Signup </a>
            </li>
            @endif

        </ul>
        </li>


        </ul>
        </div>
    </nav>
</header>
<!-- /Header -->
