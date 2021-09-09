@extends('layouts.portal.app')

@section('title', 'Dashboard')
@push('css')
    

@endpush
@section('content')
<!-- Main Wrapper -->
<div class="main-wrapper">
    <!-- Dashboard Banner -->
    <section class="section section-search">
        @include('layouts.portal.partial.searchHeader') 
    </section>
    <!-- /Dashboard Banner -->
      
    <!-- Clinic and Specialities -->
    <section class="section section-specialities">
        @include('layouts.portal.partial.Specialities') 
    </section>   
    <!-- Clinic and Specialities -->
  
    <!-- Popular Section -->
    <section class="section section-doctor">
        @include('layouts.portal.partial.bookingDoctor')
    </section>
    <!-- /Popular Section -->
   
   <!-- Availabe Features -->
   <section class="section section-features">
        @include('layouts.portal.partial.availableFeatures')
    </section>      
    <!-- /Availabe Features -->
            
    
    <!-- Footer -->
    
    <!-- /Footer -->
   
</div>
<!-- /Main Wrapper -->

@endsection
@push('js')
    <script>     
        $( document ).ready(function() {  
		    localStorage.removeItem('scheduleId');
		    localStorage.removeItem('visitDate');
		    localStorage.removeItem('visitTime');
        });
    </script>
@endpush
