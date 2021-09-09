@extends('layouts.backend.app')

@section('title','Create Clinic')

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
                        Update Clinic
                    </h2>                    
                </div>
                <div class="body">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="body">
                                <form method="POST" action="{{ route('clinic.update',$clinic->id) }}" class="form-horizontal" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="name">Clinic Name </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="name" class="form-control" placeholder="Type name" name="name" value="{{ $clinic->name }}" required oninvalid="this.setCustomValidity('Enter clinic name')"
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
                                                    <input type="text" id="phone" class="form-control" placeholder="Type your phone number" name="phone" value="{{ $clinic->phone }}" required>
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
                                                    <input type="email" id="email_address" class="form-control" placeholder="Type email address" name="email" value="{{ $clinic->email }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="password">Address </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <textarea  class="form-control" placeholder="Type Address" name="address"  required>{{ $clinic->address }}</textarea> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="name">Logo </label>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail img-holder">
                                                        <img id="blah"
                                                            src=" @if(is_null($clinic->image)) {{ url('storage/app/public/default.png') }} @else {{ url('storage/app/public/clinics/' . $clinic->image) }} @endif "
                                                            alt="clinics image" height="64" width="64">

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
                                            <label for="name">Favicon </label>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail img-holder">
                                                        <img id="blah"
                                                            src=" @if(is_null($clinic->favicon)) {{ url('storage/app/public/default.png') }} @else {{ url('storage/app/public/clinics/favicon' . $clinic->favicon) }} @endif "
                                                            alt="favicon" height="64" width="64">

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
                                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                             <a href="{{route('clinic.index')}}" style="text-decoration: none;">
                                                    <button type="button" class="btn btn-danger m-t-15 waves-effect">CANCEL</button>
                                                    </a>
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update</button>
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

<script>
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
</script>
@endpush