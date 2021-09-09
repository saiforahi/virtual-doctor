<style>
    .navbar-header {
        padding: 10px 0 !important;
    }

    .user-role-info {
        color: #fff;
        line-height: 65px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .user-role-info i {
        vertical-align: sub;
    }

    .user-role-info #role-span .material-icons {
        display: none;
    }

    @media screen and (min-width: 300px) and (max-width: 768px) {
        .navbar .navbar-header {
            width: calc(100% + -14px);
        }

        .user-role-info #role-span {
            position: absolute;
            right: 15px;
            top: 50px;
            background: #fff;
            color: #000;
            padding: 10px;
            line-height: 1;
            border-radius: 4px;
            display: none;
        }

        .user-role-info #role-span .material-icons {
            position: absolute;
            top: -12px;
            right: -9px;
            font-size: 40px;
            color: #fff;
            z-index: -1;
            display: block;
        }

        .navbar .navbar-header img {
            margin-left: 24px !important;
        }

        .user-role-info {
            padding: 0px 10px;
        }
    }

</style>
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header text-center">
            <!-- <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a> -->
            <a href="javascript:void(0);" class="bars"></a>
            <img src="{{asset('public/VD.gif')}}" href="" style="height: 45px; width: 85px;margin: 0;">           
        </div>
        <div class="user-role-info float-right" onclick="showUserRole();">
            <i class="material-icons">
                verified_user
            </i>
            <span id="role-span">
                @if(auth()->check() && auth()->user()->hasRole('super-admin'))
                ADMIN DASHBOARD
                @elseif(auth()->check() && auth()->user()->hasRole('admin'))
                MODERATOR DASHBOARD
                @elseif(auth()->check() && auth()->user()->hasRole('power-user'))
                DOCTOR DASHBOARD
                @else
                PATIENT DASHBOARD
                @endif
                <i class="material-icons">
                    upgrade
                </i>
            </span>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                {{-- <span class="material-icons">
                        admin_panel_settings
                    </span> --}}
                <!-- Notifications -->
                <!-- <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count">7</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">person_add</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>12 new members joined</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 14 mins ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-cyan">
                                                <i class="material-icons">add_shopping_cart</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>4 sales made</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 22 mins ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-red">
                                                <i class="material-icons">delete_forever</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>Nancy Doe</b> deleted account</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-orange">
                                                <i class="material-icons">mode_edit</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>Nancy</b> changed name</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 2 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-blue-grey">
                                                <i class="material-icons">comment</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>John</b> commented your post</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 4 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">cached</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>John</b> updated status</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-purple">
                                                <i class="material-icons">settings</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>Settings updated</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> Yesterday
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>
                    </li> -->
                <!-- #END# Notifications -->

                {{-- <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li> --}}
            </ul>
        </div>
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>
    var width = window.innerWidth;

    function showUserRole() {
        if (width <= 768) {
            if (document.getElementById("role-span").style.display == "none") {
                document.getElementById("role-span").style.display = "block";
            } else {
                document.getElementById("role-span").style.display = "none";
            }
        }
    }

    $(document).ready(function () {
        if (sessionStorage.getItem("roomId") != null) {
            $(".user-role-info").css("display", "none");
        } else {
            $(".user-role-info").css("display", "unset");
        }
    });

</script>
