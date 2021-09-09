@extends('layouts.portal.app')

@section('title', 'Registration')
    @push('css')
        
    @endpush
    
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <!-- Register Content -->
                    <div class="account-content">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-7 col-lg-6 login-left">
                                <img src="{{ asset('assets/frontend/portal/img/login-banner.png') }}"
                                    class="img-fluid" alt="Doccure Register">
                            </div>
                            <div class="col-md-12 col-lg-6 login-right">
                                <div class="login-header">
                                    <h3>Patient Register
                                        <!-- <a href="doctor-register.html">Are you a Doctor?</a> -->
                                    </h3>
                                </div>

                                <!-- Register Form -->
                                <form method="POST" action="{{ route('registration') }}">
                                    @csrf
                                    <input type="hidden" name="role_id" value={{$patient_role_id}}>
                                    <div class="form-group form-focus">
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control floating"  autocomplete="off" required>
                                        <label class="focus-label">Name * </label>
                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="tel" name="phone" title="Please use country code with mobile number" value="{{ old('phone') }}"  autocomplete="off" pattern="[\+][0-9]{10,15}" class="form-control floating" required>
                                        <label class="focus-label">Mobile Number *</label>
                                        <small>Format: +8801XXXXXXXXX</small>
                                    </div>
                                    <br>
                                    <div class="form-group form-focus">
                                        <input type="email" name="email"  value="{{ old('email') }}" autocomplete="off" class="form-control floating">
                                        <label class="focus-label">Email (optional)</label>
                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="text" name="age" value="{{ old('age') }}" class="form-control floating" required>
                                        <label class="focus-label">Age *</label>
                                    </div>
                                    <div class="form-group">
                                        <select name="gender" class="form-control select select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true" required>
                                            <option selected>Gender *</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>                                        
                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="text" value="{{ old('address') }}" autocomplete="off" name="address" class="form-control floating" required>
                                        <label class="focus-label">Address *</label>
                                        <small>example: Mirpur 14, Dhaka, Bangladesh</small>
                                    </div>
                                    <br>
                                    <div class="form-group form-focus">
                                        <input type="password" id="password" data-rule-password="true" name="password" class="form-control floating"  autocomplete="off" required>
                                        <label class="focus-label">Password *</label>                                       
                                    </div>
                                    <div class="form-group form-focus">
                                        <input type="password" id="retype_password" data-rule-password="true" data-rule-equalTo="#password" name="password_confirmation" class="form-control floating"  autocomplete="off" required>
                                        <label class="focus-label">Confirm Password *</label>
                                        <small>N.B: Password and Confirm Password must be 8 character</small>
                                    </div>
                                    <br>                                   
                                    
                                    
                                    <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Signup</button>
                                    <div class="text-right">
                                        <a class="forgot-link" href="{{ route('patient-login') }}">Already have an
                                            account?</a>
                                    </div>
                                    {{-- <div class="login-or">
                                        <span class="or-line"></span>
                                        <span class="span-or">or</span>
                                    </div>
                                    <div class="row form-row social-login">
                                        <div class="col-6">
                                            <a href="#" class="btn btn-facebook btn-block"><i
                                                    class="fab fa-facebook-f mr-1"></i> Login</a>
                                        </div>
                                        <div class="col-6">
                                            <a href="#" class="btn btn-google btn-block"><i class="fab fa-google mr-1"></i>
                                                Login</a>
                                        </div>
                                    </div> --}}
                                </form>
                                <!-- /Register Form -->
                               
                            </div>
                             
                        </div>
                        <br>
                        <br>
                    </div>
                    <!-- /Register Content -->

                </div>
            </div>

        </div>

    </div>
    <!-- /Page Content -->


@endsection
@push('js')
    <!-- Fancybox JS -->
    <script src="{{ asset('assets/frontend/portal/plugins/fancybox/jquery.fancybox.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/frontend/portal/js/script.js') }}"></script>
@endpush
