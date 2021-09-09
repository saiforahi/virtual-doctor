@extends('layouts.backend.app')

@section('title','Edit Slot')

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
                        Edit Schedule
                    </h2>                    
                </div>
                <div class="body">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="body">
                                <form method="POST" action="{{ route('slot.update',$slot->id) }}" class="form-horizontal" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="name">Start Time </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="Time" id="start_time" class="form-control" onchange="timeCheck()"  name="start_time" value="{{ $slot->start_time }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="name">End Time </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="Time" id="end_time" class="form-control" name="end_time" value="{{ $slot->end_time }}" onchange="lastTimeCheck()" onkeyup="lastTimeCheck()" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                            <a href="{{route('slot.index')}}" style="text-decoration: none;">
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
<script type="text/javascript">

    function timeCheck()
    {
        var start_time = $('#start_time').val();

        // alert(start_time);
         minutes = 30; 
        var end_time = moment(start_time, "hh:mm")
        .add(minutes, 'minutes')
        .format('HH:mm');
        
        $('#end_time').val(end_time);
    } 


    function lastTimeCheck()
    {
        var end_time = $('#end_time').val();

        var start_time = $('#start_time').val();

        minutes = 30; 
        var new_start_time = moment(start_time, "hh:mm")
        .add(minutes, 'minutes')
        .format('HH:mm');


        minutes = 60; 
        var new_end_time = moment(start_time, "hh:mm")
        .add(minutes, 'minutes')
        .format('HH:mm');

        if(new_start_time > end_time || start_time == end_time)
        {
            $('#end_time').val(new_end_time);
        }

        var  mins = moment.utc(moment(end_time, "HH:mm:ss").diff(moment(start_time, "HH:mm:ss"))).format("HH:mm");
        var fiftemm = moment('00:15', "HH:mm").format('HH:mm');
        // alert(mins);
        if (mins < fiftemm  || start_time == end_time) {
            $('#end_time').val(new_start_time);
        }

    }


    
</script>

@endpush