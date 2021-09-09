@extends('layouts.portal.app')

@section('title', 'Booking')
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
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Booking</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Booking</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content success-page-cont">
				<div class="container-fluid">
				
					<div class="row justify-content-center">
						<div class="col-lg-6">
						
							<!-- Success Card -->
							<div class="card success-card">
								<div class="card-body">
									<div class="success-cont">
										<i class="fas fa-check"></i>
										<h3>Appointment booked Successfully!</h3>
										<p>You will receive an confirmation text to your phone.</p>
										{{-- <p>Appointment booked with <strong>Dr. Darren Elder</strong><br> on <strong>12 Nov 2019 5:00PM to 6:00PM</strong></p> --}}
										<a href="{{ route('dashboard') }}" class="btn btn-primary view-inv-btn">View Details</a>
									</div>
								</div>
							</div>
							<!-- /Success Card -->
							
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
            
            
            localStorage.clear(); 
            
            
        });
    </script>

@endpush
