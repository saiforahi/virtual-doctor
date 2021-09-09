@extends('layouts.portal.app')

@section('title', 'Virtual Doctor')
@push('css')
<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/frontend/portal/plugins/fontawesome/css/fontawesome.min.css')}}">
<link rel="stylesheet" href="{{ asset('public/assets/frontend/portal/plugins/fontawesome/css/all.min.css')}}">

<!-- Daterangepikcer CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/frontend/portal/plugins/daterangepicker/daterangepicker.css')}}">

<!-- Main CSS -->
<link rel="stylesheet" href="{{ asset('public/assets/frontend/portal/css/style.css')}}">

@endpush
@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-md-12 col-12">
				<nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
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
<div class="content">
	<div class="container">

		<div class="row">
			<div class="col-12">

				<div class="card">
					<div class="card-body">
						<div class="booking-doc-info">
							<a href="{{route('doctor-profile', $doctor->id)}}" class="booking-doc-img">
								<img src="@if( is_null($doctor->image)) {{ url('storage/app/public/profile/no_profile.png') }} @else {{ url('storage/app/public/profile/'.$doctor->image) }} @endif"
									alt="User Image">
							</a>
							<input type="hidden" id="drid" value="{{  $doctor->id }}">
							<div class="booking-info">
								<h4><a href="{{route('doctor-profile', $doctor->id)}}">{{ $doctor->name }}</a></h4>
								<div class="rating">
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<i class="fas fa-star filled"></i>
									<span class="d-inline-block average-rating">(17)</span>
								</div>
								<p class="text-muted mb-0"><i class="fas fa-map-marker-alt"></i> {{ $doctor->address }}
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-4 col-md-6">
						<h4 class="mb-1">Today, {{ date('d F Y') }}</h4>
						<p class="text-muted">{{ date('l') }}</p>
						{{-- <p class="text-muted">{{ date('d F Y', strtotime(' +1 day')) }}</p> --}}
					</div>
					{{-- <div class="col-12 col-sm-8 col-md-6 text-sm-right">
						<div class="bookingrange btn btn-white btn-sm mb-3">
							<i class="far fa-calendar-alt mr-2"></i>
							<span></span>
							<i class="fas fa-chevron-down ml-2"></i>
						</div>
					</div> --}}
				</div>
				<!-- Schedule Widget -->
				<div class="card booking-schedule schedule-widget">

					<!-- Schedule Header -->
					<div class="schedule-header">
						<div class="row">
							<div class="col-md-12">

								<!-- Day Slot -->
								<div class="day-slot">
									<ul>
										<li class="left-arrow">
											<a href="#">
												<i class="fa fa-chevron-left"></i>
											</a>
										</li>
										<li>
											<span>{{ date('D') }}</span>
											<span class="slot-date">{{ date('d M') }} <small
													class="slot-year">{{ date('Y') }}</small></span>
										</li>
										<li>
											<span>{{ date('D', strtotime(' +1 day')) }}</span>
											<span class="slot-date">{{ date('d M', strtotime(' +1 day')) }} <small
													class="slot-year">{{ date('Y') }}</small></span>
										</li>
										<li>
											<span>{{ date('D', strtotime(' +2 day')) }}</span>
											<span class="slot-date">{{ date('d M', strtotime(' +2 day')) }} <small
													class="slot-year">{{ date('Y') }}</small></span>
										</li>
										<li>
											<span>{{ date('D', strtotime(' +3 day')) }}</span>
											<span class="slot-date">{{ date('d M', strtotime(' +3 day')) }} <small
													class="slot-year">{{ date('Y') }}</small></span>
										</li>
										<li>
											<span>{{ date('D', strtotime(' +4 day')) }}</span>
											<span class="slot-date">{{ date('d M', strtotime(' +4 day')) }} <small
													class="slot-year">{{ date('Y') }}</small></span>
										</li>
										<li>
											<span>{{ date('D', strtotime(' +5 day')) }}</span>
											<span class="slot-date">{{ date('d M', strtotime(' +5 day')) }} <small
													class="slot-year">{{ date('Y') }}</small></span>
										</li>
										<li>
											<span>{{ date('D', strtotime(' +6 day')) }}</span>
											<span class="slot-date">{{ date('d M', strtotime(' +6 day')) }} <small
													class="slot-year">{{ date('Y') }}</small></span>
										</li>
										<li class="right-arrow">
											<a href="#">
												<i class="fa fa-chevron-right"></i>
											</a>
										</li>
									</ul>
								</div>
								<!-- /Day Slot -->

							</div>
						</div>
					</div>
					<!-- /Schedule Header -->

					<!-- Schedule Content -->
					<div class="schedule-cont">
						<div class="row">
							<div class="col-md-12">

								<!-- Time Slot -->
								<div class="time-slot">
									<ul class="clearfix">
										<li>
											@php 
												$data = getDoctorSchedule($doctor->id,date('l')); 
												$is_booked = getIsBooked($doctor->id);
												$v_date = getVisitDate($doctor->id);
											@endphp

											@forelse ($data as $k=>$d)
												@php 
												$booked = 0;												
												foreach ($is_booked as $key => $value) {
													$booked_time = date('h:i A', strtotime($value));
													if($booked_time==date('h:i A', strtotime($d)) && $key==date('l', strtotime(' +1 day'))){
														$booked=1;
													}
												}	
												$booking_date = 0;											
												foreach ($v_date as $key => $value) {
													$booked_date = date('d M Y', strtotime($value->visit_date));													
													if($booked_date==date('d M Y')){
														$booking_date = 1;
													}
												}
												@endphp
												<a @if($booked==1 && $booking_date == 1) style="pointer-events: none;color:#ccc;background-color:red" @endif class="timing" id="sc{{ $k }}" data="{{ $k }}" data-date="{{ date('d M Y') }}" data-time="{{ date('h:i A', strtotime($d)) }}" style="cursor: pointer;">
													<span>{{ date('h:i A', strtotime($d)) }}</span>
												</a>
											@empty
												<a class="timing">
													<span>N/A</span>
												</a>
											@endforelse

										</li>
										<li>
											@php 
											$data = getDoctorSchedule($doctor->id,date('l', strtotime(' +1 day')));
											$is_booked = getIsBooked($doctor->id);
											$v_date = getVisitDate($doctor->id);
											@endphp
											@forelse ($data as $k=>$d)
												@php 
												$booked = 0;
												foreach ($is_booked as $key => $value) {
													$booked_time = date('h:i A', strtotime($value));
													if($booked_time==date('h:i A', strtotime($d)) && $key==date('l', strtotime(' +1 day'))){
														$booked=1;
													}
												}
												$booking_date = 0;											
												foreach ($v_date as $key => $value) {
													$booked_date = date('d M Y', strtotime($value->visit_date));													
													if($booked_date==date('d M Y', strtotime(' +1 day'))){
														$booking_date = 1;
													}
												}
												@endphp
												<a @if($booked==1 && $booking_date == 1) style="pointer-events: none;color:#ccc;background-color:red" @endif class="timing" id="sc{{ $k }}" data="{{ $k }}" data-date="{{ date('d M Y', strtotime(' +1 day')) }}" data-time="{{ date('h:i A', strtotime($d)) }}" style="cursor: pointer;">
													<span>{{ date('h:i A', strtotime($d)) }}</span>
												</a>
											@empty
												<a class="timing">
													<span>N/A</span>
												</a>
											@endforelse
										</li>
										<li>
											@php 
											$data = getDoctorSchedule($doctor->id,date('l', strtotime(' +2 day')));
											$is_booked = getIsBooked($doctor->id);
											$v_date = getVisitDate($doctor->id);
											@endphp
											@forelse ($data as $k=>$d)
												@php 
												$booked = 0;
												foreach ($is_booked as $key => $value) {
													$booked_time = date('h:i A', strtotime($value));
													if($booked_time==date('h:i A', strtotime($d))  && $key==date('l', strtotime(' +2 day'))){
														$booked=1;
													}
												}
												$booking_date = 0;											
												foreach ($v_date as $key => $value) {
													$booked_date = date('d M Y', strtotime($value->visit_date));													
													if($booked_date==date('d M Y', strtotime(' +2 day'))){
														$booking_date = 1;
													}
												}
												@endphp
												<a @if($booked==1 && $booking_date == 1) style="pointer-events: none;color:#ccc;background-color:red" @endif class="timing" id="sc{{ $k }}" data="{{ $k }}" data-date="{{ date('d M Y', strtotime(' +2 day')) }}" data-time="{{ date('h:i A', strtotime($d)) }}" style="cursor: pointer;">
													<span>{{ date('h:i A', strtotime($d)) }}</span>
												</a>
											@empty
												<a class="timing">
													<span>N/A</span>
												</a>
											@endforelse
										</li>
										<li>
											@php $data = getDoctorSchedule($doctor->id,date('l', strtotime(' +3 day')));
											$is_booked = getIsBooked($doctor->id);
											$v_date = getVisitDate($doctor->id);
											@endphp
											@forelse ($data as $k=>$d)
												@php 
												$booked = 0;
												foreach ($is_booked as $key => $value) {
													$booked_time = date('h:i A', strtotime($value));
													if($booked_time==date('h:i A', strtotime($d)) && $key==date('l', strtotime(' +3 day'))){
														$booked=1;
													}
												}
												$booking_date = 0;											
												foreach ($v_date as $key => $value) {
													$booked_date = date('d M Y', strtotime($value->visit_date));													
													if($booked_date==date('d M Y', strtotime(' +3 day'))){
														$booking_date = 1;
													}
												}
												@endphp
												<a @if($booked==1 && $booking_date == 1) style="pointer-events: none;color:#ccc;background-color:red" @endif class="timing" id="sc{{ $k }}" data="{{ $k }}" data-date="{{ date('d M Y', strtotime(' +3 day')) }}" data-time="{{ date('h:i A', strtotime($d)) }}" style="cursor: pointer;">
													<span>{{ date('h:i A', strtotime($d)) }}</span>
												</a>
											@empty
												<a class="timing">
													<span>N/A</span>
												</a>
											@endforelse
										</li>
										<li>
											@php $data = getDoctorSchedule($doctor->id,date('l', strtotime(' +4 day')));
											$is_booked = getIsBooked($doctor->id);
											$v_date = getVisitDate($doctor->id);
											@endphp
											@forelse ($data as $k=>$d)
												@php 
												$booked = 0;
												foreach ($is_booked as $key => $value) {
													$booked_time = date('h:i A', strtotime($value));
													if($booked_time==date('h:i A', strtotime($d)) && $key==date('l', strtotime(' +4 day'))){
														$booked=1;
													}
												}
												$booking_date = 0;											
												foreach ($v_date as $key => $value) {
													$booked_date = date('d M Y', strtotime($value->visit_date));													
													if($booked_date==date('d M Y', strtotime(' +4 day'))){
														$booking_date = 1;
													}
												}
												@endphp
												<a @if($booked==1 && $booking_date == 1) style="pointer-events: none;color:#ccc;background-color:red" @endif class="timing" id="sc{{ $k }}" data="{{ $k }}" data-date="{{ date('d M Y', strtotime(' +4 day')) }}" data-time="{{ date('h:i A', strtotime($d)) }}" style="cursor: pointer;">
													<span>{{ date('h:i A', strtotime($d)) }}</span>
												</a>
											@empty
												<a class="timing">
													<span>N/A</span>
												</a>
											@endforelse
										</li>
										<li>
											@php $data = getDoctorSchedule($doctor->id,date('l', strtotime(' +5 day')));
											$is_booked = getIsBooked($doctor->id);
											$v_date = getVisitDate($doctor->id);
											@endphp
											@forelse ($data as $k=>$d)
												@php 
												$booked = 0;
												foreach ($is_booked as $key => $value) {
													$booked_time = date('h:i A', strtotime($value));
													if($booked_time==date('h:i A', strtotime($d)) && $key==date('l', strtotime(' +5 day'))){
														$booked=1;
													}
												}
												$booking_date = 0;											
												foreach ($v_date as $key => $value) {
													$booked_date = date('d M Y', strtotime($value->visit_date));													
													if($booked_date==date('d M Y', strtotime(' +5 day'))){
														$booking_date = 1;
													}
												}
												@endphp
												<a @if($booked==1 && $booking_date == 1) style="pointer-events: none;color:#ccc;background-color:red" @endif class="timing" id="sc{{ $k }}" data="{{ $k }}" data-date="{{ date('d M Y', strtotime(' +5 day')) }}" data-time="{{ date('h:i A', strtotime($d)) }}" style="cursor: pointer;">
													<span>{{ date('h:i A', strtotime($d)) }}</span>
												</a>
											@empty
												<a class="timing">
													<span>N/A</span>
												</a>
											@endforelse
										</li>
										<li>
											@php $data = getDoctorSchedule($doctor->id,date('l', strtotime(' +6 day')));
											$is_booked = getIsBooked($doctor->id);
											$v_date = getVisitDate($doctor->id);
											@endphp
											@forelse ($data as $k=>$d)
												@php 
												$booked = 0;
												foreach ($is_booked as $key => $value) {
													$booked_time = date('h:i A', strtotime($value));
													if($booked_time==date('h:i A', strtotime($d)) && $key==date('l', strtotime(' +6 day'))){
														$booked=1;
													}
												}
												$booking_date = 0;											
												foreach ($v_date as $key => $value) {
													$booked_date = date('d M Y', strtotime($value->visit_date));													
													if($booked_date==date('d M Y', strtotime(' +6 day'))){
														$booking_date = 1;
													}
												}
												@endphp
												<a @if($booked==1 && $booking_date == 1) style="pointer-events: none;color:#ccc;background-color:red" @endif class="timing" id="sc{{ $k }}" data="{{ $k }}" data-date="{{ date('d M Y', strtotime(' +6 day')) }}" data-time="{{ date('h:i A', strtotime($d)) }}" style="cursor: pointer;">
													<span>{{ date('h:i A', strtotime($d)) }}</span>
												</a>
											@empty
												<a class="timing">
													<span>N/A</span>
												</a>
											@endforelse
										</li>
									</ul>
								</div>
								<!-- /Time Slot -->

							</div>
						</div>
					</div>
					<!-- /Schedule Content -->

				</div>
				<!-- /Schedule Widget -->

				<!-- Submit Section -->
				<div class="submit-section proceed-btn text-right">
					{{-- {{ route('checkout', $doctor->id) }} --}}
					<a id="proceed" class="btn btn-primary submit-btn">Proceed</a>
				</div>
				<!-- /Submit Section -->

			</div>
		</div>
	</div>

</div>
<!-- /Page Content -->
@endsection
@push('js')
<script src="{{ asset('public/assets/frontend/portal/js/moment.min.js')}}"></script>
<script src="{{ asset('public/assets/frontend/portal/plugins/daterangepicker/daterangepicker.js')}}"></script>

<!-- Custom JS -->
<script src="{{ asset('public/assets/frontend/portal/js/script.js')}}"></script>
<script>
	$( document ).ready(function() {

	if(localStorage.getItem("scheduleId")!=null){
		var id = localStorage.getItem("scheduleId");
		$('#sc'+id).addClass('selected');
	}

	$('a[id^="sc"]').on('click', function() { 
		if($(this).hasClass('selected')) {
			$(this).removeClass('selected');
			localStorage.removeItem("scheduleId");
			localStorage.removeItem("visitDate");
			localStorage.removeItem("visitTime");
		}else{
			$(this).addClass('selected');
			var dt = $(this).attr('data-time');
			// alert(dt);
			localStorage.setItem("scheduleId",$(this).attr('data'));
			localStorage.setItem("visitDate",$(this).attr('data-date'));
			localStorage.setItem("visitTime",dt);
			$('.timing').not(this).removeClass('selected');
		}
		
	});

	$('#proceed').on('click', function() { 
		var dr_id = $('#drid').val();
		var base_url = window.location.href.split( '/book-appoinment/' )[0];
		// var pathArray = window.location.pathname.split( '/' )[1];
		var scId = localStorage.getItem("scheduleId");
		// alert(pathArray);
		if(scId!=null){
			window.location.replace(base_url+'/checkout/'+ dr_id + '/'+ scId)	
		}else{
			alert("Please select a schedule time")
			return false;
		}
			
	});

	setTimeout(function(){ 
		localStorage.removeItem('scheduleId');
		localStorage.removeItem('visitDate');
		localStorage.removeItem('visitTime');
		window.location.reload();
	}, 300000);


});
</script>
@endpush