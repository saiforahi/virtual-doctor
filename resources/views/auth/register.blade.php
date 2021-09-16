@extends('layouts.frontend.app')

@section('title', 'Registration')
    @push('css')
        <link rel="icon" type="image/png" href="{{ asset('assets/frontend/login/images/icons/favicon.ico') }}" />
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/frontend/login/vendor/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/countrycode/pidie-0.0.8.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/frontend/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/frontend/login/fonts/iconic/css/material-design-iconic-font.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/login/vendor/animate/animate.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/frontend/login/vendor/css-hamburgers/hamburgers.min.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/frontend/login/vendor/animsition/css/animsition.min.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/frontend/login/vendor/select2/select2.min.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/frontend/login/vendor/daterangepicker/daterangepicker.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/login/css/util.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/login/css/main.css') }}">
        <style>
            img {
                display: block;
                margin-left: auto;
                margin-right: auto;
                height: 100px;
                width: 170px;
            }

            .pd-telephone-input {
                margin: 0;
            }

            .pd-telephone-input input {
                line-height: 2.50;
                border-radius: 0;
                padding-left: 75px;
                border: none;
            }

            .pd-telephone-input .pd-telephone-dropdown {
                top: 30px;
            }

            .pd-telephone-input .pd-telephone-flag {
                padding: 2px 16px 2px 13px;
            }

            .pd-telephone-input .pd-telephone-flag::after {
                left: 55px;
            }

            .input100 {
                border: none;
            }

            .input100:focus {
                outline: none;y
            }

        </style>
    @endpush
@section('content')

    <div class="limiter">
        <div class="container-login100"
            style="background-image: url('{{ asset('assets/frontend/login/images/bg-01.jpg') }}');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <form class="login100-form validate-form" method="POST" action="{{ route('registration') }}"
                    aria-label="{{ __('Register') }}" autocomplete="off">
                    @csrf
                    <a href="/">
                        <div class="logo">
                            <img src="{{ asset('DMA.gif') }}" class="center">
                        </div>
                    </a>
                    <span class="login100-form-title p-b-49">
                        Registration
                    </span>
                    <div class="wrap-input100 validate-input m-b-23" data-validate="Username is reauired">
                        <span class="label-input100">{{ __('Name') }}</span>
                        <input id="name" type="text" class="input100{{ $errors->has('name') ? ' is-invalid' : '' }}"
                            name="name" placeholder="Type your Name" value="{{ old('name') }}" required autofocus>
                        <span class="focus-input100" data-symbol="&#x270E;"></span>
                    </div>
                    {{--<!-- <div class="wrap-input100 validate-input m-b-23" data-validate = "Username is reauired">
                                <span class="label-input100">{{ __('User Name') }}</span>
                                <input id="username" type="text" class="input100{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" placeholder="Type your user name" value="{{ old('username') }}" required autofocus>
                                <span class="focus-input100" data-symbol="&#x270E;"></span>
                                @if($errors->has('username'))
                                    <span class="focus-input100" data-symbol="&#xf206;">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div> -->--}}
                    <!-- <div class="wrap-input100 validate-input m-b-23" data-validate = "Phone No is reauired">
                                <span class="label-input100">{{ __('Phone No') }}</span>
                                <input id="phone" type="text" class="input100{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" placeholder="Type your phone no" value="{{ old('phone') }}" required autofocus>
                                <span class="focus-input100" data-symbol="&#x260E;"></span>
                            </div> -->
                    <!-- <div class="wrap-input100 validate-input m-b-23 pd-telephone-input" data-validate = "Phone No is reauired">
                                <span class="label-input100">{{ __('Phone No') }}</span>
                                <input id="phone" type="tel" class="input100{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" placeholder="Type your phone no" value="{{ old('phone') }}" required autofocus>
                                <span class="focus-input100" data-symbol="&#x260E;"></span>
                            </div>    -->
                    <div class="wrap-input100 validate-input m-b-23" data-validate="Phone is reauired">
                        <span class="label-input100">{{ __('Phone number') }}</span>
                        <div class="pd-telephone-input">
                            <input id="phone" type="tel" pattern="[\+][0-9]{10,15}"
                                class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone"
                                placeholder="Type your phone no" oninvalid="this.setCustomValidity('Enter Valid phone no')"
                                oninput="this.setCustomValidity('')" value="{{ old('phone') }}" required autofocus>
                        </div>
                    </div>
                    <!-- <div class="pd-telephone-input">
                                <span class="label-input100">{{ __('Phone No') }}</span>
                                <input type="tel" class="form-control"/>
                            </div>  -->
                    <div class="wrap-input100 validate-input m-b-23" data-validate="Email is reauired">
                        <span class="label-input100">{{ __('E-Mail Address') }}</span>
                        <input id="email" type="email" class="input100{{ $errors->has('email') ? ' is-invalid' : '' }}"
                            name="email" placeholder="Type your email address" value=""
                            oninvalid="this.setCustomValidity('Enter Valid Email address')"
                            oninput="this.setCustomValidity('')" required autofocus>
                        <span class="focus-input100" data-symbol="&#9993;"></span>
                    </div>
                    <div class="wrap-input100 validate-input m-b-23" data-validate="Age No is required">
                        <span class="label-input100">{{ __('Age') }}</span>
                        <input id="age" type="number" class="input100{{ $errors->has('age') ? ' is-invalid' : '' }}"
                            name="age" placeholder="Type your age" value="{{ old('age') }}" required autofocus>
                        <span class="focus-input100" data-symbol="&#x270E;"></span>
                    </div>
                    <div class="wrap-input100 validate-input m-b-23" data-validate="Gender is reauired">
                        <span class="label-input100">{{ __('Gender') }}</span>
                        <select name="gender" class="input100" placeholder="Select your Gender" value="{{ old('gender') }}"
                            required autofocus>
                            <option value="">Select gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <span class="focus-input100" data-symbol="🗸"></span>
                    </div>
                    <div class="wrap-input100 validate-input m-b-23" data-validate="User Type is reauired">
                        <span class="label-input100">{{ __('Role') }}</span>
                        <select name="role_id" class="input100" placeholder="Select your " value="{{ old('role_id') }}" required>
                            <option value="">Select user type</option>
                            <?php $roles = getRoles(); ?>
                            @foreach ($roles as $role)
                                @if($role->name != 'patient')
                                    <option value={{$role->id}}>{{$role->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <span class="focus-input100" data-symbol="🗸"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-23" data-validate="Password is required">
                        <span class="label-input100">{{ __('Password') }}</span>
                        <input id="password" type="password"
                            class="input100{{ $errors->has('password') ? ' is-invalid' : '' }}"
                            placeholder="Type your password" name="password" required>
                        <span class="focus-input100" data-symbol="&#xf190;"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-23" data-validate="Password is required">
                        <span class="label-input100">{{ __('Confirm Password') }}</span>
                        <input id="password-confirm" type="password"
                            class="input100{{ $errors->has('password') ? ' is-invalid' : '' }}"
                            placeholder="Retype your password" name="password_confirmation" required>
                        <span class="focus-input100" data-symbol="&#xf190;"></span>
                    </div>
                    

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" type="submit">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>

                    <div class="txt1 text-center p-t-54 p-b-20">
                        <span>
                            If Registered Please <a style="color: #38c91e; text-align: left;"
                                href="{{ route('login') }}">Login</a>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

@endsection
@push('js')
    <script src="{{ asset('assets/frontend/countrycode/pidie-0.0.8.js') }}"></script>
    <script>
        new Pidie();

    </script>
    <script src="{{ asset('assets/frontend/login/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/login/vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/login/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('assets/frontend/login/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/login/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/login/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/login/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/frontend/login/vendor/countdowntime/countdowntime.js') }}"></script>
    <script src="{{ asset('assets/frontend/login/js/main.js"></script>
@endpush
