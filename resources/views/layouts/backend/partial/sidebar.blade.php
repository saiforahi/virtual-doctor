<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="@if(is_null(Auth::user()->image)) {{ url('storage/profile/no_profile.png') }} @else{{ url('storage/profile/'.Auth::user()->image)}}@endif" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}
            </div>
            <div class="email">{{ Auth::user()->email }} </div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href=""><i class="material-icons">settings</i>Settings</a>
                    </li>
                    @if(!auth()->user()->api_token)
                    <li role="separator" class="divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="material-icons">input</i>Sign Out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>

            @role('patient')
            <li class="">
                <a href="{{route('home')}}" target="_blank">
                    <i class="material-icons">public</i>
                    <span>Home</span>
                </a>
            </li>

            <li class="{{Request::is('dashboard') ? 'active' : ''}}">
                <a href="{{route('dashboard')}}">
                    <i class="material-icons">dashboard</i>
                    <span>Dashboard</span>
                </a>
            </li>            
            
            @if(auth()->check() && auth()->user()->hasRole('super-admin'))
            <li class="{{Request::is('users') ? 'active' : ''}}">
                <a href="{{route('users.index')}}">
                    <i class="material-icons">person_add</i>
                    <span>New User</span>
                </a>
            </li>
            @endif
            @endrole
            @role('patient')

            <li class="header">System</li>
            <li class="{{Request::is('settings') ? 'active' : ''}}">
                <a href="{{route('settings')}}">
                    <i class="material-icons">settings</i>
                    <span>Settings</span>
                </a>
            </li>
            @if(auth()->check() && auth()->user()->hasRole('admin'))
            <li class="{{Request::is('slot') ? 'active' : ''}}">
                <a href="{{route('slot.index')}}">
                    <i class="material-icons">date_range</i>
                    <span>Create Time Schedule</span>
                </a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasRole('super-admin'))
            <li class="{{Request::is('slot') ? 'active' : ''}}">
                <a href="{{route('slot.index')}}">
                    <i class="material-icons">date_range</i>
                    <span>Create Time Schedule</span>
                </a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasRole('admin'))
            <li class="{{Request::is('clinic') ? 'active' : ''}}">
                <a href="{{route('clinic.index')}}">
                    <i class="material-icons">person_add</i>
                    <span>Clinic Info</span>
                </a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasRole('super-admin'))
            <li class="{{Request::is('clinic') ? 'active' : ''}}">
                <a href="{{route('clinic.index')}}">
                    <i class="material-icons">person_add</i>
                    <span>Clinic Info</span>
                </a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasRole('admin'))
            <li class="{{Request::is('department') ? 'active' : ''}}">
                <a href="{{route('department.index')}}">
                    <i class="material-icons">person_add</i>
                    <span>Department Info</span>
                </a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasRole('super-admin'))
            <li class="{{Request::is('department') ? 'active' : ''}}">
                <a href="{{route('department.index')}}">
                    <i class="material-icons">person_add</i>
                    <span>Department Info</span>
                </a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasRole('admin'))
            <li class="{{Request::is('features') ? 'active' : ''}}">
                <a href="{{route('features.index')}}">
                    <i class="material-icons">person_add</i>
                    <span>Add Features</span>
                </a>
            </li>
            @endif
            @if(auth()->check() && auth()->user()->hasRole('super-admin'))
            <li class="{{Request::is('features') ? 'active' : ''}}">
                <a href="{{route('features.index')}}">
                    <i class="material-icons">person_add</i>
                    <span>Add Features</span>
                </a>
            </li>
            @endif
            @if(!auth()->user()->api_token)
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                    <i class="material-icons">input</i>
                    <span>Sign Out</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
            @endif
            @endrole

        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2021 <a href="https://dma-bd.com">Datasoft Manufacturing & Assembly Inc. Ltd.</a>.
            <p>Beta Version1.7.2-b</p>
        </div>
    </div>
</aside>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        if (sessionStorage.getItem("roomId") != null) {
            $(".btn-group").css("display", "none");
            $(".menu").css("display", "none");
        } else {
            $(".btn-group").css("display", "inline-block");
            $(".menu").css("display", "unset");
        }
    })

</script>
