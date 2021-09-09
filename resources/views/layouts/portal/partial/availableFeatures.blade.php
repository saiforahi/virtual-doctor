<div class="container-fluid">

    <div class="row">
        <div class="col-md-4 features-img">
            <img src="{{ asset('assets/frontend/portal/img/features/feature.png') }}" class="img-fluid"
                alt="Feature">
        </div>

        <div class="col-md-8">
            <div class="section-header">
                <h2 class="mt-2">Availabe Features in Our Clinic</h2>
                {{-- <p>Description</p> --}}
            </div>
            <div class="features-slider slider">
                <!-- Slider Item -->
                @foreach ($features as $feature)
                    <div class="feature-item text-center">
                        <img src="{{ asset('storage/app/public/features/'.$feature->image) }}"
                            class="img-fluid" alt="Feature">
                        <p>{{ $feature->name }}</p>
                    </div>
                @endforeach
                <!-- /Slider Item -->


            </div>
        </div>

    </div>
</div>
