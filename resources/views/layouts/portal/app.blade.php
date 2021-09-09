<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	@php
	$clinic = getClinicInfo();
	@endphp
	@foreach ($clinic as $c)
		<title>@yield('title') - {{ $c->name }}</title>
	@endforeach
    

    {{-- <!-- <link href="{{ asset('assets/frontend/css/bootstrap.css' )}}" rel="stylesheet">
	<link href="{{ asset('assets/frontend/css/swiper.css' )}}" rel="stylesheet">
	<link href="{{ asset('assets/frontend/css/ionicons.css' )}}" rel="stylesheet"> -->		 --}}
	<!-- Favicons -->
	<link type="image/x-icon" href="{{ asset('assets/frontend/portal/img/favicon.png' )}}" rel="icon">
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('assets/frontend/portal/css/bootstrap.min.css' )}}">
	
	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset('assets/frontend/portal/plugins/fontawesome/css/fontawesome.min.css' )}}">
	<link rel="stylesheet" href="{{ asset('assets/frontend/portal/plugins/fontawesome/css/all.min.css' )}}">
	
	<!-- Main CSS -->
	<link rel="stylesheet" href="{{ asset('assets/frontend/portal/css/style.css' )}}">
	<link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
	@stack('css')
</head>
<body>
	@include('layouts.portal.partial.header')

	@yield('content')
	<!-- section -->
	@include('layouts.portal.partial.footer')
	
	<!-- <script src="{{ asset('assets/frontend/js/jquery-3.1.1.min.js' )}}"></script>
	<script src="{{ asset('assets/frontend/js/tether.min.js' )}}"></script>
	<script src="{{ asset('assets/frontend/js/bootstrap.js' )}}"></script>
    <script src="{{ asset('assets/frontend/js/swiper.js' )}}"></script>
	<script src="{{ asset('assets/frontend/js/scripts.js' )}}"></script> -->

	<!-- jQuery -->
	<script src="{{ asset('assets/frontend/portal/js/jquery.min.js' )}}"></script>
	
	<!-- Bootstrap Core JS -->
	<script src="{{ asset('assets/frontend/portal/js/popper.min.js' )}}"></script>
	<script src="{{ asset('assets/frontend/portal/js/bootstrap.min.js' )}}"></script>
	
	<!-- Slick JS -->
	<script src="{{ asset('assets/frontend/portal/js/slick.js' )}}"></script>
	
	<!-- Custom JS -->
	<script src="{{ asset('assets/frontend/portal/js/script.js' )}}"></script>
	<script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
	{!! Toastr::message() !!}
        <script>
        @if($errors->any())
            @foreach($errors->all() as $error)
            toastr.error('{{ $error }}','Error',{
                CloseButton:true,
                ProgressBar:true,
				positionClass : "toast-top-center" 
            });
            @endforeach
        @endif
    </script>
	@stack('js')
</body>
</html>