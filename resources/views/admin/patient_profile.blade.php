@extends('layouts.backend.app')

@section('title','Patient Profile')

@push('css')
<link href="{{asset('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}"
    rel="stylesheet">
<style type="text/css">
    .img-holder {
        position: relative;
    }

    table,
    th {
        font-size: small;
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
                        PATIENT'S PROFILE
                    </h2>

                </div>
                <div class="body">
                <a class="btn btn-sm btn-danger" href="{{  route('dashboard') }} ">
                    Back</a>
                     <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist" id="myTab">
                                <li role="presentation">
                                    <a href="#profile_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">face</i>PROFILE
                                    </a>
                                </li>
                                <li role="presentation" class="active">
                                    <a href="#settings_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">history</i>APPOINTMENT HISTORY
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#documents_with_icon_title" data-toggle="tab">
                                        <i class="material-icons">history</i>Uploaded Documents
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade" id="profile_with_icon_title">
                                    <!-- Horizontal Layout -->
                                    <div class="row clearfix">

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="body">
                                                <form method="POST" class="form-responsive">

                                                    <div class="row clearfix">
                                                        <div
                                                            class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="name">Patient Name </label>
                                                        </div>
                                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $user->name }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div
                                                            class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                            <label>Email Address</label>
                                                        </div>
                                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input readonly="" class="form-control"
                                                                        value="{{ $user->email }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div
                                                            class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="name">Profile Image </label>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="fileinput-new thumbnail img-holder">
                                                                    <img id="blah"
                                                                        src=" @if( is_null($user->image)) {{ url('storage/app/public/default.png') }} @else {{ url('storage/app/public/profile/'.$user->image) }} @endif "
                                                                        alt="profile image">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row clearfix">
                                                        <div
                                                            class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="phone">Phone</label>
                                                        </div>
                                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input readonly="" type="text" class="form-control"
                                                                        name="phone" value="{{ $user->phone }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row clearfix">
                                                        <div
                                                            class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="phone">Gender</label>
                                                        </div>
                                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input readonly="" type="text" class="form-control"
                                                                        name="phone" value="{{ $user->gender }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- #END# Horizontal Layout -->
                                </div>
                                <div role="tabpanel" class="tab-pane fade in active" id="settings_with_icon_title">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-striped table-hover dataTable js-exportable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>VisitDate</th>
                                                    <th>Symptomps</th>
                                                    <th>Diagonosis</th>
                                                    <th>CC</th>
                                                    <th>Investigations</th>
                                                    <th>MedicinePrescribed</th>
                                                    <th>Instructions</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($appointment_history as $key=>$data)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td><strong
                                                            style="font-weight:bold">{{ $data->visit_date }}</strong>
                                                        <br><strong
                                                            style="color:blue">{{ date('h:i:s A', strtotime($data->slots->start_time)) }}
                                                            -
                                                            {{ date('h:i:s A', strtotime($data->slots->end_time)) }}</strong>
                                                    </td>
                                                    <td>{{ $data->patient_symptoms }}</td>
                                                    <td>{{ $data->diagonosis }}</td>
                                                    <td>{{ $data->cc }}</td>
                                                    <td>{{ $data->investigation }}</td>
                                                    <td>{{ $data->prescribe_medicines }}</td>
                                                    <td>{{ $data->instructions }}</td>

                                                    {{-- <td>
                                                    <a href="{{ route('prescription_download',$data->id)}}" class="btn
                                                    btn-info waves-effect" target="_blank">
                                                        <i class="material-icons">file_download</i>
                                                    </a>
                                                    </td> --}}
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="documents_with_icon_title">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-bordered table-striped table-hover dataTable js-exportable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>File Name</th>
                                                    <th>Download</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($patient_file as $key=>$data)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td> 
                                                    <td>{{ $data->title }}</td>
                                                    <td>
                                                    <a href="{{ route('downloadfile',$data->id)}}" class="btn
                                                    btn-info waves-effect" target="_blank">
                                                        <i class="material-icons">file_download</i>
                                                    </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
<script src="{{ asset('public/assets/backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
<script src="{{ asset('public/assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}">
</script>
<script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}">
</script>
<script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}">
</script>
<script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
<script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
<script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
<script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}">
</script>
<script src="{{ asset('public/assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}">
</script>
<script src="{{ asset('public/assets/backend/js/pages/tables/jquery-datatable.js')}}"></script>

<script>
    $(document).ready(function () {
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            localStorage.setItem('activeTab1', $(e.target).attr('href'));
        });
        var activeTab1 = localStorage.getItem('activeTab1');
        if (activeTab1) {
            $('#myTab a[href="' + activeTab1 + '"]').tab('show');
        }
    });
</script>

@endpush