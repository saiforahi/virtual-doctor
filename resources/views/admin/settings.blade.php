@extends('layouts.backend.app')

@section('title', 'Settings')

    @push('css')
        <style type="text/css">
            .img-holder {
                position: relative;
            }

            .form-check-input {
                position: absolute;
                top: 10px;
                left: unset !important;
                right: 10px;
                opacity: 1 !important;
                z-index: 9999;
            }

        </style>
    @endpush

@section('content')

    <div class="container-fluid">
        <!-- Tabs With Icon Title -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            SETTINGS
                        </h2>
                    </div>
                    <div class="body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist" id="setting_tab">
                            <li role="presentation" class="active">
                                <a href="#profile_with_icon_title" data-toggle="tab">
                                    <i class="material-icons">face</i> PROFILE
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#settings_with_icon_title" data-toggle="tab">
                                    <i class="material-icons">settings</i> CHANGE PASSWORD
                                </a>
                            </li>
                            @if(auth()->check() && auth()->user()->hasRole('doctor'))
                                <li role="presentation">
                                    <a href="#degree_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">cast_for_education</i> Academic
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#others_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">tonality</i> Professional Information
                                    </a>
                                </li>
                                 <li role="presentation">
                                            <a href="#time_with_icon_title" data-toggle="tab">
                                                <i class="material-icons">more_time</i> Time Schedule
                                            </a>
                                        </li> 
                            @endif
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="profile_with_icon_title">
                                <!-- Horizontal Layout -->
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="body">
                                            <form method="POST" action="{{ route('profile-update') }}"
                                                class="form-horizontal" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                        <label for="name">Name </label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input type="text" id="name" class="form-control"
                                                                    placeholder="Enter your name" name="name"
                                                                    value="{{ Auth::user()->name }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                        <label for="email_address_2">Email Address</label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input @if(!(auth() ->user()->hasRole('admin') || auth() ->user()->hasRole('moderator'))) readonly @endif type="text"
                                                                id="email_address_2" class="form-control" placeholder="Enter your email address" name="email"
                                                                value="{{ Auth::user()->email }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                        <label for="age">Age</label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input type="text" id="age" class="form-control"
                                                                    placeholder="Enter your age" name="age"
                                                                    value="{{ Auth::user()->age }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                        <label for="address">Address</label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input type="text" id="address" class="form-control"
                                                                    placeholder="Enter your address" name="address"
                                                                    value="{{ Auth::user()->address }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                        <label for="name">Profile Image </label>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7">
                                                        <div class="form-group">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail img-holder">
                                                                    <img id="blah"
                                                                        src=" @if(is_null(Auth::user()->image)) {{ url('storage/app/public/default.png') }} @else {{ url('storage/app/public/profile/' . Auth::user()->image) }} @endif "
                                                                        alt="profile image">

                                                                    <input type="checkbox" class="form-check-input" checked
                                                                        name="is_image" id="exampleCheck1"
                                                                        style="height: 30px;width: 30px">
                                                                </div>
                                                                <input class="form-control" type="file" name="image"
                                                                    id="imgInp">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                        <label for="phone">Phone</label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input @if(!(auth() ->user()->hasRole('admin') || auth() ->user()->hasRole('moderator'))) readonly @endif type="text"
                                                                class="form-control" name="phone"
                                                                value="{{ Auth::user()->phone }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                        <label for="gender">Gender</label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <select name="gender" class="form-control"
                                                                    placeholder="Select your Gender"
                                                                    value="{{ old('gender') }}" required>
                                                                    <option value="">Select Gender</option>
                                                                    <option value="Male" @if(Auth::user()->gender == 'Male')
                                                                        selected @endif>Male</option>
                                                                    <option value="Female" @if(Auth::user()->gender ==
                                                                        'Female') selected @endif>Female</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                        <label for="blood_group">Blood Group</label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <select name="blood_group" class="form-control"
                                                                    value="{{ old('blood_group') }}">
                                                                    <option value="">Select Blood Group</option>
                                                                    <option value="A+" @if(Auth::user()->blood_group ==
                                                                            'A+')
                                                                        selected @endif>A+</option>
                                                                    <option value="A-" @if(Auth::user()->blood_group ==
                                                                            'A-')
                                                                        selected @endif>A-</option>
                                                                    <option value="B+" @if(Auth::user()->blood_group ==
                                                                            'B+')
                                                                        selected @endif>B+</option>
                                                                    <option value="B-" @if(Auth::user()->blood_group ==
                                                                            'B-')
                                                                        selected @endif>B-</option>
                                                                    <option value="O+" @if(Auth::user()->blood_group ==
                                                                            'O+')
                                                                        selected @endif>O+</option>
                                                                    <option value="O-" @if(Auth::user()->blood_group ==
                                                                            'O-')
                                                                        selected @endif>O-</option>
                                                                    <option value="AB+" @if(Auth::user()->blood_group ==
                                                                        'AB+') selected @endif>AB+</option>
                                                                    <option value="AB-" @if(Auth::user()->blood_group ==
                                                                        'AB-') selected @endif>AB-</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @role('doctor')
                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                        <label for="blood_group">Department</label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <select name="department" class="form-control"
                                                                    value="{{ old('department') }}">
                                                                    <option value="">Select Department</option>
                                                                    @php $departments = get_departments();@endphp
                                                                    @foreach ($departments as $department)
                                                                        <option @if(Auth::user()->doctor->department_id==$department->id) selected @endif value={{$department->id}}>{{$department->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endrole
                                                <div class="row clearfix">
                                                    <div
                                                        class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                                        <a href="{{ route('dashboard') }}" style="text-decoration: none;">
                                                            <button type="button"
                                                                class="btn btn-danger m-t-15 waves-effect">CANCEL</button>
                                                        </a>
                                                        <button type="submit"
                                                            class="btn btn-primary m-t-15 waves-effect">UPDATE
                                                            PROFILE</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- #END# Horizontal Layout -->
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="settings_with_icon_title">
                                <form method="POST" action="{{ route('password-update') }}" class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="old_password">Old Password </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="password" id="old_password" class="form-control"
                                                        placeholder="Enter your old password" name="old_password" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="password">New Password </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="password" id="password" class="form-control"
                                                        placeholder="Enter your new password" name="password" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="confirm_password">Confirm Password </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="password" id="confirm_password" class="form-control"
                                                        placeholder="Confirm your new password" name="password_confirmation"
                                                        value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                            <a href="{{ route('dashboard') }}" style="text-decoration: none;">
                                                <button type="button"
                                                    class="btn btn-danger m-t-15 waves-effect">CANCEL</button>
                                            </a>
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE
                                                PASSWORD</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            @if(auth()->check() && auth()->user()->hasRole('doctor'))
                            <div role="tabpanel" class="tab-pane fade" id="time_with_icon_title">
                            <form method="POST" action="{{ route('doctor-schedule') }}" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                <div class="incs">
                                @if(!empty($doctor_schedule))
                                    @foreach($doctor_schedule as $doctorSched)
                                    <div class="day-row">
                                     <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7 col-md-offset-1">
                                            <div class="form-group">
                                                <div class="form-line">
                                                <select class="form-control"  name="day_name[]">
                                                    @if($doctorSched->day_name === 'Saturday')
                                                    <option selected value="Saturday">Saturday</option>
                                                    @else 
                                                    <option value="Saturday">Saturday</option>
                                                    @endif

                                                    @if($doctorSched->day_name === 'Sunday')
                                                    <option selected value="Sunday">Sunday</option>
                                                    @else 
                                                    <option value="Sunday">Sunday</option>
                                                    @endif

                                                    @if($doctorSched->day_name === 'Monday')
                                                    <option selected value="Monday">Monday</option>
                                                    @else 
                                                    <option value="Monday">Monday</option>
                                                    @endif

                                                    @if($doctorSched->day_name === 'Tuesday')
                                                    <option selected value="Tuesday">Tuesday</option>
                                                    @else 
                                                    <option value="Tuesday">Tuesday</option>
                                                    @endif

                                                    @if($doctorSched->day_name === 'Wednesday')
                                                    <option selected value="Wednesday">Wednesday</option>
                                                    @else 
                                                    <option value="Wednesday">Wednesday</option>
                                                    @endif

                                                    @if($doctorSched->day_name === 'Thursday')
                                                    <option selected value="Thursday">Thursday</option>
                                                    @else 
                                                    <option value="Thursday">Thursday</option>
                                                    @endif

                                                    @if($doctorSched->day_name === 'Friday')
                                                    <option selected value="Friday">Friday</option>
                                                    @else 
                                                    <option value="Friday">Friday</option>
                                                    @endif
                                                     </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                <input type="time" value="{{ $doctorSched->start_time }}" name="start_time[]" placeholder="Start Time" class="form-control" data-toggle="tooltip" data-placement="top" title="Start Time" required oninvalid="this.setCustomValidity('Please select start time')" oninput="this.setCustomValidity('')">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="time" value="{{ $doctorSched->end_time }}" id="endtime" class="form-control" placeholder="End Time" name="end_time[]" data-toggle="tooltip" data-placement="top" title="End Time" required oninvalid="this.setCustomValidity('Please select end time')"
    oninput="this.setCustomValidity('')">
                                                </div>
                                            </div>
                                        </div>
                                        <a class="remove_thiss btn btn-danger col-lg-1 col-md-1 col-sm-8 col-xs-7" onclick="deleteSchedule('{{ $doctorSched->id }}')">x</a>
                                        </div>
                                        <input type="hidden"  value="{{ $doctorSched->id }}"  name="schedule_id[]">
                                        @endforeach

                                        @else
                                        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7 col-md-offset-1">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <select class="form-control"  name="day_name[]">
                                                    <option value="Saturday">Saturday</option>
                                                    <option value="Sunday">Sunday</option>
                                                    <option value="Monday">Monday</option>
                                                    <option value="Tuesday">Tuesday</option>
                                                    <option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                     </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                <input type="time" name="start_time[]" placeholder="Start Time" class="form-control" data-toggle="tooltip" data-placement="top" title="Start Time" required oninvalid="this.setCustomValidity('Please select start time')"
    oninput="this.setCustomValidity('')">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="time" id="endtime" class="form-control" placeholder="End Time" name="end_time[]" value="" data-toggle="tooltip" data-placement="top" title="End Time" required oninvalid="this.setCustomValidity('Please select end time')"
    oninput="this.setCustomValidity('')">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" value=""  name="schedule_id[]">
                                        @endif
                                </div>
                                
                                    
                                            <input type="hidden" value="{{ Auth::user()->id }}" name="doc_id">

                                       
                                        <div class="col-lg-1 col-md-1 col-sm-8 col-xs-7 col-lg-offset-11 col-md-offset-11">
                                        <a class="btn btn-success" id="appends" name="appends">+</a>
                                    </div>
                                    

                                
                                <div class="row clearfix">
                                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                        <a href="{{route('dashboard')}}" style="text-decoration: none;">
                                                    <button type="button" class="btn btn-danger m-t-15 waves-effect">CANCEL</button>
                                                    </a>
                                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endif
                            <!-- degree -->
                            @if(auth()->check() &&
                                auth()
                                ->user()
                                ->hasRole('doctor'))
                                <div role="tabpanel" class="tab-pane fade" id="degree_with_icon_title">
                                    <form method="POST" action="{{ route('degree-update') }}" class="form-horizontal">
                                        @csrf
                                        @method('PUT')
                                         
                                        <div class="row clearfix">
                                            <div class="inc">
                                                @php if($doctor_info->educational_degrees) { @endphp
                                                @php $educational_degrees = explode("|",$doctor_info->educational_degrees);
                                                @endphp
                                                @foreach($educational_degrees as $education_info)
                                                    @php $degrre_value = explode(",",$education_info);
                                                    $department = $degrre_value[0];
                                                    $degree = $degrre_value[1];
                                                    $institute = $degrre_value[2];
                                                    @endphp
                                                    <div class="input-row">
                                                        @php if($department === 'Medicine' || $department === 'Surgery' ||
                                                        $department === 'Philosophy' || $department === 'Clinical Medicine' ||
                                                        $department === 'Medical Science'){ @endphp
                                                        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7 col-md-offset-1 test">
                                                            <div class="form-group">
                                                                <div class="form-line">

                                                                    <select class="form-control" name="department[]"
                                                                        onchange="otherDepartment(event)" required oninvalid="this.setCustomValidity('Please select a department')"
    oninput="this.setCustomValidity('')">
                                                                        <option value="@php echo $department; @endphp">@php echo
                                                                            $department; @endphp</option>
                                                                        <option value="">Select Department</option>
                                                                        @foreach($department_inf as $department_value)
                                                                        <option value="{{ $department_value->name }}">{{ $department_value->name }}</option>
                                                                        @endforeach
                                                                        <option value="Others_dept">Others</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <select class="form-control" id="select2" name="degree[]"
                                                                    onchange="otherDepartment(event)" required oninvalid="this.setCustomValidity('Please select a degree')"
    oninput="this.setCustomValidity('')">
                                                                        <option value="@php echo $degree; @endphp">@php echo
                                                                            $degree; @endphp</option>
                                                                        <option value="">Select Degree</option>
                                                                        <optgroup label="Bachelor of Medicine">
                                                                            <option value="MBBS">Bachelor of Medicine(MBBS)
                                                                            </option>
                                                                            <option value="BMBS">Bachelor of Medicine(BMBS)
                                                                            </option>
                                                                            <option value="MBChB">Bachelor of Medicine(MBChB)
                                                                            </option>
                                                                            <option value="MBBCh">Bachelor of Medicine(MBBCh)
                                                                            </option>
                                                                        </optgroup>
                                                                        <optgroup label="Bachelor of Surgery">
                                                                            <option value="MBBS">Bachelor of Surgery(MBBS)
                                                                            </option>
                                                                            <option value="BMBS">Bachelor of Surgery(BMBS)
                                                                            </option>
                                                                            <option value="MBChB">Bachelor of Surgery(MBChB)
                                                                            </option>
                                                                            <option value="MBBCh">Bachelor of Surgery(MBBCh)
                                                                            </option>
                                                                        </optgroup>
                                                                        <optgroup label="Doctor of Medicine">
                                                                            <option value="MD">Doctor of Medicine(MD)</option>
                                                                            <option value="Dr.MuD">Doctor of Medicine(Dr.MuD)
                                                                            </option>
                                                                            <option value="Dr.Med">Doctor of Medicine(Dr.Med)
                                                                            </option>
                                                                        </optgroup>
                                                                        <optgroup label="Doctor of Osteopathic Medicine">
                                                                            <option value="DO">Doctor of Osteopathic
                                                                                Medicine(DO)</option>
                                                                        </optgroup>
                                                                        <optgroup label="Doctor of Medicine by research">
                                                                            <option value="MD(Res)">Doctor of Medicine by
                                                                                research(MD(Res))</option>
                                                                            <option value="DM">Doctor of Medicine by
                                                                                research(DM)</option>
                                                                        </optgroup>
                                                                        <optgroup label="Doctor of Philosophy">
                                                                            <option value="PhD">Doctor of Philosophy(PhD)
                                                                            </option>
                                                                            <option value="DPhil">Doctor of Philosophy(DPhil)
                                                                            </option>
                                                                        </optgroup>
                                                                        <optgroup label="Master of Clinical Medicine">
                                                                            <option value="MCM">Master of Clinical Medicine
                                                                                (MCM)</option>
                                                                        </optgroup>
                                                                        <optgroup label="Master of Medical Science">
                                                                            <option value="MMSc">Master of Medical Science
                                                                                (MMSc)</option>
                                                                            <option value="MMedSc">Master of Medical Science
                                                                                (MMedSc)</option>
                                                                        </optgroup>
                                                                        <optgroup label="Master of Medicine">
                                                                            <option value="MM">Master of Medicine (MM)</option>
                                                                            <option value="MMed">Master of Medicine (MMed)
                                                                            </option>
                                                                        </optgroup>
                                                                        <optgroup label="Master of Philosophy">
                                                                            <option value="MPhil">Master of Philosophy (MPhil)
                                                                            </option>
                                                                        </optgroup>
                                                                        <optgroup label="Master of Surgery">
                                                                            <option value="MS">Master of Surgery (MS)</option>
                                                                            <option value="MSurg">Master of Surgery (MSurg)
                                                                            </option>
                                                                            <option value="MChir">Master of Surgery (MChir)
                                                                            </option>
                                                                            <option value="MCh">Master of Surgery (MCh)</option>
                                                                            <option value="ChM">Master of Surgery (ChM)</option>
                                                                            <option value="CM">Master of Surgery (CM)</option>
                                                                        </optgroup>
                                                                        <optgroup label="Master of Science">
                                                                            <option value="MSc">Master of Science in Medicine
                                                                                (MSc)</option>
                                                                            <option value="MSc">Master of Science in Surgery
                                                                                (MSc)</option>
                                                                        </optgroup>
                                                                        <optgroup label="Doctor of Clinical Medicine">
                                                                            <option value="DCM">Doctor of Clinical Medicine
                                                                                (DCM)</option>
                                                                        </optgroup>
                                                                        <optgroup label="Doctor of Clinical Surgery">
                                                                            <option value="DClinSurg">Doctor of Clinical Surgery
                                                                                (DClinSurg)</option>
                                                                        </optgroup>
                                                                        <optgroup label="Doctor of Medical Science">
                                                                            <option value="DMSc">Doctor of Medical Science
                                                                                (DMSc)</option>
                                                                            <option value="DMedSc">Doctor of Medical Science
                                                                                (DMedSc)</option>
                                                                        </optgroup>
                                                                        <optgroup label="Doctor of Surgery">
                                                                            <option value="DS">Doctor of Surgery (DS)</option>
                                                                            <option value="DSurg">Doctor of Surgery (DSurg)
                                                                            </option>
                                                                        </optgroup>
                                                                        <option value="Others_dept">Others
                                                                        <option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php } else { @endphp

                                                        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7 col-md-offset-1 test">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" name="department[]"
                                                                        value="@php echo $department; @endphp"
                                                                        placeholder="Department Name" class="form-control" required oninvalid="this.setCustomValidity('Enter department name')"
    oninput="this.setCustomValidity('')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" id="endtime"
                                                                        value="@php echo $degree; @endphp" class="form-control"
                                                                        placeholder="Degree Name" name="degree[]" value="" required oninvalid="this.setCustomValidity('Enter degree name')"
    oninput="this.setCustomValidity('')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php } @endphp
                                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" id="institute" class="form-control"
                                                                        placeholder="Institute Name" name="institute[]"
                                                                        value="@php echo $institute; @endphp" required oninvalid="this.setCustomValidity('Enter institute name')"
    oninput="this.setCustomValidity('')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a class="remove_thiss btn btn-danger col-lg-1 col-md-1 col-sm-8 col-xs-7" id="appends" name="appends">x</a>
                                                    </div>
                                                @endforeach
                                                @php } else { @endphp
                                                <div class="input-row">
                                                <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7 col-md-offset-1">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select class="form-control" name="department[]" onchange="otherDepartment(event)" required oninvalid="this.setCustomValidity('Please select a department')"
    oninput="this.setCustomValidity('')">
                                                                <option value="">Select Department</option>
                                                                @foreach($department_inf as $department_value)
                                                                        <option value="{{ $department_value->name }}">{{ $department_value->name }}</option>
                                                                        @endforeach
                                                                <option value="Others_dept">Others</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <select class="form-control" id="select2" name="degree[]" onchange="otherDepartment(event)" required oninvalid="this.setCustomValidity('Please select a degree')"
    oninput="this.setCustomValidity('')">
                                                                <option value="">Select Degree</option>
                                                                <optgroup label="Bachelor of Medicine">
                                                                    <option value="MBBS">Bachelor of Medicine(MBBS)</option>
                                                                    <option value="BMBS">Bachelor of Medicine(BMBS)</option>
                                                                    <option value="MBChB">Bachelor of Medicine(MBChB)</option>
                                                                    <option value="MBBCh">Bachelor of Medicine(MBBCh)</option>
                                                                </optgroup>
                                                                <optgroup label="Bachelor of Surgery">
                                                                    <option value="MBBS">Bachelor of Surgery(MBBS)</option>
                                                                    <option value="BMBS">Bachelor of Surgery(BMBS)</option>
                                                                    <option value="MBChB">Bachelor of Surgery(MBChB)</option>
                                                                    <option value="MBBCh">Bachelor of Surgery(MBBCh)</option>
                                                                </optgroup>
                                                                <optgroup label="Doctor of Medicine">
                                                                    <option value="MD">Doctor of Medicine(MD)</option>
                                                                    <option value="Dr.MuD">Doctor of Medicine(Dr.MuD)</option>
                                                                    <option value="Dr.Med">Doctor of Medicine(Dr.Med)</option>
                                                                </optgroup>
                                                                <optgroup label="Doctor of Osteopathic Medicine">
                                                                    <option value="DO">Doctor of Medicine(DO)</option>
                                                                </optgroup>
                                                                <optgroup label="Doctor of Medicine by research">
                                                                    <option value="MD(Res)">Doctor of Medicine by
                                                                        research(MD(Res))</option>
                                                                    <option value="DM">Doctor of Medicine by research(DM)
                                                                    </option>
                                                                </optgroup>
                                                                <optgroup label="Doctor of Philosophy">
                                                                    <option value="PhD">Doctor of Philosophy(PhD)</option>
                                                                    <option value="DPhil">Doctor of Philosophy(DPhil)</option>
                                                                </optgroup>
                                                                <optgroup label="Master of Clinical Medicine">
                                                                    <option value="MCM">Master of Clinical Medicine (MCM)
                                                                    </option>
                                                                </optgroup>
                                                                <optgroup label="Master of Medical Science">
                                                                    <option value="MMSc">Master of Medical Science (MMSc)
                                                                    </option>
                                                                    <option value="MMedSc">Master of Medical Science (MMedSc)
                                                                    </option>
                                                                </optgroup>
                                                                <optgroup label="Master of Medicine">
                                                                    <option value="MM">Master of Medicine (MM)</option>
                                                                    <option value="MMed">Master of Medicine (MMed)</option>
                                                                </optgroup>
                                                                <optgroup label="Master of Philosophy">
                                                                    <option value="MPhil">Master of Philosophy (MPhil)</option>
                                                                </optgroup>
                                                                <optgroup label="Master of Surgery">
                                                                    <option value="MS">Master of Surgery (MS)</option>
                                                                    <option value="MSurg">Master of Surgery (MSurg)</option>
                                                                    <option value="MChir">Master of Surgery (MChir)</option>
                                                                    <option value="MCh">Master of Surgery (MCh)</option>
                                                                    <option value="ChM">Master of Surgery (ChM)</option>
                                                                    <option value="CM">Master of Surgery (CM)</option>
                                                                </optgroup>
                                                                <optgroup label="Master of Science">
                                                                    <option value="MSc">Master of Science in Medicine (MSc)
                                                                    </option>
                                                                    <option value="MSc">Master of Science in Surgery (MSc)
                                                                    </option>
                                                                </optgroup>
                                                                <optgroup label="Doctor of Clinical Medicine">
                                                                    <option value="DCM">Doctor of Clinical Medicine (DCM)
                                                                    </option>
                                                                </optgroup>
                                                                <optgroup label="Doctor of Clinical Surgery">
                                                                    <option value="DClinSurg">Doctor of Clinical Surgery
                                                                        (DClinSurg)</option>
                                                                </optgroup>
                                                                <optgroup label="Doctor of Medical Science">
                                                                    <option value="DMSc">Doctor of Medical Science (DMSc)
                                                                    </option>
                                                                    <option value="DMedSc">Doctor of Medical Science (DMedSc)
                                                                    </option>
                                                                </optgroup>
                                                                <optgroup label="Doctor of Surgery">
                                                                    <option value="DS">Doctor of Surgery (DS)</option>
                                                                    <option value="DSurg">Doctor of Surgery (DSurg)</option>
                                                                </optgroup>
                                                                <option value="Others_dept">Others
                                                                <option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-8 col-xs-7">
                                                    <div class="form-group">
                                                        <div class="form-line">
                                                            <input type="text" id="institute" class="form-control"
                                                                placeholder="Institute Name" name="institute[]" value="" required oninvalid="this.setCustomValidity('Enter institute name')"
    oninput="this.setCustomValidity('')">
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                @php } @endphp
                                            </div>
                                        </div>


                                        <div class="col-lg-1 col-md-1 col-sm-8 col-xs-7 col-lg-offset-11 col-md-offset-11">
                                            <a class="btn btn-success" id="append" name="append">+</a>
                                        </div>



                                        <div class="row clearfix">
                                            <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                                <a href="{{ route('dashboard') }}" style="text-decoration: none;">
                                                    <button type="button"
                                                        class="btn btn-danger m-t-15 waves-effect">CANCEL</button>
                                                </a>
                                                <button type="submit"
                                                    class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- others -->
                                <div role="tabpanel" class="tab-pane fade" id="others_with_icon_title">
                                    <form method="POST" action="{{ route('doctor-personal-info-update') }}"
                                        class="form-horizontal">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="registration_no">Registration No </label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="registration_no" class="form-control"
                                                            placeholder="Enter your registration no" name="registration_no"
                                                            value="{{ $doctor_info->registration_no }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="licence_no">Licence No </label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="licence_no" class="form-control"
                                                            placeholder="Enter your licence no" name="licence_no"
                                                            value="{{ $doctor_info->licence_no }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="ptr_no">PTR No </label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="ptr_no" class="form-control"
                                                            placeholder="Confirm your ptr no" name="ptr_no"
                                                            value="{{ $doctor_info->ptr_no }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="s2_no">S2 No </label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" id="s2_no" class="form-control"
                                                            placeholder="Enter your s2 no" name="s2_no"
                                                            value="{{ $doctor_info->s2_no }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="visit_fee">Visit Fee </label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="number" id="visit_fee" class="form-control"
                                                            placeholder="Enter your visit fee" name="visit_fee"
                                                            value="{{ $doctor_info->visit_fee }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                                <a href="{{ route('dashboard') }}" style="text-decoration: none;">
                                                    <button type="button"
                                                        class="btn btn-danger m-t-15 waves-effect">CANCEL</button>
                                                </a>
                                                <button type="submit"
                                                    class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Tabs With Icon Title -->
    </div>

@endsection

@push('js')

    <script>
    function deleteSchedule(scdid)
    {
        cnf = confirm('Are You Sure to Delete');
        if(cnf == true)
        {
            var baseUrl = window.location.href;
            var targetUrl = baseUrl + '/delete_schedule/' + scdid;
            // alert(targetUrl);
            $.get(targetUrl, function (data) {
                    // $('#slotlist').html(data);
                });
        }
        else
        {
            location.reload();
        }
        
    }
        function otherDepartment(e) {
            console.log(e);
            if (e.target.value == "Others_dept") {
                $(".input-row:nth-last-child(1)").remove();
                $(".inc").append('<div class="input-row"><div class="col-md-offset-1">\
                                                <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7">\
                                                    <div class="form-group">\
                                                        <div class="form-line">\
                                                        <input type="text" name="department[]" placeholder="Department Name" class="form-control" required >\
                                                        </div>\
                                                    </div>\
                                                </div>\
                                                <div class="col-lg-4 col-md-4 col-sm-8 col-xs-7">\
                                                    <div class="form-group">\
                                                        <div class="form-line">\
                                                        <input type="text" id="endtime" class="form-control" placeholder="Degree Name" name="degree[]" value="" required>\
                                                        </div>\
                                                    </div>\
                                                </div>\
                                                <div class="col-lg-4 col-md-4 col-sm-8 col-xs-7">\
                                                    <div class="form-group">\
                                                        <div class="form-line">\
                                                            <input type="text" id="institute" class="form-control" placeholder="Institute Name" name="institute[]" value="" required>\
                                                        </div>\
                                                    </div>\
                                                </div>\
                                                    <a class="remove_thiss btn btn-danger col-lg-1 col-md-1 col-sm-8 col-xs-7" id="appends" name="appends">x</a>\
                            <br>\
                            <br>\
                        </div></div>');
            }
        }

        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });


        jQuery(document).ready(function() {
            $("#append").click(function(e) {
                e.preventDefault();
                $(".inc").append('<div class="input-row"><div  class="col-lg-3 col-md-3 col-sm-8 col-xs-7 col-md-offset-1 col-lg-offset-1">\
                                                    <div class="form-group">\
                                                        <div class="form-line">\
                                                            <select class="form-control"   name="department[]" onchange="otherDepartment(event)" required >\
                                                            <option value="">Select Department</option>\
                                                            @foreach($department_inf as $department_value)\
                                                                <option value="{{ $department_value->name }}">{{ $department_value->name }}</option>\
                                                                @endforeach\
                                                                <option value="Others_dept">Others</option>\
                                                            </select>\
                                                        </div>\
                                                    </div>\
                                                </div>\
                                                <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7">\
                                                    <div class="form-group">\
                                                        <div class="form-line">\
                                                        <select class="form-control"  name="degree[]" onchange="otherDepartment(event)" required>\
                                                        <option value="">Select Degree</option>\
                                                        <optgroup label="Bachelor of Medicine">\
                                                            <option value="MBBS">Bachelor of Medicine(MBBS)</option>\
                                                            <option value="BMBS">Bachelor of Medicine(BMBS)</option>\
                                                            <option value="MBChB">Bachelor of Medicine(MBChB)</option>\
                                                            <option value="MBBCh">Bachelor of Medicine(MBBCh)</option>\
                                                            </optgroup>\
                                                            <optgroup label="Bachelor of Surgery">\
                                                            <option value="MBBS">Bachelor of Surgery(MBBS)</option>\
                                                            <option value="BMBS">Bachelor of Surgery(BMBS)</option>\
                                                            <option value="MBChB">Bachelor of Surgery(MBChB)</option>\
                                                            <option value="MBBCh">Bachelor of Surgery(MBBCh)</option>\
                                                            </optgroup>\
                                                            <optgroup label="Doctor of Medicine">\
                                                            <option value="MD">Doctor of Medicine(MD)</option>\
                                                            <option value="Dr.MuD">Doctor of Medicine(Dr.MuD)</option>\
                                                            <option value="Dr.Med">Doctor of Medicine(Dr.Med)</option>\
                                                            </optgroup>\
                                                            <optgroup label="Doctor of Osteopathic Medicine">\
                                                            <option value="DO">Doctor of Medicine(DO)</option>\
                                                            </optgroup>\
                                                            <optgroup label="Doctor of Medicine by research">\
                                                            <option value="MD(Res)">Doctor of Medicine by research(MD(Res))</option>\
                                                            <option value="DM">Doctor of Medicine by research(DM)</option>\
                                                            </optgroup>\
                                                            <optgroup label="Doctor of Philosophy">\
                                                            <option value="PhD">Doctor of Philosophy(PhD)</option>\
                                                            <option value="DPhil">Doctor of Philosophy(DPhil)</option>\
                                                            </optgroup>\
                                                            <optgroup label="Master of Clinical Medicine">\
                                                            <option value="MCM">Master of Clinical Medicine (MCM)</option>\
                                                            </optgroup>\
                                                            <optgroup label="Master of Medical Science">\
                                                            <option value="MMSc">Master of Medical Science (MMSc)</option>\
                                                            <option value="MMedSc">Master of Medical Science (MMedSc)</option>\
                                                            </optgroup>\
                                                            <optgroup label="Master of Medicine">\
                                                            <option value="MM">Master of Medicine (MM)</option>\
                                                            <option value="MMed">Master of Medicine (MMed)</option>\
                                                            </optgroup>\
                                                            <optgroup label="Master of Philosophy">\
                                                            <option value="MPhil">Master of Philosophy (MPhil)</option>\
                                                            </optgroup>\
                                                            <optgroup label="Master of Surgery">\
                                                            <option value="MS">Master of Surgery (MS)</option>\
                                                            <option value="MSurg">Master of Surgery (MSurg)</option>\
                                                            <option value="MChir">Master of Surgery (MChir)</option>\
                                                            <option value="MCh">Master of Surgery (MCh)</option>\
                                                            <option value="ChM">Master of Surgery (ChM)</option>\
                                                            <option value="CM">Master of Surgery (CM)</option>\
                                                            </optgroup>\
                                                            <optgroup label="Master of Science">\
                                                            <option value="MSc">Master of Science in Medicine (MSc)</option>\
                                                            <option value="MSc">Master of Science in Surgery (MSc)</option>\
                                                            </optgroup>\
                                                            <optgroup label="Doctor of Clinical Medicine">\
                                                            <option value="DCM">Doctor of Clinical Medicine (DCM)</option>\
                                                            </optgroup>\
                                                            <optgroup label="Doctor of Clinical Surgery">\
                                                            <option value="DClinSurg">Doctor of Clinical Surgery (DClinSurg)</option>\
                                                            </optgroup>\
                                                            <optgroup label="Doctor of Medical Science">\
                                                            <option value="DMSc">Doctor of Medical Science (DMSc)</option>\
                                                            <option value="DMedSc">Doctor of Medical Science (DMedSc)</option>\
                                                            </optgroup>\
                                                            <optgroup label="Doctor of Surgery">\
                                                            <option value="DS">Doctor of Surgery (DS)</option>\
                                                            <option value="DSurg">Doctor of Surgery (DSurg)</option>\
                                                            </optgroup>\
                                                            <option value="Others_dept">Others<option>\
                                                            </select>\
                                                        </div>\
                                                    </div>\
                                                </div>\
                                                <div class="col-lg-4 col-md-4 col-sm-8 col-xs-7">\
                                                    <div class="form-group">\
                                                        <div class="form-line">\
                                                            <input type="text" id="institute" class="form-control" placeholder="Institute Name" name="institute[]" value="" required>\
                                                        </div>\
                                                    </div>\
                                                </div>\
                                                    <a class="remove_this btn btn-danger col-lg-1 col-md-1 col-sm-8 col-xs-7" id="append" name="append">x</a>\
                            <br>\
                            <br>\
                        </div>');
                return false;
            });

            jQuery(document).on('click', '.remove_this', function() {
                // alert($('#ap_1').val());
                jQuery(this).parent().remove();
                return false;
            });
            $("input[type=submit]").click(function(e) {
                e.preventDefault();
                $(this).next("[name=textbox]")
                    .val(
                        $.map($(".inc :text"), function(el) {
                            return el.value
                        }).join(",\n")
                    );
            })
        });

        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            localStorage.setItem('activeTabSetting', $(e.target).attr('href'));
        });
        var activeTabSetting = localStorage.getItem('activeTabSetting');
        if (activeTabSetting) {           
            $('#setting_tab a[href="' + activeTabSetting + '"]').tab('show');
        }


        var i = 0;
        jQuery(document).ready( function () {
            
            $("#appends").click( function(e) {
            e.preventDefault();
            $(".incs").append('<div class="day-row"><div class="col-lg-3 col-md-3 col-sm-8 col-xs-7 col-md-offset-1 col-lg-offset-1">\
                                            <div class="form-group">\
                                                <div class="form-line">\
                                                <select class="form-control"  name="day_name[]">\
                                                    <option value="Saturday">Saturday</option>\
                                                    <option value="Sunday">Sunday</option>\
                                                    <option value="Monday">Monday</option>\
                                                    <option value="Tuesday">Tuesday</option>\
                                                    <option value="Wednesday">Wednesday</option>\
                                                    <option value="Thursday">Thursday</option>\
                                                    <option value="Friday">Friday</option>\
                                                     </select>\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7">\
                                            <div class="form-group">\
                                                <div class="form-line">\
                                                <input type="time" id="startTime'+i+'" name="start_time[]" placeholder="Start Time" class="form-control" onchange="timeCheck('+i+')" onkeyup="timeCheck('+i+')" data-toggle="tooltip" data-placement="top" title="Start Time" required>\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-7">\
                                            <div class="form-group">\
                                                <div class="form-line">\
                                                <input type="time" id="end_time'+i+'" class="form-control" placeholder="End Time" name="end_time[]" value="" data-toggle="tooltip" data-placement="top" title="End Time" required>\
                                                <input type="hidden" value=""  name="schedule_id[]">\
                                                </div>\
                                            </div>\
                                        </div>\
                                            <a class="remove_thiss btn btn-danger col-lg-1 col-md-1 col-sm-8 col-xs-7" id="appends" name="appends">x</a>\
                    <br>\
                    <br>\
                </div>');
             i++;
            return false;


            function timeCheck(i)
                {
                    // alert(5);
                    var start_time = $('#start_time'+i).val();


                    minutes = 30; 
                    var end_time = moment(start_time, "hh:mm")
                    .add(minutes, 'minutes')
                    .format('HH:mm');
                    
                    $('#end_time'+i).val(end_time);
                } 
            });
            
           

            jQuery(document).on('click', '.remove_thiss', function() {
                jQuery(this).parent().remove();
                return false;
                });
                
            $("input[type=submit]").click(function(e) {
            e.preventDefault();
            $(this).next("[name=textbox]")
            .val(
                $.map($(".incs :text"), function(el) {
                return el.value
                }).join(",\n")
            );
            })
    });


    </script>

@endpush
