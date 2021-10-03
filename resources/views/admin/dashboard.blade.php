@extends('layouts.backend.app')
@if (auth()->check() &&
    auth()->user()->hasRole('admin'))
    @section('title', 'ADMIN DASHBOARD')
@elseif(auth()->check() && auth()->user()->hasRole('moderator'))
    @section('title', 'MODERATOR DASHBOARD')
@elseif(auth()->check() && auth()->user()->hasRole('doctor'))
    @section('title', 'DOCTOR DASHBOARD')
@else
    @section('title', 'PATIENT DASHBOARD')
@endif
@push('css')
    <link href="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}"
        rel="stylesheet">
    <style>
        table,
        th {
            font-size: small;
        }

        .colAction a,
        .colAction button {
            display: none;
        }

        .colSession a {
            display: none;
        }

    </style>
@endpush
@section('content')

    <div class="container-fluid">

        <!-- Widgets -->
        @if (auth()->user()->hasRole('admin'))
            <div class="row clearfix">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" id="superadmin_moderator">
                    <a href="#" style="text-decoration: none;">
                        <div class="info-box bg-teal hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">supervised_user_circle</i>
                            </div>
                            <div class="content">
                                <div class="text">Total Moderators</div>
                                <div class="number count-to" data-from="0" data-to="{{ $total_moderators }}"
                                    data-speed="1000" data-fresh-interval="20">{{ $total_moderators }}</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" id="superadmin_doctor">
                    <a href="#" style="text-decoration: none;">
                        <div class="info-box bg-green hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">person_add</i>
                            </div>
                            <div class="content">
                                <div class="text">Total Doctors</div>
                                <div class="number count-to" data-from="0" data-to="{{ $total_doctors }}"
                                    data-speed="1000" data-fresh-interval="20">{{ $total_doctors }}</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" id="superadmin_patient">
                    <a href="#" style="text-decoration: none;">
                        <div class="info-box bg-cyan hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">person_search</i>
                            </div>
                            <div class="content">
                                <div class="text">Total Patients</div>
                                <div class="number count-to" data-from="0"
                                    data-to="{{ $dashboard_info['total_patient'] }}" data-speed="15"
                                    data-fresh-interval="20">{{ $dashboard_info['total_patient'] }}</div>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a href="#" style="text-decoration: none;">
                <div class="info-box bg-red hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">airline_seat_individual_suite</i>
                    </div>
                    <div class="content">
                        <div class="text">Appointments Today</div>
                        <div class="number count-to" data-from="0" data-to="0" data-speed="1000" data-fresh-interval="20">0</div>
                    </div>
                </div>
            </a>
        </div> --}}
            </div>
        @endif

        @if (auth()->user()->hasRole('moderator'))
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6" id="moderator_patient">
                    <a href="#" style="text-decoration: none;">
                        <div class="info-box bg-teal hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">supervised_user_circle</i>
                            </div>
                            <div class="content">
                                <div class="text">Total Patients</div>
                                <div class="number count-to" data-from="0"
                                    data-to="{{ $dashboard_info['total_patient'] }}" data-speed="1000"
                                    data-fresh-interval="20">{{ $dashboard_info['total_patient'] }}</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6" id="moderator_appointment">
                    <a href="#appointment" style="text-decoration: none;">
                        <div class="info-box bg-light-green hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">person_add</i>
                            </div>
                            <div class="content">
                                <div class="text">Appointments</div>
                                <div class="number count-to" data-from="0" data-to="{{ $dashboard_info['new_patient'] }}"
                                    data-speed="1000" data-fresh-interval="20">{{ $dashboard_info['new_patient'] }}</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6" id="moderator_followup">
                    <a href="#" style="text-decoration: none;">
                        <div class="info-box bg-cyan hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">person_search</i>
                            </div>
                            <div class="content">
                                <div class="text">Followup Patient</div>
                                <div class="number count-to" data-from="0"
                                    data-to="{{ $dashboard_info['followup_patient'] }}" data-speed="15"
                                    data-fresh-interval="20">{{ $dashboard_info['followup_patient'] }}</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <a href="#" style="text-decoration: none;">
                        <div class="info-box bg-red hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">airline_seat_individual_suite</i>
                            </div>
                            <div class="content">
                                <div class="text">Emergency</div>
                                <div class="number count-to" data-from="0" data-to="0" data-speed="1000"
                                    data-fresh-interval="20">0</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endif

        @if (auth()->user()->hasRole('doctor'))
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6" id="doctor_patient">
                    <a href="#" style="text-decoration: none;">
                        <div class="info-box bg-teal hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">supervised_user_circle</i>
                            </div>
                            <div class="content">
                                <div class="text">Total Patients</div>
                                <div class="number count-to" data-from="0"
                                    data-to="{{ $dashboard_info['total_patient'] }}" data-speed="1000"
                                    data-fresh-interval="20">{{ $dashboard_info['total_patient'] }}</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6" id="doctor_appointment">
                    <a href="#appointment" style="text-decoration: none;">
                        <div class="info-box bg-light-green hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">person_add</i>
                            </div>
                            <div class="content">
                                <div class="text">Appointments</div>
                                <div class="number count-to" data-from="0" data-to="{{ $dashboard_info['new_patient'] }}"
                                    data-speed="1000" data-fresh-interval="20">{{ $dashboard_info['new_patient'] }}</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6" id="doctor_followup">
                    <a href="#" style="text-decoration: none;">
                        <div class="info-box bg-cyan hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">person_search</i>
                            </div>
                            <div class="content">
                                <div class="text">Followup Patient</div>
                                <div class="number count-to" data-from="0"
                                    data-to="{{ $dashboard_info['followup_patient'] }}" data-speed="15"
                                    data-fresh-interval="20">{{ $dashboard_info['followup_patient'] }}</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <a href="#" style="text-decoration: none;">
                        <div class="info-box bg-red hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">airline_seat_individual_suite</i>
                            </div>
                            <div class="content">
                                <div class="text">Emergency</div>
                                <div class="number count-to" data-from="0" data-to="0" data-speed="1000"
                                    data-fresh-interval="20">0</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endif


        <!-- Widgets End -->


        @if (auth()->check() && (auth()->user()->hasRole('moderator')|| auth()->user()->hasRole('admin')))
            <!-- MODERATOR Tab -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <a class="btn btn-primary waves-effect" href="{{ route('users.create') }}">
                                <i class="material-icons">add</i>
                                <span>Add New Patient</span>
                            </a>
                        </div>
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist" id="moderator_tab">
                                <li role="presentation" class="active"><a id="mod_tab_1" href="#patient"
                                        data-toggle="tab">PATIENTS</a></li>
                                <li role="presentation"><a id="mod_tab_2" href="#appointment"
                                        data-toggle="tab">APPOINTMENTS</a>
                                </li>
                                <li role="presentation"><a id="mod_tab_3" href="#followup_patient"
                                        data-toggle="tab">FOLLOWUP
                                        PATIENTS</a></li>
                                <li role="presentation"><a href="#history" data-toggle="tab">PATIENT HISTORY</a></li>
                                <li role="presentation"><a id="mod_tab_4" href="#doctors" data-toggle="tab">DOCTORS</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="patient">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Gender</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Appointment</th>
                                                            <!-- <th>Action</th> -->
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($patients as $key => $user)
                                                            <tr>
                                                                <td><span>ID: </span>{{ $key + 1 }}</td>
                                                                <td><span>Name: </span>{{ $user->name }}</td>
                                                                <td><span>Gender: </span>{{ $user->gender }}</td>
                                                                <td><span>Email: </span>{{ $user->email }}</td>
                                                                <td><span>Phone: </span>{{ $user->phone }}</td>
                                                                <td><span>Appointment: </span>
                                                                    @if (!$user->appointments->isEmpty())
                                                                        @foreach ($user->appointments as $data)
                                                                            @if ($loop->last)
                                                                                @if ($data->isbooked == 1 && $data->isServiced == 0 && $data->isApproved == 1)
                                                                                    <span
                                                                                        class="badge bg-green">Booked</span>
                                                                                @elseif($data->isbooked == 1 &&
                                                                                    $data->isServiced == 0 &&
                                                                                    $data->isApproved == 0)
                                                                                    <span
                                                                                        class="badge bg-red">Pending</span>
                                                                                @else
                                                                                    <a href="{{ route('set_appointment', $user->id) }}"
                                                                                        class="btn btn-info waves-effect">Book</a>
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <a href="{{ route('set_appointment', $user->id) }}"
                                                                            class="btn btn-info waves-effect">Book </a>
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade " id="appointment">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Patient</th>
                                                            <th>Gender</th>
                                                            <th>Symptoms</th>
                                                            <th>Appopint Date</th>
                                                            <th>Assigned Doctor</th>
                                                            <th>Patient Type</th>
                                                            <th>Status</th>
                                                            <th>Appointment</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($appoinments as $key => $data)
                                                            <tr>
                                                                <td><span>ID: </span>{{ $key + 1 }}</td>
                                                                <td><span>Patient: </span>{{ $data->users->name }}</td>
                                                                <td><span>Gender: </span>{{ $data->users->gender }}</td>
                                                                <td><span>Symptoms: </span>{{ $data->patient_symptoms }}
                                                                </td>
                                                                <td><span>Appopint Date: </span><strong
                                                                        style="font-weight:bold">{{ $data->visit_date }}</strong>
                                                                    <br><strong
                                                                        style="color:blue">{{ date('h:i:s A', strtotime($data->slots->start_time)) }}
                                                                        -
                                                                        {{ date('h:i:s A', strtotime($data->slots->end_time)) }}</strong>
                                                                </td>
                                                                <td><span>Assigned Doctor:
                                                                    </span>{{ $data->doctors->name }}</td>
                                                                <td><span>Patient Type: </span>

                                                                    {{ $data->patient_type }}

                                                                </td>
                                                                <td><span>Status: </span>
                                                                    @if ($data->isApproved == 1)
                                                                        <span class="badge bg-green">Confirmed</span>
                                                                    @else
                                                                        <span class="badge bg-red">Pending</span>
                                                                    @endif
                                                                    <div class="mt-3"><span
                                                                            class="badge bg-red"
                                                                            id="<?php echo 'txtAptStatus_Mod' . $data->id; ?>"></span>
                                                                    </div>
                                                                </td>

                                                                <td class="text-center"><span>Appointment: </span>
                                                                    <a href="{{ route('appointments.edit', $data->id) }}"
                                                                        class="btn btn-success waves-effect">
                                                                        <i class="material-icons">edit</i>
                                                                    </a>
                                                                    <button class="btn btn-warning waves-effect"
                                                                        type="button"
                                                                        onclick="deleteCategory('{{ $data->id }}')">
                                                                        <i class="material-icons">clear</i>
                                                                    </button>
                                                                    <form id="delete-form-{{ $data->id }}"
                                                                        action="{{ route('appointments.destroy', $data->id) }}"
                                                                        method="POST" style="display:none">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="followup_patient">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Patient</th>
                                                            <th>Symptoms</th>
                                                            <th>Diagnosis</th>
                                                            <th>CC</th>
                                                            <th>Investigations</th>
                                                            <th>Medicine Prescribed</th>
                                                            <th>Instructions</th>
                                                            <th>Assigned Doctor</th>
                                                            <th>Last Visit</th>
                                                            <th>Followup Visit Date</th>
                                                            <th>Virtual Session</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($followup_patient_list as $key => $data)
                                                            <tr>
                                                                <td><span>ID: </span>{{ $key + 1 }}</td>
                                                                <td><span>Patient: </span>{{ $data->users->name }}</td>
                                                                <td><span>Symptoms: </span>{{ $data->patient_symptoms }}
                                                                </td>
                                                                <td><span>Diagnosis: </span>{{ $data->diagonosis }}</td>
                                                                <td><span>CC: </span>{{ $data->cc }}</td>
                                                                <td><span>Investigations:
                                                                    </span>{{ $data->investigation }}</td>
                                                                <td><span>Medicine Prescribed:
                                                                    </span>{{ $data->prescribe_medicines }}</td>
                                                                <td><span>Instructions:
                                                                    </span>{{ $data->instruction }}</td>
                                                                <td><span>Assigned Doctor:
                                                                    </span>{{ $data->doctors->name }}</td>
                                                                <td><span>Last Visit: </span><strong
                                                                        style="font-weight:bold">{{ $data->visit_date }}</strong>
                                                                    <br><strong
                                                                        style="color:blue">{{ date('h:i:s A', strtotime($data->slots->start_time)) }}
                                                                        -
                                                                        {{ date('h:i:s A', strtotime($data->slots->end_time)) }}</strong>
                                                                </td>
                                                                <td><span>Followup Visit Date:
                                                                    </span>{{ $data->follow_up_visit_date }}</td>
                                                                <td><span>Virtual Session: </span>
                                                                    <a href="{{ route('reschedule_appointment', $data->id) }}"
                                                                        class="btn btn-info waves-effect">
                                                                        <i
                                                                            class="material-icons">restore</i><span>Reschedule</span>
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

                                <div role="tabpanel" class="tab-pane fade " id="history">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Patient</th>
                                                            <th>Gender</th>
                                                            <th>Symptoms</th>
                                                            <th>Appopint Date</th>
                                                            <th>Medicine Prescribed</th>
                                                            <th>Followup Visit Date</th>
                                                            <th>Assigned Doctor</th>
                                                            <th>Spent Hour</th>
                                                            <th>Patient Type</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($patient_history as $key => $data)
                                                            <tr>
                                                                <td><span>ID: </span>{{ $key + 1 }}</td>
                                                                <td><span>Patient: </span><a title='patient profile'
                                                                        href="{{ route('patient_profile', $data->patient_id) }}">{{ $data->users->name }}</a>
                                                                </td>
                                                                <td><span>Gender: </span>{{ $data->users->gender }}</td>
                                                                <td><span>Symptoms: </span>{{ $data->patient_symptoms }}
                                                                </td>
                                                                <td><span>Appopint Date: </span><strong
                                                                        style="font-weight:bold">{{ $data->visit_date }}</strong>
                                                                    <br><strong
                                                                        style="color:blue">{{ date('h:i:s A', strtotime($data->slots->start_time)) }}
                                                                        -
                                                                        {{ date('h:i:s A', strtotime($data->slots->end_time)) }}</strong>
                                                                </td>
                                                                <td><span>Medicine Prescribed:
                                                                    </span>{{ $data->prescribe_medicines }}</td>
                                                                <td><span>Followup Visit Date:
                                                                    </span>{{ $data->follow_up_visit_date }}</td>
                                                                <td><span>Assigned Doctor:
                                                                    </span>{{ $data->doctors->name }}</td>
                                                                <td><span>Spent Hour: </span>{{ $data->spent_hour }}</td>
                                                                <td><span>Patient Type: </span>
                                                                    {{ $data->patient_type }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="doctors">
                                    <!-- Doctor -->
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Gender</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($doctors as $key => $user)
                                                            <tr>
                                                                <td><span>ID: </span>{{ $key + 1 }}</td>
                                                                <td><span>Name: </span>{{ $user->name }} <br>
                                                                    {{ doctor_degree_details($user->id) }}
                                                                </td>
                                                                <td><span>Email: </span>{{ $user->email }}</td>
                                                                <td><span>Phone: </span>{{ $user->phone }}</td>
                                                                <td><span>Gender: </span>{{ $user->gender }}</td>
                                                                {{-- <td>
                                                    @foreach ($user->roles as $item)
                                                        {{ $item->name }}
                                                    @endforeach
                                                    </td> --}}
                                                                {{-- <td>
                                                        <span class="badge bg-green">Active</span>                                       
                                                    </td> --}}


                                                                <td class="text-center"><span>Action: </span>
                                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                                        class="btn btn-info waves-effect">
                                                                        <i class="material-icons">edit</i>
                                                                    </a>
                                                                    <button class="btn btn-danger waves-effect"
                                                                        type="button"
                                                                        onclick="deleteCategory('{{ $user->id }}')">
                                                                        <i class="material-icons">delete</i>
                                                                    </button>
                                                                    <form id="delete-form-{{ $user->id }}"
                                                                        action="{{ route('users.destroy', $user->id) }}"
                                                                        method="POST" style="display:none">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Doctor -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# MODERATOR Tab -->
        @endif

        @if (auth()->check() && auth()->user()->hasRole('doctor'))

            <!-- DOCTOR Tab -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist" id="doctor_tab">
                                <li role="presentation" class="active"><a href="#appointment" id="doc_tab_1"
                                        data-toggle="tab">APPOINTMENTS</a></li>
                                <li role="presentation"><a href="#patient" id="doc_tab_2" data-toggle="tab">MY PATIENTS</a>
                                </li>
                                <li role="presentation"><a href="#followup_patient" id="doc_tab_3"
                                        data-toggle="tab">FOLLOWUP
                                        PATIENTS</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="appointment">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Patient</th>
                                                            <th>Gender</th>
                                                            <th>Symptoms</th>
                                                            <th>Appoint Date</th>
                                                            <th>Patient Type</th>
                                                            <th>Virtual Session</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($appoinments as $key => $data)
                                                            <tr>
                                                                <td><span>ID: </span>{{ $key + 1 }}</td>
                                                                <td><span>Patient: </span>{{ $data->users->name }}</td>
                                                                <td><span>Gender: </span>{{ $data->users->gender }}</td>
                                                                <td><span>Symptoms: </span>{{ $data->patient_symptoms }}
                                                                </td>
                                                                <td><span>Appoint Date: </span><strong
                                                                        style="font-weight:bold">{{ $data->visit_date }}</strong>
                                                                    <br><strong
                                                                        style="color:blue">{{ date('h:i:s A', strtotime($data->slots->start_time)) }}
                                                                        -
                                                                        {{ date('h:i:s A', strtotime($data->slots->end_time)) }}</strong>
                                                                </td>

                                                                <td><span>Patient Type: </span>
                                                                    {{ $data->patient_type }}
                                                                </td>



                                                                <td class="colSession"><span>Virtual Session: </span>
                                                                    <a id="<?php echo 'btnStartSession' . $data->id; ?>"
                                                                        href="{{ route('chat', [$data->id, $data->room_id, $data->users->name]) }}"
                                                                        class="btn btn-info waves-effect" type="button">
                                                                        Start Session
                                                                    </a>
                                                                    <b>
                                                                        <i class="text-success"
                                                                            id="<?php echo 'txtStartSession' . $data->id; ?>"></i>
                                                                    </b>
                                                                </td>
                                                                <td class="colAction"><span>Action: </span>
                                                                    <a id="<?php echo 'btnReschedule_doc' . $data->id; ?>"
                                                                        href="{{ route('reschedule_appointment', $data->id) }}"
                                                                        class="btn btn-info waves-effect"
                                                                        type="button">Reschedule
                                                                    </a>

                                                                    <a id="<?php echo 'txtReplaceCancle' . $data->id; ?>"
                                                                        class="btn btn-warning waves-effect" type="button">
                                                                        N\A
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

                                <div role="tabpanel" class="tab-pane fade" id="patient">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Symptoms</th>
                                                            <th>Diagnosis</th>
                                                            <th>CC</th>
                                                            <th>Investigations</th>
                                                            <th>Medicine Prescribed</th>
                                                            <th>Instructions</th>
                                                            <th>Last Visit</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($my_patients as $key => $data)
                                                            <tr>
                                                                <td><span>ID: </span>{{ $key + 1 }}</td>
                                                                <td><span>Name: </span><a title='patient profile'
                                                                        href="{{ route('patient_profile', $data->patient_id) }}">{{ $data->users->name }}</a>
                                                                </td>
                                                                <td><span>Symptoms: </span>{{ $data->patient_symptoms }}
                                                                </td>
                                                                <td><span>Diagnosis: </span>{{ $data->diagonosis }}</td>
                                                                <td><span>CC: </span>{{ $data->cc }}</td>
                                                                <td><span>Investigations:
                                                                    </span>{{ $data->investigation }}</td>
                                                                <td><span>Medicine Prescribed:
                                                                    </span>{{ $data->prescribe_medicines }}</td>
                                                                <td><span>Instructions: </span>
                                                                    {{ $data->instructions }}
                                                                </td>
                                                                <td><span>Last Visit: </span><strong
                                                                        style="font-weight:bold">{{ $data->visit_date }}</strong>
                                                                    <br><strong
                                                                        style="color:blue">{{ date('h:i:s A', strtotime($data->slots->start_time)) }}
                                                                        -
                                                                        {{ date('h:i:s A', strtotime($data->slots->end_time)) }}</strong>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="followup_patient">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Patient</th>
                                                            <th>Symptoms</th>
                                                            <th>Diagnosis</th>
                                                            <th>CC</th>
                                                            <th>Investigations</th>
                                                            <th>Medicine Prescribed</th>
                                                            <th>Last Visit</th>
                                                            <th>Followup Visit Date</th>
                                                            {{-- <th>Virtual Session</th> --}}
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($followup_patient_list as $key => $data)
                                                            <tr>
                                                                <td><span>ID: </span>{{ $key + 1 }}</td>
                                                                <td><span>Patient: </span>{{ $data->users->name }}</td>
                                                                <td><span>Symptoms: </span>{{ $data->patient_symptoms }}
                                                                </td>
                                                                <td><span>Diagnosis: </span>{{ $data->diagonosis }}</td>
                                                                <td><span>CC: </span>{{ $data->cc }}</td>
                                                                <td><span>Investigations:
                                                                    </span>{{ $data->investigation }}</td>
                                                                <td><span>Medicine Prescribed:
                                                                    </span>{{ $data->prescribe_medicines }}</td>
                                                                <td><span>Last Visit: </span><strong
                                                                        style="font-weight:bold">{{ $data->visit_date }}</strong>
                                                                    <br><strong
                                                                        style="color:blue">{{ date('h:i:s A', strtotime($data->slots->start_time)) }}
                                                                        -
                                                                        {{ date('h:i:s A', strtotime($data->slots->end_time)) }}</strong>
                                                                </td>
                                                                <td><span>Followup Visit Date:
                                                                    </span>{{ $data->follow_up_visit_date }}</td>
                                                                {{-- <td><span>Virtual Session: </span>
                                                        <a href="{{ route('reschedule_appointment',$data->id) }}"
                                                            class="btn btn-info waves-effect">
                                                            <i class="material-icons">restore</i><span>Reschedule
                                                            </span>
                                                        </a>
                                                    </td> --}}
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
                </div>
            </div>
            <!-- #END# DOCTOR Tab -->

        @endif

        @if (auth()->check() && auth()->user()->hasRole('patient'))

            <!-- PATIENT Tab -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div style="font-size: 16px; font-weight: bold; margin-bottom: 10px;">
                        <strong style="color:red">Related News : </strong><a href="https://corona.gov.bd/"
                            target="_blank">corona.gov.bd</a>, <a href="http://www.iedcr.gov.bd/" target="_blank">IEDCR</a>,
                        <a href="https://www.worldometers.info/coronavirus/" target="_blank">Worldwide Corona Update
                            Today</a>
                    </div>
                    <div class="card">
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist" id="patient_tab">
                                <li role="presentation" class="active"><a href="#book" data-toggle="tab">BOOK
                                        APPOINTMENT</a>
                                </li>
                                <li role="presentation"><a href="#appointment" data-toggle="tab">APPOINTMENTS</a></li>
                                <li role="presentation"><a href="#my_history" data-toggle="tab">MY HISTORY</a></li>
                                <li role="presentation"><a href="#documents" data-toggle="tab">Upload Documents</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="book">
                                    @php
                                        $status = getPatientAppointmentStatus(auth()->user()->id);
                                    @endphp

                                    @if ($status > 0)

                                        <h5 class="text-success">You have requested for an Appointment. Please Click
                                            <strong>'APPOINTMENTS'</strong> from top menu for details
                                        </h5>

                                    @else

                                        <h4>Please click on 'Book Now' button to get an Appointment or call us at <span
                                                style="color:red">+8801780208855</span></h4>
                                        <h3><a href="{{ route('set_appointment', auth()->user()->id) }}"
                                                class="btn btn-lg btn-success">Book Now</a></h3>
                                    @endif
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="appointment">
                                    <div class="row clearfix">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Patient</th>
                                                            {{-- <th>Gender</th> --}}
                                                            <th>Symptoms</th>
                                                            <th>Appoint Date</th>
                                                            <th>Assigned Doctor</th>
                                                            <th>Status</th>
                                                            <th>Virtual Session</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($appoinments as $key => $data)
                                                            <tr>
                                                                <td><span>ID:</span>{{ $key + 1 }}</td>
                                                                <td><span>Patient:</span>{{ $data->users->name }}</td>
                                                                {{-- <td><span>Gender:</span>{{ $data->users->gender }}</td> --}}
                                                                <td><span>Symptoms:</span>{{ $data->patient_symptoms }}
                                                                </td>
                                                                <td><span>Appoint Date:</span>{{ $data->visit_date }}
                                                                    <br>
                                                                    <strong
                                                                        style="color:blue">{{ date('h:i:s A', strtotime($data->slots->start_time)) }}
                                                                        -
                                                                        {{ date('h:i:s A', strtotime($data->slots->end_time)) }}
                                                                    </strong>
                                                                </td>
                                                                <td><span>Assigned
                                                                        Doctor:</span>{{ $data->doctors->name }}</td>
                                                                <td><span>Status:</span>
                                                                    @if ($data->isApproved == 1)
                                                                        <span class="badge bg-green">Confirmed<span>

                                                                            @else
                                                                                <span class="badge bg-red">Pending<span>
                                                                    @endif
                                                                </td>
                                                                <td class="colSession"><span>Virtual Session:</span>
                                                                    @if ($data->isApproved == 1)
                                                                        <b><i class="text-success"
                                                                                id="<?php echo 'txtJoinSession' . $data->id; ?>"></i></b>
                                                                        <a id="<?php echo 'btnJoinSession' . $data->id; ?>"
                                                                            href="{{ route('chat', [$data->id, $data->room_id, $data->users->name]) }}"
                                                                            class="btn btn-info waves-effect">
                                                                            Join Session
                                                                        </a>
                                                                </td>
                                                            @else
                                                                <strong class="text">N/A<strong>
                                                        @endif
                                                        <td class="colAction"><span>Action:</span>
                                                            <a id="<?php echo 'btnReschedule_pat' . $data->id; ?>"
                                                                href="{{ route('reschedule_appointment', $data->id) }}"
                                                                class="btn btn-info waves-effect" type="button">Reschedule
                                                            </a>
                                                            <a id="<?php echo 'btnCancleApt_pat' . $data->id; ?>" class="btn btn-danger waves-effect"
                                                                type="button">
                                                                N/A
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

    <div role="tabpanel" class="tab-pane fade" id="my_history">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Doctor</th>
                                <th>Visit Date</th>
                                <th>Followup Visit Date</th>
                                <th>Symptoms</th>
                                <th>Diagnosis</th>
                                <th>CC</th>
                                <th>Investigation</th>
                                <th>Medicine Prescribed</th>
                                <th>Instructions</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($my_history as $key => $data)
                                <tr>
                                    <td><span>ID: </span>{{ $key + 1 }}</td>
                                    <td><span>Doctor: </span>{{ $data->doctors->name }}</td>
                                    <td><span>Visit Date: </span><strong
                                            style="font-weight:bold">{{ $data->visit_date }}</strong>
                                        <br><strong
                                            style="color:blue">{{ date('h:i:s A', strtotime($data->slots->start_time)) }}
                                            -
                                            {{ date('h:i:s A', strtotime($data->slots->end_time)) }}</strong>
                                    </td>
                                    <td><span>Followup Visit Date:
                                        </span>{{ $data->follow_up_visit_date }}</td>
                                    <td><span>Symptoms: </span>{{ $data->patient_symptoms }}
                                    <td><span>Diagnosis: </span>{{ $data->diagonosis }}
                                    </td>
                                    <td><span>CC: </span>{{ $data->cc }}
                                    </td>
                                    <td><span>Investigation: </span>{{ $data->investigation }}
                                    </td>
                                    <td><span>Medicine Prescribed:
                                        </span>{{ $data->prescribe_medicines }}</td>
                                    <td><span>Instructions:
                                        </span>{{ $data->instructions }}</td>
                                    <td><span>Action: </span><a href="{{ route('prescription_download', $data->id) }}"
                                            class="btn btn-info waves-effect" target="_blank">
                                            <i class="material-icons">file_download</i>
                                        </a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div role="tabpanel" class="tab-pane fade" id="documents">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <div class="table-responsive">
                    <a href="{{ route('viewfile') }}" class="btn btn-primary">Upload</a>
                    <br><br>
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($my_file as $key => $data)
                                <tr>
                                    <td><span>ID: </span>{{ $key + 1 }}</td>
                                    <td><span>File: </span>
                                        {{ $data->title }}
                                    </td>
                                    <td><span>Action: </span>
                                        <a href="{{ route('downloadfile', $data->id) }}" class="btn btn-primary"><i
                                                class="material-icons">file_download</i></a>
                                        <!-- <a
                                                                href="{{ route('viewfile', $data->id) }}"
                                                                class="btn btn-info waves-effect" target="_blank">
                                                                <i class="material-icons">file_upload</i>
                                                            </a> -->
                                        <!-- <input type="file" name="image"> -->
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
    </div>
    </div>
    <!-- #END# PATIENT Tab -->

    @endif


    @if (auth()->check() && auth()->user()->hasRole('admin'))
        <!-- Approval Requests -->
        @if ($total_approval > 0)
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Registration Approval Requests
                                <span class="badge bg-blue"></span>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Gender</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($approval_users as $key => $user)
                                            <tr>
                                                <td><span>ID: </span>{{ $key + 1 }}</td>
                                                <td><span>Name: </span>{{ $user->name }}</td>
                                                <td><span>Email: </span>{{ $user->email }}</td>
                                                <td><span>Phone: </span>{{ $user->phone }}</td>
                                                <td><span>Gender: </span>{{ $user->gender }}</td>
                                                <td><span>Role: </span>
                                                    @foreach ($user->roles as $item)
                                                        {{ $item->name }}
                                                    @endforeach
                                                </td>
                                                <td><span>Status: </span>
                                                    <span class="badge bg-red">Pending</span>
                                                </td>

                                                <td class="text-center"><span>Action: </span>
                                                    <button class="btn btn-warning waves-effect" type="button"
                                                        onclick="approveCategory('{{ $user->id }}')">
                                                        Approve
                                                    </button>
                                                    <form id="approve-form-{{ $user->id }}"
                                                        action="{{ route('approve_user', $user->id) }}" method="POST"
                                                        style="display:none">
                                                        @csrf

                                                    </form>
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
        @endif
        <!-- Approval -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <a class="btn btn-primary waves-effect" href="{{ route('users.create') }}">
                            <i class="material-icons">add</i>
                            <span>New User</span>
                        </a>
                    </div>
                    <div class="body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs tab-nav-right" role="tablist" id="superadmin_tab">
                            <li role="presentation" class="active"><a id="sup_tab_1" href="#moderators"
                                    data-toggle="tab">MODERATORS</a></li>
                            <li role="presentation"><a id="sup_tab_2" href="#doctors" data-toggle="tab">DOCTORS</a></li>
                            <li role="presentation"><a id="sup_tab_3" href="#patients" data-toggle="tab">PATIENTS</a></li>
                            <li role="presentation"><a id="sup_tab_4" href="#documents" data-toggle="tab">Uploaded
                                    Documents</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="moderators">
                                <!-- Moderator -->
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Gender</th>
                                                        {{-- <th>Role</th> --}}
                                                        <th>Status</th>
                                                        <th>Approval</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($moderators as $key => $user)
                                                        <tr>
                                                            <td><span>ID: </span>{{ $key + 1 }}</td>
                                                            <td><span>Name: </span>{{ $user->name }}</td>
                                                            <td><span>Email: </span>{{ $user->email }}</td>
                                                            <td><span>Phone: </span>{{ $user->phone }}</td>
                                                            <td><span>Gender: </span>{{ $user->gender }}</td>
                                                            {{-- <td>
                                                    @foreach ($user->roles as $item)
                                                        {{ $item->name }}
                                                    @endforeach
                                                    </td> --}}
                                                            <td><span>Status: </span>
                                                                <span class="badge bg-green">Active</span>
                                                            </td>

                                                            <td class="text-center"><span>Approval: </span>
                                                                <button class="btn btn-danger waves-effect" type="button"
                                                                    onclick="pendingCategory('{{ $user->id }}')">
                                                                    Make Pending
                                                                </button>
                                                                <form id="pending-form-{{ $user->id }}"
                                                                    action="{{ route('pending_user', $user->id) }}"
                                                                    method="POST" style="display:none">
                                                                    @csrf

                                                                </form>
                                                            </td>
                                                            <td class="text-center"><span>Action: </span>
                                                                <a href="{{ route('users.edit', $user->id) }}"
                                                                    class="btn btn-info waves-effect">
                                                                    <i class="material-icons">edit</i>
                                                                </a>
                                                                <button class="btn btn-danger waves-effect" type="button"
                                                                    onclick="deleteModerator('{{ $user->id }}')">
                                                                    <i class="material-icons">delete</i>
                                                                </button>
                                                                <form id="delete-moderator-{{ $user->id }}"
                                                                    action="{{ route('users.destroy', $user->id) }}"
                                                                    method="POST" style="display:none">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Moderator -->
                            </div>

                            <div role="tabpanel" class="tab-pane fade " id="doctors">
                                <!-- Doctor -->
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Gender</th>
                                                        {{-- <th>Role</th> --}}
                                                        <th>Status</th>
                                                        <th>Approval</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($doctors as $key => $user)
                                                        <tr>
                                                            <td><span>ID: </span>{{ $key + 1 }}</td>
                                                            <td><span>Name: </span>{{ $user->name }}</td>
                                                            <td><span>Email: </span>{{ $user->email }}</td>
                                                            <td><span>Phone: </span>{{ $user->phone }}</td>
                                                            <td><span>Gender: </span>{{ $user->gender }}</td>
                                                            {{-- <td>
                                                    @foreach ($user->roles as $item)
                                                        {{ $item->name }}
                                                    @endforeach
                                                    </td> --}}
                                                            <td><span>Status: </span>
                                                                <span class="badge bg-green">Active</span>
                                                            </td>

                                                            <td class="text-center"><span>Approval: </span>
                                                                <button class="btn btn-danger waves-effect" type="button"
                                                                    onclick="deleteCategory('{{ $user->id }}')">
                                                                    Make Pending
                                                                </button>
                                                                <form id="delete-form-{{ $user->id }}"
                                                                    action="{{ route('pending_user', $user->id) }}"
                                                                    method="POST" style="display:none">
                                                                    @csrf

                                                                </form>
                                                            </td>
                                                            <td class="text-center"><span>Action: </span>
                                                                <a href="{{ route('users.edit', $user->id) }}"
                                                                    class="btn btn-info waves-effect">
                                                                    <i class="material-icons">edit</i>
                                                                </a>
                                                                <button class="btn btn-danger waves-effect" type="button"
                                                                    onclick="deleteDoctor('{{ $user->id }}')">
                                                                    <i class="material-icons">delete</i>
                                                                </button>
                                                                <form id="delete-doctor-{{ $user->id }}"
                                                                    action="{{ route('users.destroy', $user->id) }}"
                                                                    method="POST" style="display:none">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Doctor -->
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="patients">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Gender</th>
                                                        {{-- <th>Role</th> --}}
                                                        <th>AssignedDoctor</th>
                                                        {{-- <th>Approval</th> --}}
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($patients as $key => $user)
                                                        <tr>
                                                            <td><span>ID: </span>{{ $key + 1 }}</td>
                                                            <td><span>Name: </span>{{ $user->name }}</td>
                                                            <td><span>Email: </span>{{ $user->email }}</td>
                                                            <td><span>Phone: </span>{{ $user->phone }}</td>
                                                            <td><span>Gender: </span>{{ $user->gender }}</td>
                                                            {{-- <td>
                                                    @foreach ($user->roles as $item)
                                                        {{ $item->name }}
                                                    @endforeach
                                                    </td> --}}
                                                            <td><span>AssignedDoctor: </span>
                                                                {{ getDoctorNameById($user->id) }}
                                                            </td>

                                                            {{-- <td class="text-center">
                                                        <button class="btn btn-danger waves-effect"  type="button" onclick="deleteCategory('{{ $user->id }}')">
                                                    Make Pending
                                                    </button>
                                                    <form id="delete-form-{{ $user->id }}"
                                                        action="{{ route('pending_user', $user->id) }}" method="POST"
                                                        style="display:none">
                                                        @csrf

                                                    </form>
                                                    </td> --}}
                                                            <td class="text-center"><span>Action: </span>
                                                                <a href="{{ route('users.edit', $user->id) }}"
                                                                    class="btn btn-info waves-effect">
                                                                    <i class="material-icons">edit</i>
                                                                </a>
                                                                <button class="btn btn-danger waves-effect" type="button"
                                                                    onclick="deleteDoctor('{{ $user->id }}')">
                                                                    <i class="material-icons">delete</i>
                                                                </button>
                                                                <form id="delete-doctor-{{ $user->id }}"
                                                                    action="{{ route('users.destroy', $user->id) }}"
                                                                    method="POST" style="display:none">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="documents">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <!-- <th>User Role</th> -->
                                                        <th>Documents</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($patients as $key => $user)
                                                        <tr>
                                                            <td><span>ID: </span>{{ $key + 1 }}</td>
                                                            <td><span>Email: </span>{{ $user->name }}</td>
                                                            <td><span>Name: </span>{{ $user->email }}</td>
                                                            <td><span>Documents: </span></td>
                                                            <!-- <td><span>Role: </span>{{ $user->id }}</td> -->

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
            </div>
        </div>
    @endif

    </div>

@endsection

@push('js')
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}">
    </script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}">
    </script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}">
    </script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}">
    </script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}">
    </script>
    <script src="{{ asset('assets/backend/js/pages/tables/jquery-datatable.js') }}"></script>

    <!-- <script src="{{ asset('assets/backend/js/pages/index.js') }}"></script> -->
    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/jquery-countto/jquery.countTo.js ') }}"></script>

    <!-- Morris Plugin Js -->
    {{-- <!-- <script src="{{ asset('assets/backend/plugins/raphael/raphael.min.js ')}}"></script> --}}
    {{-- <script src="{{ asset('assets/backend/plugins/morrisjs/morris.js ')}}"></script> --> --}}

    <!-- ChartJs -->
    {{-- <!-- <script src="{{ asset('assets/backend/plugins/chartjs/Chart.bundle.js ')}}"></script> --> --}}

    <!-- Flot Charts Plugin Js -->
    {{-- <!-- <script src="{{ asset('assets/backend/plugins/flot-charts/jquery.flot.js ')}}"></script> --}}
    {{-- <script src="{{ asset('assets/backend/plugins/flot-charts/jquery.flot.resize.js ')}}"></script> --}}
    {{-- <script src="{{ asset('assets/backend/plugins/flot-charts/jquery.flot.pie.js ')}}"></script> --}}
    {{-- <script src="{{ asset('assets/backend/plugins/flot-charts/jquery.flot.categories.js ')}}"></script> --}}
    {{-- <script src="{{ asset('assets/backend/plugins/flot-charts/jquery.flot.time.js ')}}"></script> --> --}}

    <!-- Sparkline Chart Plugin Js -->
    {{-- <!-- <script src="{{ asset('assets/backend/plugins/jquery-sparkline/jquery.sparkline.js ')}}"></script> --> --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script type="text/javascript">
        function deleteCategory(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure ?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-' + id).submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    // swalWithBootstrapButtons.fire(
                    // 'Not Cancelled!',
                    // )
                }
            })
        }

        function deleteModerator(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure to delete ?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-moderator-' + id).submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    // swalWithBootstrapButtons.fire(
                    // 'Not Cancelled!',
                    // )
                }
            })
        }

        function deleteDoctor(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure to delete ?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-doctor-' + id).submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    // swalWithBootstrapButtons.fire(
                    // 'Not Cancelled!',
                    // )
                }
            })
        }

        function approveCategory(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure to approve ?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('approve-form-' + id).submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    // swalWithBootstrapButtons.fire(
                    // 'Not Cancelled!',
                    // )
                }
            })
        }

        function pendingCategory(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure to pending ?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('pending-form-' + id).submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    // swalWithBootstrapButtons.fire(
                    // 'Not Cancelled!',
                    // )
                }
            })
        }


        $(document).ready(function() {
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('#doctor_tab a[href="' + activeTab + '"]').tab('show');
                $('#patient_tab a[href="' + activeTab + '"]').tab('show');
                $('#moderator_tab a[href="' + activeTab + '"]').tab('show');
                $('#superadmin_tab a[href="' + activeTab + '"]').tab('show');
            }

            //Time elasped check
            @php
            $role = auth()
                ->user()
                ->hasRole('admin');
            echo "var allApt = $appoinments ;";
            @endphp

            var role = {!! json_encode(Auth::user()); !!};
            role = ('{{ $role }}' == "1" ? "admin" : "other");

            if (allApt.length > 0) {
                allApt.forEach(function(item) {
                    var s_status = item.virtualSessionStatus;
                    if (item.isServiced == 0 && (!(s_status != null) || s_status == 0 || s_status == 2 ||
                            s_status == 3)) {
                        setInterval(() => {
                            var date = new Date();
                            var day = date.getDate();
                            var month = date.getMonth();
                            var year = date.getFullYear();
                            var hours = date.getHours();
                            var minutes = date.getMinutes();
                            var seconds = date.getSeconds();
                            var currentTime = (month + 1) + "/" + day + "/" + year + " " + hours + ":" + minutes + ":" + seconds;
                            var aptDate = item.visit_date;
                            var newDate = changeDateFormat(aptDate);
                            var currentDate = (month + 1) + "/" + day + "/" + year;

                            var d_apt = new Date(newDate); //apt date
                            var d_current = new Date(currentDate); //current date
                            var yearDiff = d_current.getFullYear() - d_apt.getFullYear();
                            var monthDiff = (d_current.getMonth()) - d_apt.getMonth();
                            var dateDiff = (d_current.getDate()) - d_apt.getDate();

                            var aptTimeStart = newDate + " " + item.slots.start_time;
                            var aptTimeEnd = newDate + " " + item.slots.end_time;
                            var diff_start = moment.duration(moment(aptTimeStart).diff(moment(currentTime)));
                            var diff_end = moment.duration(moment(currentTime).diff(moment(aptTimeEnd)));
                            var a_date = new Date(newDate); // some mock date
                            var a_milliseconds = a_date.getTime();
                            var c_date = new Date(currentDate); // some mock date
                            var c_milliseconds = c_date.getTime();
                            console.log('Start difference ',diff_start.minutes())
                            console.log('End difference ',diff_end.minutes())
                            $("#txtAptStatus_Mod" + (item.id)).hide();
                            if (yearDiff == 0 && monthDiff == 0 && dateDiff == 0) {
                                if (diff_start.hours() >= 0 && diff_start.minutes() > 0) {
                                    // same day upcomming
                                    // doctor dash
                                    $("#btnStartSession" + (item.id)).hide();
                                    var msghr = (diff_start.hours() == 0) ? "" : diff_start.hours() + " hour(s) ";
                                    $('#txtStartSession' + (item.id)).text("Start after " + msghr + diff_start.minutes() + " minute(s).").removeClass("bg-red");
                                    // $("#btnCancleApt_doc" + (item.id)).show();
                                    $("#txtReplaceCancle" + (item.id)).show();
                                    $("#btnReschedule_doc" + (item.id)).hide();
                                    //Patient dash
                                    $("#btnJoinSession" + (item.id)).hide();
                                    $('#txtJoinSession' + (item.id)).text("Join after " +msghr + diff_start.minutes() + " minute(s).").removeClass("bg-red");
                                    $("#btnCancleApt_pat" + (item.id)).show();
                                    $("#btnReschedule_pat" + (item.id)).hide();

                                } else if (diff_start.hours() == 0 && diff_start.minutes() <= 0 && diff_end.hours() <= 0 && diff_end.minutes() < 0) { //same day in between session duration 
                                    $("#btnStartSession" + (item.id)).show();
                                    $('#txtStartSession' + (item.id)).text("").removeClass("bg-red");
                                    $("#txtReplaceCancle" + (item.id)).show();
                                    $("#btnReschedule_doc" + (item.id)).hide();

                                    //Patient dash
                                    $("#btnJoinSession" + (item.id)).show();
                                    $('#txtJoinSession' + (item.id)).text("").removeClass("bg-red");
                                    $("#btnCancleApt_pat" + (item.id)).show();
                                    $("#btnReschedule_pat" + (item.id)).hide();
                                } else {
                                    //same day session missed
                                    $("#btnStartSession" + (item.id)).hide();
                                    $('#txtStartSession' + (item.id)).text("Appointment Missed !!!").addClass("bg-red");
                                    $("#btnReschedule_doc" + (item.id)).show();
                                    $("#txtReplaceCancle" + (item.id)).hide();
                                    //Patient dash
                                    $("#btnJoinSession" + (item.id)).hide();
                                    $('#txtJoinSession' + (item.id)).text("Appointment Missed !!!").addClass("bg-red");
                                    $("#btnReschedule_pat" + (item.id)).show();
                                    $("#btnCancleApt_pat" + (item.id)).hide();
                                    //Moderator
                                    $("#txtAptStatus_Mod" + (item.id)).show();
                                    $('#txtAptStatus_Mod' + (item.id)).text("Appointment Missed !!!");
                                }
                            } else {
                                if ((c_milliseconds - a_milliseconds) < 0) {
                                    console.log("upcomming");
                                    // doc dash
                                    $("#btnStartSession" + (item.id)).hide();
                                    $('#txtStartSession' + (item.id)).text("Upcoming").removeClass("bg-red");
                                    $("#txtReplaceCancle" + (item.id)).show();
                                    $("#btnReschedule_doc" + (item.id)).hide();
                                    //Patient dash
                                    $("#btnJointSession" + (item.id)).hide();
                                    $('#txtJoinSession' + (item.id)).text("Upcoming").removeClass("bg-red");
                                    $("#btnCancleApt_pat" + (item.id)).show();
                                    $("#btnReschedule_pat" + (item.id)).hide();
                                } else {
                                    console.log("pass");
                                    $("#btnStartSession" + (item.id)).hide();
                                    $('#txtStartSession' + (item.id)).text("Appointment Missed !!!").addClass("bg-red");;
                                    $("#btnReschedule_doc" + (item.id)).show();
                                    $("#txtReplaceCancle" + (item.id)).hide();
                                    //Patient dash
                                    $("#btnJoinSession" + (item.id)).hide();
                                    $('#txtJoinSession' + (item.id)).text("Appointment Missed !!!").addClass("bg-red");;
                                    $("#btnReschedule_pat" + (item.id)).show();
                                    $("#btnCancleApt_pat" + (item.id)).hide();
                                    //Moderator
                                    $("#txtAptStatus_Mod" + (item.id)).show();
                                    $('#txtAptStatus_Mod' + (item.id)).text(
                                        "Appointment Missed !!!");
                                }
                            }
                        }, 1000);
                    } else if (item.isServiced == 1 && (!(s_status != null) || s_status == 1 || s_status ==
                            4)) {
                        var a_status = (s_status == 1) ? "Complete" : "Manual";
                        // $("#txtAptStatus_Mod" + (item.id)).show();
                        // $('#txtAptStatus_Mod' + (item.id)).text(a_status);
                    }
                })
            }


            function changeDateFormat(inputDate) { // expects Y-m-d
                var splitDate = inputDate.split('-');
                if (splitDate.count == 0) {
                    return null;
                }

                var year = splitDate[0];
                var month = splitDate[1];
                var day = splitDate[2];

                // console.log("splitDate[2]: "+splitDate[3]);

                return month + '/' + day + '/' + year;
            }

            // FOR DOCTOR, TAB ACTIVE ON WIDGET BOX CLICK

            $("#doctor_appointment").click(function() {
                // alert('ok');
                $('#doc_tab_1').trigger('click');

            });

            $("#doctor_patient").click(function() {
                $('#doc_tab_2').trigger('click');
            });

            $("#doctor_followup").click(function() {
                $('#doc_tab_3').trigger('click');
            });

            // FOR MODERATOR, TAB ACTIVE ON WIDGET BOX CLICK

            $("#moderator_patient").click(function() {
                // alert('ok');
                $('#mod_tab_1').trigger('click');

            });

            $("#moderator_appointment").click(function() {
                $('#mod_tab_2').trigger('click');
            });

            $("#moderator_followup").click(function() {
                $('#mod_tab_3').trigger('click');
            });

            // FOR SUPER ADMIN, TAB ACTIVE ON WIDGET BOX CLICK

            $("#superadmin_moderator").click(function() {
                // alert('ok');
                $('#sup_tab_1').trigger('click');

            });

            $("#superadmin_doctor").click(function() {
                $('#sup_tab_2').trigger('click');
            });

            $("#superadmin_patient").click(function() {
                $('#sup_tab_3').trigger('click');
            });


        });
    </script>
@endpush
