@extends('layouts.backend.app')

@section('title','Crete Project')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<!-- <link href="{{asset('public/assets/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" /> -->
@endpush

@section('content')

<div class="container-fluid">
	<!-- Tabs With Icon Title -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Create Project
                    </h2>                                      
                </div>
                <div class="body">
                <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="body">
                                            <form method="POST" action="{{ route('projects.store') }}" class="form-horizontal" enctype="multipart/form-data">
                                            	@csrf
                                            
                                            	<div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                        <label for="project_name">Project Name </label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input type="text" id="project_name" class="form-control" placeholder="Type project name" name="project_name" value="" required oninvalid="this.setCustomValidity('Enter project name')"
    oninput="this.setCustomValidity('')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                        <label for="project_code">Project Code </label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input type="text" id="project_code" class="form-control" placeholder="Type project code" name="project_code" value="" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                        <label for="project_client">Client Name </label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <input type="text" id="project_client" class="form-control" placeholder="Type client name of project" name="project_client" value="" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                               
                                               
                                               
                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                        <label for="project_lead_id">Project Lead </label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                        <div class="form-group">
                                                            <select class="form-control project_lead" name="project_lead_id" id="project_lead_id" required>
                                                            <option value="">Select Team Lead</option>
                                                            @foreach($users as $user)                                                                
                                                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                                            @endforeach                                                               
                                                            </select>
                                                        </div>
                                                    </div>
                                                   
                                                </div>

                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                        <label for="support_engg_id">Support Engg </label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                        <div class="form-group">
                                                            <select class="form-control support_engg" name="support_engg_id[]" id="support_engg_id" multiple="multiple" >
                                                            <!-- <option value="">Select Support Engg</option> -->
                                                            @foreach($users as $user)                                                                
                                                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                                            @endforeach                                                               
                                                            </select>
                                                        </div>
                                                    </div>
                                                   
                                                </div>

                                                <div class="row clearfix">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                        <label for="about">About Project</label>
                                                    </div>
                                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                        <div class="form-group">
                                                            <div class="form-line">
                                                                <textarea rows="5" name="project_summary" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                                
                                                <div class="row clearfix">
                                                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>                                                      
                                                    </div>                                                    
                                                </div>
                                            </form>
                                            
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.support_engg').select2({
        placeholder: "Select Support Engineer",
        multiple: true,        
        });
    $('.project_lead').select2({
        placeholder: {
        id: '-1', // the value of the option
        text: 'Select Team Lead'
        }     
        
    });
});
</script>
@endpush