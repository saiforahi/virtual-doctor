<div class="container-fluid">
    <div class="section-header text-center">
        <h2>Book Our Doctor</h2>
        {{-- <p>Lorem Ipsum is simply dummy text </p> --}}
    </div>

    <div class="row">

        <!-- <div class="col-lg-4">
                    <div class="section-header ">
                        <h2>Book Our Doctor</h2>
                        <p>Lorem Ipsum is simply dummy text </p>
                    </div>
                    <div class="about-content">
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum.</p>
                        <p>web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes</p>                 
                        <a href="javascript:;">Read More..</a>
                    </div>
                </div> -->
        <div class="col-lg-12">
            <div class="doctor-slider slider">

                <!-- Doctor Widget -->
                @foreach ($doctor as $data)
                    <div class="profile-widget">
                        <div class="doc-img">
                            {{--
                            {{ asset('public/storage/profile/' . $post->user->image) }} --}}
                            <a href="{{ route('doctor-profile',$data->user_id) }}">
                                <img class="img-fluid" alt="User Image" src=" @if( is_null($data->users->image)) {{ url('storage/profile/no_profile.png') }} @else {{ url('storage/profile/'.$data->users->image) }} @endif ">
                            </a>
                            <a href="javascript:void(0)" class="fav-btn">
                                <i class="far fa-bookmark"></i>
                            </a>
                        </div>
                        <div class="pro-content">
                            <h3 class="title">
                                <a href="{{ route('doctor-profile',$data->user_id) }}">{{ $data->users->name }}</a>
                                <i class="fas fa-check-circle verified"></i>
                            </h3>
                            {{--<p class="speciality">{{ doctor_degree_details($data->user_id) }} - {{ getDeptNameById($data->department_id) }}</p>--}}
                            {{--<p class="doc-department">{{ getDeptNameById($data->department_id) }}</p>--}}
                            <p class="speciality">{{ doctor_degree_details($data->user_id) }} - {{ getDeptNameById($data->department_id) }}</p>
                            <p class="doc-department">{{ getDeptNameById($data->department_id) }}</p>
                            <div class="rating">
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <span class="d-inline-block average-rating">(17)</span>
                            </div>
                            <ul class="available-info">
                                <li>
                                    <i class="fas fa-map-marker-alt"></i> {{ $data->users->address }}
                                </li>
                                {{-- <li>
                                    <i class="far fa-clock"></i> Available on Fri, 22 Mar
                                </li> --}}
                                <li>
                                    <i class="far fa-money-bill-alt"></i> {{ $data->visit_fee }} Tk
                                    <i class="fas fa-info-circle" data-toggle="tooltip" title="per hour"></i>
                                </li>
                            </ul>
                            <div class="row row-sm">
                                <div class="col-6">
                                    <a href="{{ route('doctor-profile', $data->user_id) }}" class="btn view-btn">View
                                        Profile</a>

                                </div>
                                <div class="col-6">
                                    @if(auth()->check() && auth()->user()->hasRole('user'))                                        
                                        <a href="{{ route('book-appoinment', $data->user_id) }}" class="btn book-btn">Book Now</a>
                                    @elseif(auth()->check() && (auth()->user()->hasRole('doctor') ||  auth()->user()->hasRole('admin') ||  auth()->user()->hasRole('moderator')))
                                        <a href="#" class="btn book-btn">Book Now</a>
                                    @else
                                        <a href="{{ route('book-appoinment', $data->user_id) }}" class="btn book-btn">Book Now</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- /Doctor Widget -->



            </div>
        </div>
    </div>
</div>
