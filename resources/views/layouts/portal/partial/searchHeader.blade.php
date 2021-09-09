<div class="container-fluid">
    <div class="banner-wrapper">
        <div class="banner-header text-center">
            <h1>Search Doctor, Make an Appointment</h1>
            <p>Discover the best doctors the city nearest to you.</p>
        </div>

        <!-- Search -->
        <div class="search-box">
            <form action="{{ route('search-doctor') }}">
                <div class="form-group search-location">
                    <input type="text" class="form-control" name="location" placeholder="Search Location">
                    <span class="form-text">Ex : Dhaka or Gulshan 1, Bangladesh</span>
                </div>
                <div class="form-group search-info">
                    <input type="text" class="form-control" name="kw"
                        placeholder="Search Doctors by Name or Speciality etc">
                    <span class="form-text">Ex : Dr.Kibria or Dentist etc</span>
                </div>
                <button type="submit" class="btn btn-primary search-btn"><i class="fas fa-search"></i>
                    <span>Search</span></button>
            </form>
        </div>
        <!-- /Search -->

    </div>
</div>
