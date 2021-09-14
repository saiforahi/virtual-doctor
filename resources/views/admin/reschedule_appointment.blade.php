@extends('layouts.backend.app')

@section('title', 'Create Appointment')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Tabs With Icon Title -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Follow-up visit scheduling
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="body">
                                    <form method="POST" action="{{ route('reschedule_store') }}" class="form-horizontal"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="patient_id">Patient Name </label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <select class="form-control patient" name="patient_id" id="patient_id" required>
                                                        <option value="{{ $appointment->patient_id }}">{{ $appointment->users->name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="patient_id">Assigned Doctor </label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <select class="form-control patient" name="doctor_id" id="doctor_id" required oninvalid="this.setCustomValidity('Please select a doctor')" oninput="this.setCustomValidity('')">
                                                        <option value="{{ $appointment->doctor_id }}">{{ $appointment->doctors->name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="patient_id">Patient Type</label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <select class="form-control patient" name="patient_type"
                                                        id="patient_type" required
                                                        oninvalid="this.setCustomValidity('Please select patient type')"
                                                        oninput="this.setCustomValidity('')">
                                                        <option value="Existing">Existing</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="name">Investigation</label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input readonly="" type="text" id="investigation"
                                                            class="form-control" name="investigation"
                                                            value="{{ $appointment->investigation }}"
                                                            placeholder="investigation" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="name">CC</label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input readonly="" type="text" id="cc" class="form-control"
                                                            name="cc" value="{{ $appointment->cc }}" placeholder="cc"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="name">Diagonosis</label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input readonly="" type="text" id="diagonosis"
                                                            class="form-control" name="diagonosis"
                                                            value="{{ $appointment->diagonosis }}"
                                                            placeholder="diagonosis" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="name">Instructions</label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input readonly="" type="text" id="instructions"
                                                            class="form-control" name="instructions"
                                                            value="{{ $appointment->instructions }}"
                                                            placeholder="instructions" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="name">Prescribed medicine</label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input readonly="" type="text" id="prescribe_medicines"
                                                            class="form-control" name="prescribe_medicines"
                                                            value="{{ $appointment->prescribe_medicines }}"
                                                            placeholder="prescribe medicines" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="patient_symptoms">Last Vital Signs: </label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <p>
                                                <ul>
                                                    @if (count($vitalsigns) > 0)
                                                        @foreach ($vitalsigns as $data)
                                                            <li>{{ $data }}</li>
                                                        @endforeach
                                                    @else
                                                        <li>Temperature: <span id="txt_temp">0</span> F</li>
                                                        <li>Pulse: <span id="txt_pulse">0</span> bpm</li>
                                                        <li>Blood Pressure: <span id="txt_bp">0</span> mmHg</li>
                                                        <li>Oxygen Rate: <span id="txt_oxy">0</span> %</li>
                                                        <li>Weight: <span id="txt_oxy">0</span> Kg</li>
                                                    @endif

                                                </ul>
                                                </p>

                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="follow_up_visit_date">Follow up visit date </label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input onchange="doctorinfo()" type="date" id="follow_up_visit_date"
                                                            class="form-control" placeholder=""
                                                            name="follow_up_visit_date"
                                                            value="{{ $appointment->follow_up_visit_date }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="pre_appointId" id="pre_appointId"
                                            value="{{ $appointment->id }}">

                                        <div class="row clearfix">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="slot_id">Time Schedule </label>
                                            </div>
                                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7" id="slotlist">
                                                <div class="form-group">
                                                    <select class="form-control schedule" onkeyup="createSchedule()"
                                                        onchange="createSchedule()" name="slot_id" id="slot_id" required>
                                                        <option value="">Select</option>

                                                        {{-- <option value="create_schedule">Create Time Schedule</option> --}}
                                                        @foreach ($slot as $data)
                                                            <option value="{{ $data->id }}">
                                                                {{ date('h:i:s A', strtotime($data->start_time)) }} -
                                                                {{ date('h:i:s A', strtotime($data->end_time)) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="phone" value="{{ $appointment->users->phone }}">


                                        <div class="row clearfix schedulTime" style="display: none;">
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                <label for="task_end_date">Create Schedule </label>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-4 col-xs-3">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="Time" id="start_time" class="form-control"
                                                            onchange="timeCheck()" name="start_time" value=""
                                                            data-toggle="tooltip" data-placement="top" title="Start Time">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-4 col-xs-3">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="time" id="end_time" class="form-control"
                                                            name="end_time" value="" onchange="lastTimeCheck()"
                                                            onkeyup="lastTimeCheck()" onclick="lastTimeCheck()"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Minimum time difference should be 15 minutes.">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="row clearfix">
                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="estimated_task_hour">Forecast hour </label>
                                                        </div>
                                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="number" id="estimated_task_hour" class="form-control" placeholder="" name="estimated_task_hour" value="" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>  -->
                                        <!-- <div class="row clearfix">
                                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                                            <label for="task_comments">Comments </label>
                                                        </div>
                                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="text" id="task_comments" class="form-control" placeholder="" name="task_comments" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>  -->



                                        <div class="row clearfix">
                                            <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                                <a href="{{ route('dashboard') }}" style="text-decoration: none;">
                                                    <button type="button"
                                                        class="btn btn-danger m-t-15 waves-effect">CANCEL</button>
                                                </a>
                                                <button type="submit"
                                                    class="btn btn-primary m-t-15 waves-effect saveInfo">SUBMIT</button>
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
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;

        $('#follow_up_visit_date').attr('min', maxDate);

        function createSchedule() {
            var slot_id = $('#slot_id').val();
            if (slot_id == 'create_schedule') {
                $('.schedulTime').css('display', 'block');
            } else {
                $('.schedulTime').css('display', 'none');
            }

        }

        function doctorinfo() {
            $('.saveInfo').prop('disabled', true);
            var doc_id = $('#doctor_id').val();
            var follow_up_visit_date = $('#follow_up_visit_date').val();


            if (follow_up_visit_date == '') {
                $('.saveInfo').prop('disabled', true);
            } else {
                $('.saveInfo').prop('disabled', false);
            }


            var appointId = $('#appointId').val();
            // alert(doc_id);
            targetUrl = '/teleassist-amarlab/set_appointment/' + appointId + '/doctor_slot/' + doc_id + '/' +
                follow_up_visit_date;


            $.get(targetUrl, function(data) {

                $('#slotlist').html(data);
            });

        }

        function timeCheck() {
            var start_time = $('#start_time').val();


            minutes = 30;
            var end_time = moment(start_time, "hh:mm")
                .add(minutes, 'minutes')
                .format('HH:mm');

            $('#end_time').val(end_time);
        }


        function lastTimeCheck() {
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

            if (new_start_time < end_time || start_time == end_time) {
                $('#end_time').val(new_end_time);
            }

            if (start_time > end_time || start_time == end_time) {
                $('#end_time').val(new_start_time);
            }

            var mins = moment.utc(moment(end_time, "HH:mm:ss").diff(moment(start_time, "HH:mm:ss"))).format("HH:mm");
            var fiftemm = moment('00:15', "HH:mm").format('HH:mm');
            // alert(mins);
            if (mins < fiftemm || start_time == end_time) {
                $('#end_time').val(new_start_time);
            }

        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.doctor').select2({
                placeholder: "Select Doctor",
            });

            $('.schedule').select2({
                placeholder: "Select Time Schedule",
            });

            $('.patient').select2({
                placeholder: "Select Patient Type",
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

@endpush
