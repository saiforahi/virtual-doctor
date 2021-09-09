@extends('layouts.backend.app')

@section('title','Create Patients')

@push('css')
<link href="{{asset('public/assets/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
@endpush

@section('content')

<div class="container-fluid">
	<!-- Tabs With Icon Title -->

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Create New Patients
                    </h2>
                </div>
                <div class="body">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="body">
                                <form method="POST" action="{{ route('users.store') }}" class="form-horizontal" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="name">Patient Name </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="name" class="form-control" placeholder="Enter name" name="name" value="" required oninvalid="this.setCustomValidity('Enter patient name')"
    oninput="this.setCustomValidity('')">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="email_address">Email </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="email_address" class="form-control" placeholder="Enter email address" name="email" value="" required oninvalid="this.setCustomValidity('Enter email address')"
    oninput="this.setCustomValidity('')">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="phone">Phone </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="phone" class="form-control" placeholder="Enter your phone number example: +8801xxxxxxxxx" name="phone" value="" required oninvalid="this.setCustomValidity('Enter mobile number')"
    oninput="this.setCustomValidity('')">
                                                </div>
                                                <span class="text" style="color:red; font-size: small;font-weight: bold">Use mobile number with country code. Example: for BANGLADESH use +8801xxxxxxxxx </span>
                                            </div>
                                        </div>
                                    </div>
                                    @if(auth()->check() && auth()->user()->hasRole('super-admin'))
                                    {{-- <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="password">Password </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="password" id="password" class="form-control" placeholder="Enter Password" name="password" value="" required oninvalid="this.setCustomValidity('Enter password')"
    oninput="this.setCustomValidity('')">
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
                                                    <input type="password" id="confirm_password" class="form-control" placeholder="Enter Confirm Password" name="password_confirmation" value="" required oninvalid="this.setCustomValidity('Enter confirm password')"
    oninput="this.setCustomValidity('')">
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    @endif
                                    <!-- <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="name">Profile Image </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                    <input type="file" name="image">
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="gender">Gender </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <select class="form-control show-tick" name="gender" id="gender" required oninvalid="this.setCustomValidity('Please select gender')"
    oninput="this.setCustomValidity('')">
                                                    <option value="">Select</option>
                                                    <option value="Male" >Male</option>
                                                    <option value="Female" >Female</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="age">Age </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="number" id="age" class="form-control" placeholder="Enter Age" name="age" value="" required oninvalid="this.setCustomValidity('Enter age')"
    oninput="this.setCustomValidity('')">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="role_id">Role </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <select class="form-control show-tick" name="role_id" id="role_id" required>
                                                    <option value="">Select Role</option>
                                                    @if(auth()->check() && auth()->user()->hasRole('super-admin'))
                                                        @foreach($roles as $role)
                                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                                        @endforeach
                                                    @else
                                                    <option value="{{$roles->id}}" selected readonly>{{$roles->name}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                            <a href="{{route('dashboard')}}" style="text-decoration: none;">
                                        <button type="button" class="btn btn-danger m-t-15 waves-effect">CANCEL</button>
                                        </a>
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect saveInfo">ADD</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Tabs With Icon Title -->
</div>

@endsection

@push('js')


@endpush
