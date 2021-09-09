@extends('layouts.portal.app')

@section('title', 'Virtual Doctor')
@push('css')
<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/frontend/portal/plugins/fontawesome/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/assets/frontend/portal/plugins/fontawesome/css/all.min.css') }}">

<!-- Fancybox CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/frontend/portal/plugins/fancybox/jquery.fancybox.min.css') }}">

<!-- Main CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/frontend/portal/css/style.css') }}">

@endpush
@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Checkout</h2>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container">

        <div class="row">
            <div class="col-md-7 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @if(auth()->check() && auth()->user()->hasRole('user'))
                        <!-- Checkout Form -->
                        <form id="form" method="POST" action="{{ url('pay') }}">
                            @csrf
                            <!-- Personal Information -->
                            <input type="hidden" name="schedule_id" value="{{ $schedule_id }}">
                            <input type="hidden" id="doc_id" name="doctor_id" value="{{ $id }}">
                            <input type="hidden" id="visit_date" name="visit_date" value="">
                            <input type="hidden" id="name" name="name" value="{{ auth()->user()->name }}">
                            <input type="hidden" id="email" name="email" value="{{ auth()->user()->email }}">
                            <input type="hidden" id="phone" name="phone" value="{{ auth()->user()->phone }}">
                            <input type="hidden" id="address" name="address" value="{{ auth()->user()->address }}">
                            
                             @foreach ($doctor->doctors as $data)
                                         <input type="hidden" id="visit_fee" name="visit_fee" value="{{ $data->visit_fee +10 }}">
                                        @endforeach
                          

                            <div class="info-widget">
                                <h4 class="card-title">Symptoms *</h4>
                                <div class="row clearfix">
                                   
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea style="border:1px solid gray" rows="3" name="patient_symptoms"
                                                    class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="card-title">Vital Signs (optionals)</h4>
                                <hr>
                                <div class="row clearfix">                                    
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="row clearfix">
                                            <div class="col-lg-6 col-md-4 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="temperature" name="temperature"
                                                            class="form-control" placeholder="Temperature (if any)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2 form-control-label">
                                                <label for="temperature">F </label>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-6 col-md-4 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="pulse" name="pulse" class="form-control"
                                                            placeholder="Pulse (if any)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label">
                                                <label for="pulse">bpm </label>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-6 col-md-4 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="blood_pressure" name="blood_pressure"
                                                            class="form-control" placeholder="Blood Pressure (if any)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label">
                                                <label for="blood_pressure">mmHg </label>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-6 col-md-4 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="oxygen" name="oxygen_rate"
                                                            class="form-control" placeholder="Oxygen Rate (if any)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label">
                                                <label for="oxygen_rate"> % </label>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-6 col-md-4 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="weight" name="weight"
                                                            class="form-control" placeholder="weight (if any)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label">
                                                <label for="weight"> kg </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /Personal Information -->

                            <div class="payment-widget">
                               {{-- <h4 class="card-title">Payment Method</h4>
                                <!-- Paypal Payment -->
                                <div class="payment-list">
                                    <label class="payment-radio paypal-option">
                                        <input type="radio" name="radio" checked>
                                        <span class="checkmark"></span>
                                        Offline (Bkash)
                                    </label>
                                </div>
                                <br>--}}
                                <!-- /Paypal Payment -->

                                <!-- Submit Section -->
                                <div class="submit-section mt-4">
                                    <button type="submit" class="btn btn-primary submit-btn">Confirm</button>
                                </div>
                                <!-- /Submit Section -->

                            </div>

                        </form>
                        <!-- /Checkout Form -->
                        @else
                        <form id="form" method="POST" action="{{ route('pay1') }}">
                            @csrf

                            <!-- Personal Information -->
                            <input type="hidden" name="schedule_id" value="{{ $schedule_id }}">
                            <input type="hidden" id="doc_id" name="doctor_id" value="{{ $id }}">
                            <input type="hidden" id="visit_date" name="visit_date" value="">
                            
                            
                            
                            
                             @foreach ($doctor->doctors as $data)
                                         <input type="hidden" id="visit_fee" name="visit_fee" value="{{ $data->visit_fee +10 }}">
                                        @endforeach
                          

                            <div class="info-widget">
                                <h4 class="card-title">Personal Information</h4>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group card-label">
                                            <label>Name *</label>
                                            <input class="form-control" type="text" name="name"
                                                value="{{ old('name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group card-label">
                                            <label>Phone *</label>
                                            <input class="form-control" type="tel" placeholder="Example: +8801XXXXXXXXX"
                                                name="phone" title="Please use country code with mobile number"
                                                value="{{ old('phone') }}" autocomplete="off" pattern="[\+][0-9]{10,15}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group card-label">
                                            <label>Email (optional)</label>
                                            <input class="form-control" type="email" name="email"
                                                value="{{ old('email') }}" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group card-label">
                                            <label>Age *</label>
                                            <input class="form-control" type="number" name="age"
                                                value="{{ old('age') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group card-label">
                                            <label>Address *</label>
                                            <input class="form-control" type="text"
                                                placeholder="Example: Mirpur 14, Dhaka, Bangladesh"
                                                value="{{ old('address') }}" autocomplete="off" name="address">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group ">
                                            {{-- <label>Gender *</label> --}}
                                            <select name="gender" class="form-control" required>
                                                <option selected>Select Gender *</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group card-label">
                                        </div>
                                    </div>
                                    <h4 class="card-title col-md-12 col-sm-12">Security Information</h4>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group card-label">
                                            <label>Password *</label>
                                            <input class="form-control" type="password" name="password"
                                                autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group card-label">
                                            <label>Confirm Password *</label>
                                            <input class="form-control" type="password" name="password_confirmation"
                                                autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="exist-customer">Existing User? <a href="{{ route('patient-login') }}">Click
                                        here to login</a></div>
                            </div>
                            <!-- /Personal Information -->

                            <div class="payment-widget">
                                {{--<h4 class="card-title">Payment Method</h4>                          

                                <!-- Paypal Payment -->
                                <div class="payment-list">
                                    <label class="payment-radio paypal-option">
                                        <input type="radio" name="radio" checked>
                                        <span class="checkmark"></span>
                                        Offline (Bkash)
                                    </label>
                                </div>
                                <br>--}}
                                <!-- /Paypal Payment -->

                                <!-- Terms Accept -->
                                <div class="terms-accept">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="terms_accept" required>
                                        <label for="terms_accept">I have read and accept <a href="#">Terms &amp;
                                                Conditions</a></label>
                                    </div>
                                </div>
                                <!-- /Terms Accept -->

                                <!-- Submit Section -->

                                <div class="submit-section mt-4">
                                    <button type="submit" class="btn btn-primary submit-btn">Confirm</button>
                                </div>
                                <!-- /Submit Section -->

                            </div>

                        </form>
                        @endif

                    </div>
                </div>

            </div>

            <div class="col-md-5 col-lg-4 theiaStickySidebar">

                <!-- Booking Summary -->
                <div class="card booking-card">
                    <div class="card-header">
                        <h4 class="card-title">Booking Summary</h4>
                    </div>
                    <div class="card-body">

                        <!-- Booking Doctor Info -->
                        <div class="booking-doc-info">
                            <a href="doctor-profile.html" class="booking-doc-img">
                                <img src="@if( is_null($doctor->image)) {{ url('storage/app/public/profile/no_profile.png') }} @else {{ url('storage/app/public/profile/'.$doctor->image) }} @endif"
                                    alt="User Image">
                            </a>
                            <div class="booking-info">
                                <h4><a href="doctor-profile.html">{{ $doctor->name }}</a></h4>
                                <div class="rating">
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star filled"></i>
                                    <i class="fas fa-star filled"></i>
                                    <span class="d-inline-block average-rating">(17)</span>
                                </div>
                                <div class="clinic-details">
                                    <p class="doc-location"><i class="fas fa-map-marker-alt"></i> {{ $doctor->address }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Booking Doctor Info -->

                        <div class="booking-summary">
                            <div class="booking-item-wrap">
                                <ul class="booking-date">
                                    <li>Date <span id="vDate"></span></li>
                                    <li>Time <span id="vTime"></span></li>
                                </ul>
                                <ul class="booking-fee">
                                    <li>Consulting Fee
                                        @foreach ($doctor->doctors as $data)
                                        <span>{{ $data->visit_fee }} Tk</span>
                                        @endforeach
                                    </li>
                                    <li>Booking Fee <span>10 Tk</span></li>
                                    {{-- <li>Video Call <span>$50</span></li>
                                        --}}
                                </ul>
                                <div class="booking-total">
                                    <ul class="booking-total-list">
                                        <li>
                                            <span>Total</span>
                                            <span class="total-cost">
                                                @foreach ($doctor->doctors as $data)
                                                {{ $data->visit_fee + 10 }} Tk
                                                @endforeach
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Booking Summary -->

            </div>
        </div>

    </div>

</div>
<!-- /Page Content -->

@endsection
@push('js')
<!-- Fancybox JS -->
<script src="{{ asset('public/assets/frontend/portal/plugins/fancybox/jquery.fancybox.min.js') }}"></script>

<!-- Custom JS -->
<script src="{{ asset('public/assets/frontend/portal/js/script.js') }}"></script>

<script>
    $( document ).ready(function() {  

            var doctorId = $('#doc_id').val();

            var visitDate = localStorage.getItem("visitDate");
            var visit_time = localStorage.getItem("visitTime");
            $('#vDate').text(visitDate);
            $('#visit_date').val(visitDate);
            $('#vTime').text(visit_time);

            setTimeout(function(){ 
                var base_url = window.location.origin;
                var pathArray = window.location.pathname.split( '/' )[1];               
                window.location.replace(base_url+'/'+pathArray+'/book-appoinment/'+ doctorId + '/')
            }, 300000);
        });
</script>



@endpush