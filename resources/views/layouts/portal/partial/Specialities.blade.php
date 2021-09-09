<div class="container-fluid">
            <div class="section-header text-center">
                <h2>Our Specialities</h2>
                {{-- <p class="sub-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p> --}}
            </div>
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <!-- Slider -->
                    <div class="specialities-slider slider">
                        <!-- Slider Item -->
                        @foreach ($departments as $d)
                        <div class="speicality-item text-center">
                            <div class="speicality-img">
                                <img src="{{ asset('storage/app/public/departments/'.$d->image) }}" class="img-fluid" alt="Speciality">
                                <span><i class="fa fa-circle" aria-hidden="true"></i></span>
                            </div>
                            <p>{{ $d->name }}</p>
                        </div> 
                        @endforeach 
                        <!-- /Slider Item -->  
                </div>
            </div>
        </div>  