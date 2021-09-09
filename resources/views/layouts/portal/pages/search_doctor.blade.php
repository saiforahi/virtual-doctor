@if(empty($speciality))
    @php $speciality = [] @endphp
@endif

@if(empty($gender))
    @php $gender = [] @endphp
@endif

@extends('layouts.portal.app')

@section('title', 'Search Doctor')
    @push('css')

        <!-- Datetimepicker CSS -->
        <link rel="stylesheet" href="{{ asset('public/assets/frontend/portal/css/bootstrap-datetimepicker.min.css') }}">

        <!-- Select2 CSS -->
        <link rel="stylesheet" href="{{ asset('public/assets/frontend/portal/plugins/select2/css/select2.min.css') }}">

        <!-- Fancybox CSS -->
        <link rel="stylesheet" href="{{ asset('public/assets/frontend/portal/plugins/fancybox/jquery.fancybox.min.css') }}">
    @endpush
@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8 col-12">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Search</li>
                        </ol>
                    </nav>
                    <h2 class="breadcrumb-title">{{ $counter }} matches found based on your search</h2>
                </div>
                <div class="col-md-4 col-12 d-md-block d-none">
                    <div class="sort-by">
                        <span class="sort-title">Sort by</span>
                        <span class="sortby-fliter">
                            <select class="select">
                                <option>Select</option>
                                <option class="sorting">Rating</option>
                                <option class="sorting">Popular</option>
                                <option class="sorting">Latest</option>
                                <option class="sorting">Free</option>
                            </select>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">
                    <form action="{{ route('search-doctor') }}" >
                        <!-- Search Filter -->
                        <div class="card search-filter">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Search Filter</h4>
                            </div>
                            <div class="card-body">
                                <div class="filter-widget">
                                    <div class="form-group">
                                         <h4> <i class="fas fa-map-marker-alt"></i> Location</h4>
                                        <input type="text" class="form-control" name="location" value="{{ $location }}" placeholder="Area or City or Country">
                                    </div>
                                </div>
                                <div class="filter-widget">
                                    <h4>Gender</h4>
                                    <div>                                        
                                        <label class="custom_check">
                                            <input type="checkbox" name="gender[]"  @if (in_array('Male', $gender)) checked @endif value="Male" >
                                            <span class="checkmark"></span> Male Doctor
                                        </label>
                                    </div>
                                    <div>
                                        <label class="custom_check">
                                            <input type="checkbox" name="gender[]" value="Female"  @if (in_array('Female', $gender)) checked @endif>
                                            <span class="checkmark"></span> Female Doctor
                                        </label>
                                    </div>
                                </div>
                                <div class="filter-widget">
                                    <h4>Select Specialist</h4>
                                    @foreach ($departments as $d)
                                        <div>
                                        <label class="custom_check">
                                            <input type="checkbox" name="specialist[]" @if (in_array($d->name, $speciality)) checked @endif value="{{ $d->name }}">
                                            <span class="checkmark"></span> {{ $d->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                    
                                </div>
                                <div class="btn-search">
                                    <button type="submit" class="btn btn-block">Search</button>
                                </div>
                            </div>
                        </div>
                        <!-- /Search Filter -->
                    </form>
                </div>

                <div class="col-md-12 col-lg-8 col-xl-9">

                    <!-- Doctor Widget -->
                    @if ($doctor->isEmpty())
                        <p class="text-danger">Sorry! No Doctors Found based on your query.</p>
                    @else
                        @foreach ($doctor as $data)
                            <div class="card">
                                <div class="card-body">
                                    <div class="doctor-widget">
                                        <div class="doc-info-left">
                                            <div class="doctor-img">
                                                <a href="{{ route('doctor-profile', $data->user_id) }}">
                                                    <img src=" @if( is_null($data->users->image)) {{ url('storage/app/public/profile/no_profile.png') }} @else {{ url('storage/app/public/profile/'.$data->users->image) }} @endif "
                                                        class="img-fluid" alt="User Image">
                                                </a>
                                            </div>
                                            <div class="doc-info-cont">
                                                <h4 class="doc-name"><a
                                                        href="{{ route('doctor-profile', $data->user_id) }}">{{ $data->users->name }}</a>
                                                </h4>
                                                <p class="doc-speciality">{{ doctor_degree_details($data->user_id) }}</p>
                                                <h5 class="doc-department"><img
                                                        src="{{ asset('public/assets/frontend/portal/img/specialities/specialities-05.png') }}"
                                                        class="img-fluid"
                                                        alt="Speciality">{{ getDeptNameById($data->department_id) }}</h5>
                                                <div class="rating">
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star filled"></i>
                                                    <i class="fas fa-star"></i>
                                                    <span class="d-inline-block average-rating">(17)</span>
                                                </div>
                                                <div class="clinic-details">
                                                    <p class="doc-location">
                                                        <i class="fas fa-map-marker-alt"></i> {{ $data->users->address }}                                                        
                                                    </p>
                                                    <ul class="clinic-gallery">
                                                        <li>
                                                            <a href="{{ asset('public/assets/frontend/portal/img/features/feature-01.jpg') }}"
                                                                data-fancybox="gallery">
                                                                <img src="{{ asset('public/assets/frontend/portal/img/features/feature-01.jpg') }}"
                                                                    alt="Feature">
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ asset('public/assets/frontend/portal/img/features/feature-02.jpg') }}"
                                                                data-fancybox="gallery">
                                                                <img src="{{ asset('public/assets/frontend/portal/img/features/feature-02.jpg') }}"
                                                                    alt="Feature">
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ asset('public/assets/frontend/portal/img/features/feature-03.jpg') }}"
                                                                data-fancybox="gallery">
                                                                <img src="{{ asset('public/assets/frontend/portal/img/features/feature-03.jpg') }}"
                                                                    alt="Feature">
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ asset('public/assets/frontend/portal/img/features/feature-04.jpg') }}"
                                                                data-fancybox="gallery">
                                                                <img src="{{ asset('public/assets/frontend/portal/img/features/feature-04.jpg') }}"
                                                                    alt="Feature">
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                {{-- <div class="clinic-services">
                                                    <span>Dental Fillings</span>
                                                    <span> Whitneing</span>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="doc-info-right">
                                            <div class="clini-infos">
                                                <ul>
                                                    <li><i class="far fa-thumbs-up"></i> 98%</li>
                                                    <li><i class="far fa-comment"></i> 17 Feedback</li>
                                                    {{-- <li><i
                                                            class="fas fa-map-marker-alt"></i> Florida, USA</li>
                                                    --}}
                                                    <li><i class="far fa-money-bill-alt"></i> {{ $data->visit_fee }} Tk <i
                                                            class="fas fa-info-circle" data-toggle="tooltip"
                                                            title="per hour"></i> </li>
                                                </ul>
                                            </div>
                                            <div class="clinic-booking">
                                                <a class="view-pro-btn"
                                                    href="{{ route('doctor-profile', $data->user_id) }}">View Profile</a>
                                                <a class="apt-btn" href="{{ route('book-appoinment',$data->user_id) }}">Book
                                                    Appointment</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <!-- /Doctor Widget -->


                    <div class="load-more text-center">
                        @if ($keyword != '')
                            {{ $doctor->links() }}
                        @endif
                        {{-- <a class="btn btn-primary btn-sm" href="javascript:void(0);">Load
                            More</a> --}}
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- /Page Content -->
@endsection
@push('js')
    <!-- Sticky Sidebar JS -->
    <script src="{{ asset('public/assets/frontend/portal/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
    <script src="{{ asset('public/assets/frontend/portal/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}">
    </script>

    <!-- Select2 JS -->
    <script src="{{ asset('public/assets/frontend/portal/plugins/select2/js/select2.min.js') }}"></script>

    <!-- Datetimepicker JS -->
    <script src="{{ asset('public/assets/frontend/portal/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/assets/frontend/portal/js/bootstrap-datetimepicker.min.js') }}"></script>

    <!-- Fancybox JS -->
    <script src="{{ asset('public/assets/frontend/portal/plugins/fancybox/jquery.fancybox.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('public/assets/frontend/portal/js/script.js') }}"></script>
@endpush
