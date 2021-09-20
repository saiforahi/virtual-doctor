@extends('layouts.backend.app')

@section('title','Chat')

@push('css')
<style>
    h4 {
        color: #ab47bc;
    }

    button {
        box-shadow: 0 0 5px gray;
    }

    section.content {
        margin: 0 0 0 300px;
    }

    .ls-closed section.content {
        margin-left: 0px;
    }

    .docVitalsignInput p {
        margin: 0 0 10px 0 !important;
    }

    .docVitalsignInput p input {
        width: 75px;
        border-radius: 4px;
    }

    .modal .modal-header .modal-title {
        display: contents;
    }

    .modal-header .close {
        box-shadow: none;
    }

    #paitentHistory h4 a {
        width: 34px;
        height: 34px;
        padding: 6px;
        border-radius: 50%;
    }

</style>
@endpush

@section('content')
<div class="container-fluid bg-dark">
    <div class="row">
        <div class="col-md-9">
            <section class="call-bar pt-3 pb-3 clearfix">
                <!-- <button class="btn btn-primary btn-outline-primary" type="button" id="record-btn" onclick="record();">start record</button>
                <button class="btn btn-primary btn-outline-primary" type="button" id="stop-btn" onclick="stop();">stop record</button> -->
                <!-- <button class="btn call-btn" data-toggle="modal" data-target="#createRoomModal" id="createRoomModalBtn">Create Room</button>
                <button class="btn call-btn" data-toggle="modal" data-target="#joinRoomModal" id="joinRoomModalBtn">Join</button> -->
                <div class="local-video d-inline">
                    <!-- local video here -->
                </div>
                <!-- <button class="btn" data-toggle="modal" data-target="#userConnectedModal" id="userConnectedModalBtn"></button> -->
                <div id="duration">
                    <!-- duration shows up here -->
                </div>
                <!-- <button id="testSocket">testSocket</button> -->
                {{-- <button class="btn btn-link float-right" data-toggle="tooltip" onclick="openCanvas();"
                    data-placement="bottom" title="Whiteboard"><i class="fas fa-chalkboard"></i></button> --}}
                <div class="float-right room-id-div">
                    <button class="btn btn-link float-right" id="RoomInfo" data-toggle="tooltip" data-placement="bottom"
                        title="Room ID"><i class="fas fa-qrcode"></i></button>
                    <div class="custom-tooltip">Room ID: <span id="roomIdDiv"></span></div>
                    <i class="fas fa-caret-up"></i>
                </div>
                <button class="btn btn-link float-right" id="openHistoryBtn" data-toggle="tooltip"
                    onclick="openHistory();" data-placement="bottom" title="Paitent's History"><i
                        class="fas fa-heartbeat"></i></button>
                <button class="btn btn-link float-right" id="openRxBtn" data-toggle="tooltip" onclick="openRx();"
                    data-placement="bottom" title="Prescription"><i class="fas fa-prescription"></i></button>
            </section>
            <!-- video container -->
            <section id="videoContainer">
                <!-- video elements here -->
                <div class="bottom-call-bar">
                    <button class="btn btn-info" id="mute-btn" data-toggle="tooltip" onclick="muteUnmute();"
                        data-placement="top"><i class="fas fa-microphone"></i></button>
                    <button class="btn btn-danger" id="leave-btn" data-toggle="modal" data-target="#endSessionModal"><i
                            class="fas fa-phone-slash"></i></button>
                    <button class="btn btn-info" id="video-btn" onclick="videoOnOff();"><i
                            class="fas fa-video"></i></button>
                    <button class="btn btn-info" id="chat-btn" onclick="openChatModal();"><i
                            class="far fa-comments"></i></button>
                </div>
                <div class="session-wellcome-msg">
                    <h4>Welcome to the virtual session!</h4>
                    <p>Your
                        @if ($ispatients == false)
                        patient
                        @endif
                        @if ($ispatients == true)
                        doctor
                        @endif
                        will join in a while. <br> Please wait or Call +8801780208855.
                        @if ($ispatients == false)
                        you can also call ({{$appointment->users->phone}}) the patient if s/he doesn't join the session.
                        <br><br>
                        <a href="tel:{{$appointment->users->phone}}" class="btn btn-primary"
                            onclick="enablePresOnCall()" data-toggle="tooltip" title="Call the patient via phone or any other apps">
                            <i class="fa fa-phone" aria-hidden="true"></i> CALL NOW
                        </a>
                        @endif
                    </p>
                </div>
            </section>
        </div>
        <div class="col-md-3 chat-box-holder">
            {{-- right side doctors field --}}
            <section class="doctor-field-holder">
                <div class="doctor-field">
                    <label for="complains">C/C</label>
                    <textarea class="mt-3" onkeyup="storeInSession(event);" name="complains" id="complains"
                        placeholder="New complains..." autofocus></textarea>
                </div>
                <div class="doctor-field diagnosis-div">
                    <label for="diagnosis">Diagnosis
                        <a href="https://www.cms.gov/Medicare/Coding/ICD10/2020-ICD-10-CM" target="_blank"
                            data-toggle="tooltip" title="Centers for Medicare & Medicaid Services (CMS)">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                    <textarea class="mt-3" onkeyup="storeInSession(event);" name="diagnosis" id="diagnosis"
                        placeholder="New Diagnosis..."></textarea>
                </div>
                <div class="doctor-field">
                    <label for="investigation">Investigation</label>
                    <textarea class="mt-3" onkeyup="storeInSession(event);" name="investigation" id="investigation"
                        placeholder="New Investigation..."></textarea>
                </div>
                <div class="doctor-field medicine-div">
                    <label for="medicine">
                        <i class="fas fa-prescription"></i>
                        <a href="https://medex.com.bd/" target="_blank" data-toggle="tooltip" title="Medicine Index">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                    <textarea class="mt-3" onkeyup="storeInSession(event);" name="medicine" id="medicine"
                        placeholder="New Medicines..."></textarea>
                </div>
                <div class="doctor-field">
                    <label for="instruction">Instruction</label>
                    <textarea class="mt-3" onkeyup="storeInSession(event);" name="instruction" id="instruction"
                        placeholder="New Instruction..."></textarea>
                </div>
                <div class="doctor-field">
                    <label for="followUpDate">Follow up date</label>
                    <input class="mt-3" onchange="storeInSession(event);" id="followUpDate" type="date">
                </div>
                <div class="doctor-field clearfix">
                    <button disabled class="mt-3 pull-right" type="button" id="sendPrescriptionBtn"
                        onclick="sendPrescriptionData(event);">Save</button>
                </div>
            </section>
            <!-- right side patient field -->
            <section class="patient-field-holder">
                <div class="patient-field">
                    <label for="temp">Body Temperature</label>
                    <input class="mt-3" onkeyup="storeInSession(event);" name="temp" id="temp"
                        placeholder="Ex: 98&deg;F" autofocus>
                </div>
                <div class="patient-field">
                    <label for="weight">Weight</label>
                    <input class="mt-3" onkeyup="storeInSession(event);" name="weight" id="weight"
                        placeholder="Ex: 68 kg">
                </div>
                <div class="patient-field">
                    <label for="pulse">Pulse</label>
                    <input class="mt-3" onkeyup="storeInSession(event);" name="pulse" id="pulse"
                        placeholder="Ex: 70 bpm">
                </div>
                <div class="patient-field">
                    <label for="bp">Blood Pressure</label>
                    <input class="mt-3" onkeyup="storeInSession(event);" name="bp" id="bp"
                        placeholder="Ex: 120/80 mmHg">
                </div>

                <div class="patient-field">
                    <label for="oxygen">Oxygen Rate</label>
                    <input class="mt-3" onkeyup="storeInSession(event);" name="oxygen" id="oxygen"
                        placeholder="Ex: 98 %">
                </div>
                <div class="patient-field clearfix">
                    <button disabled class="mt-3 pull-right" type="button" id="sendVitalBtn"
                        onclick="sendVitalData(event);">Send</button>
                </div>
            </section>
            <!-- patient fields end -->
            <section id="chatBox" class="mt-3 clearfix">
                <p class="text-center"><b>Dr. & Patient Conversation</b></p>
                <!-- chat here -->
            </section>
            <section class="in-group mt-3 mb-3">
                <input disabled type="text" id="message" class="d-inline" placeholder="Message here..."
                    onkeyup="sendMessage(event);">
                <div class="d-inline">
                    <button disabled class="" type="button" id="sendMessageBtn"
                        onclick="sendMessage(event);">Send</button>
                </div>
            </section>
        </div>
    </div>

    <!-- create room Modal -->
    {{-- <div class="modal fade" id="createRoomModal" tabindex="-1" role="dialog" aria-labelledby="createRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoomModalLabel">Create a Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="createRoomCheckBtn">
                        <label class="form-check-label" for="createRoomCheckBtn">Create room with a random ID</label>
                    </div>
                    <div class="form-group" id="roomIdInputDiv">
                        <label for="roomId">Enter room ID</label>
                        <input type="text" class="form-control" id="roomId" name="roomId" placeholder="E.g. 'Chat Room' or '7thrg34t3ujg'">
                    </div>
                    <div class="form-group">
                        <label for="nicknameInput">Nickname</label>
                        <input type="text" class="form-control" id="nicknameInput" placeholder="Enter a nickname to show in chat">
                    </div>
                    <button type="button" class="btn btn-primary" id="createRoomBtn">Submit</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- join room Modal -->
    {{-- <div class="modal fade" id="joinRoomModal" tabindex="-1" role="dialog" aria-labelledby="joinRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="joinRoomModalLabel">Join a Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="roomIdToJoin">Enter room ID</label>
                        <input type="text" class="form-control" id="roomIdToJoin" name="roomIdToJoin" placeholder="E.g. 'Chat Room' or '7thrg34t3ujg'">
                    </div>
                    <div class="form-group">
                        <label for="nicknameInputToJoin">Nickname</label>
                        <input type="text" class="form-control" id="nicknameInputToJoin" placeholder="Enter a nickname to show in chat">
                    </div>
                    <button type="button" class="btn btn-primary" id="joinRoomBtn">Submit</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- chat box visible in small screen -->
    <div class="chat-box-responsive">
        <button class="btn btn-outline-primary btn-primary" type="button" id="chatClose"><i
                class="fas fa-times"></i></button>
        <section id="chatBoxResponsive" class="clearfix">
            <!-- chat here -->
        </section>
        <section class="in-group mt-3">
            <input disabled type="text" id="messageRes" class="d-inline" placeholder="Comments..."
                onkeyup="sendMessage(event);">
            <div class="d-inline">
                <button disabled class="" type="button" id="sendMessageBtnRes"
                    onclick="sendMessage(event);">Send</button>
            </div>
        </section>
    </div>

    <!-- connected user modal -->
    {{-- <div class="modal fade" id="userConnectedModal" tabindex="-1" role="dialog" aria-labelledby="userConnectedLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userConnectedLabel">Connected user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="user-list">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- canvas modal -->
    <div id="widget-container">
        <!-- canvas shows up here     -->
        <button type="button" class="close" onclick="closeCanvas();">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    {{-- end session modal --}}
    <div class="modal" id="endSessionModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Really want to end the session?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Was this session...</p>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="endSessionStatus"
                            onclick="enableEndSessionBtn();" id="inlineRadio" value="1">
                        <label class="form-check-label" for="inlineRadio">Successful (Service completed)</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="endSessionStatus"
                            onclick="enableEndSessionBtn();" id="inlineRadio1" value="2">
                        <label class="form-check-label" for="inlineRadio1">Incomplete (Service not completed)</label>
                    </div>

                    <div class="form-check form-check-inline" id="radioInterrup">
                        <input class="form-check-input" type="radio" name="endSessionStatus"
                            onclick="enableEndSessionBtn();" id="inlineRadio2" value="3">
                        <label class="form-check-label" for="inlineRadio2">Interrupted (Any inconveniences)</label>
                    </div>
                    <div class="form-check form-check-inline" id="radioCall">
                        <input class="form-check-input" type="radio" name="endSessionStatus"
                            onclick="enableEndSessionBtn();" id="inlineRadio3" value="4">
                        <label class="form-check-label" for="inlineRadio3">Called patient (Over phone)</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="endSessionBtn" disabled onclick="leaveChat();">End
                        Session</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- left side navbar info for doctor and patient -->
    @if($ispatients == false)
    {{-- doctor end view --}}
    <div id="paitentHistory">
        {{-- patient history --}}
        <h4><i class="fas fa-id-badge"></i> Patient Profile
            <a href="tel:{{$appointment->users->phone}}" class="btn btn-primary" data-toggle="tooltip"
                title="Call the patient now">
                <i class="fa fa-phone" aria-hidden="true"></i>
            </a>
        </h4>
        <img class="img-round"
            src="@if(is_null($appointment->users->image)) {{ url('storage/profile/no_profile.png') }} @else {{ url('storage/profile/'.$appointment->users->image) }} @endif"
            width="48" height="48" alt="User" />
        <p>
            <b>Name: </b>{{$appointment->users->name}}
        </p>
        <p>
            <b>Contact: </b>{{$appointment->users->phone}}
        </p>
        <p>
            <b>Gender: </b>{{$appointment->users->gender}} <span class="pull-right"><b>Age:
                </b>{{$appointment->users->age}} years</span>
        </p>
        <p><b>Current Vital Signs: </b> </p>
        <div class="docVitalsignInput">
            <p>Temperature: <input type="text" id="txt_temp" placeholder="Ex: 98" onkeyup="storeInSession(event);">
                &deg;F</p>
            <p>Weight: <input type="text" id="txt_weight" placeholder="Ex: 68" onkeyup="storeInSession(event);">
                kg</p>
            <p>Pulse: <input type="text" id="txt_pulse" placeholder="Ex: 70" onkeyup="storeInSession(event);">
                bpm</p>
            <p>Blood Pressure: <input type="text" id="txt_bp" placeholder="Ex: 120/80" onkeyup="storeInSession(event);">
                mmHg</p>
            <p>Oxygen Rate: <input type="text" id="txt_oxy" placeholder="Ex: 98" onkeyup="storeInSession(event);"> %</p>
            <button disabled style="width: 100%;" class="" type="button" id="saveVitalDataBtn"
                onclick="saveVitalData(event);">Save</button>
        </div>
        <hr>
        <h4><i class="fas fa-file-medical-alt"></i> Medical History <small>(latest one)</small></h4>
        {{-- <p>
            <b>Previous Dr.: </b>
            @if ($appointment->previous_doctor == '')
            No previous Doctor found.
            @else
            {{$appointment->previous_doctor}}
        @endif
        </p> --}}
        <p>
            <b>Symptoms: </b>
            <pre>@php echo $medicalHistory == null ? "No previous data found" : $medicalHistory[0]->patient_symptoms  @endphp</pre>
        </p>
        <p>
            <b>C/C: </b>
            <pre>@php echo $medicalHistory == null ? "No previous data found" : $medicalHistory[0]->cc @endphp</pre>
        </p>
        <p>
            <b>Diagnosis: </b>
            <pre>@php echo $medicalHistory == null ? "No previous data found" : $medicalHistory[0]->diagonosis  @endphp</pre>
        </p>
        <p>
            <b>Investigation: </b>
            <pre>@php echo $medicalHistory == null ? "No previous data found" : $medicalHistory[0]->investigation @endphp</pre>
        </p>
        <p>
            <b><i class="fas fa-prescription"></i>: </b>
            <pre>@php echo $medicalHistory == null ? "No previous data found" : $medicalHistory[0]->prescribe_medicines @endphp</pre>
        </p>
        <p>
            <b>Instructions: </b>
            <pre>@php echo $medicalHistory == null ? "No previous data found" : $medicalHistory[0]->instructions @endphp</pre>
        </p>
        {{-- <p>
            <b>Next Appointments: </b>
            @if ($appointment->new_appointment == '')
            No next appointment scheduled.
            @else
            {{$appointment->new_appointment}}
        @endif
        </p> --}}
        <button class="btn btn-outline-primary btn-primary" type="button" id="historyClose" onclick="closeHistory();"><i
                class="fas fa-times"></i></button>
    </div>
    <div id="prescription">
        {{-- patient prescription --}}
        <div class="chat-box-holder">
            <section class="doctor-field-holder">
                <h4><i class="fas fa-file-prescription"></i> Prescription</h4>
                <div class="doctor-field">
                    <label for="complainsRes">C/C</label>
                    <textarea class="mt-3" onkeyup="storeInSession(event);" name="complainsRes" id="complainsRes"
                        placeholder="New complains..." autofocus></textarea>
                </div>
                <div class="doctor-field diagnosis-div">
                    <label for="diagnosisRes">Diagnosis
                        <a href="https://www.cms.gov/Medicare/Coding/ICD10/2020-ICD-10-CM" target="_blank"
                            data-toggle="tooltip" title="Centers for Medicare & Medicaid Services (CMS)">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                    <textarea class="mt-3" onkeyup="storeInSession(event);" name="diagnosisRes" id="diagnosisRes"
                        placeholder="New Diagnosis..."></textarea>
                </div>
                <div class="doctor-field">
                    <label for="investigationRes">Investigation</label>
                    <textarea class="mt-3" onkeyup="storeInSession(event);" name="investigationRes"
                        id="investigationRes" placeholder="New Investigation..."></textarea>
                </div>
                <div class="doctor-field medicine-div">
                    <label for="medicineRes">
                        <i class="fas fa-prescription"></i>
                        <a href="https://medex.com.bd/" target="_blank" data-toggle="tooltip" title="Medicine Index">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </label>
                    <textarea class="mt-3" onkeyup="storeInSession(event);" name="medicineRes" id="medicineRes"
                        placeholder="New Medicines..."></textarea>
                </div>
                <div class="doctor-field">
                    <label for="instructionRes">Instruction</label>
                    <textarea class="mt-3" onkeyup="storeInSession(event);" name="instructionRes" id="instructionRes"
                        placeholder="New Instruction..."></textarea>
                </div>
                <div class="doctor-field">
                    <label for="followUpDateRes">Follow up date</label>
                    <input class="mt-3" onchange="storeInSession(event);" id="followUpDateRes" type="date">
                </div>
                <div class="doctor-field clearfix">
                    <button disabled class="mt-3 pull-right" type="button" id="sendPrescriptionBtnRes"
                        onclick="sendPrescriptionDataRes(event);">Save</button>
                </div>
                <button class="btn btn-outline-primary btn-primary" type="button" id="historyClose"
                    onclick="closeRx();"><i class="fas fa-times"></i></button>
            </section>
        </div>
    </div>
    @endif

    @if($ispatients == true)
    <div id="doctorHistoryPrescription">
        <h4><i class="fas fa-user-md"></i> Doctor Profile</h4>
        <img class="img-round"
            src="@if(is_null($appointment->users->image)) {{ url('storage/profile/no_profile.png') }} @else {{ url('storage/profile/'.$appointment->users->image) }} @endif"
            width="48" height="48" alt="User" />
        <p>
            <b>Name: </b>{{$doctorInfo->name}}
        </p>
        <p>
            <b>Email: </b>{{$doctorInfo->email}}
        </p>
        <div id="getPrescription">
            {{-- prescription from doctor  --}}
        </div>
        <button class="btn btn-outline-primary btn-primary" type="button" id="historyClose" onclick="closeRx();"><i
                class="fas fa-times"></i></button>
    </div>
    <div id="vitalSign">
        <div class="chat-box-holder">
            <section class="patient-field-holder">
                <h4><i class="fas fa-heartbeat"></i> Vital Signs</h4>
                <div class="patient-field">
                    <label for="tempRes">Body Temperature</label>
                    <input class="mt-3" onkeyup="storeInSession(event);" name="tempRes" id="tempRes"
                        placeholder="Ex: 98&deg; F" autofocus>
                </div>
                <div class="patient-field">
                    <label for="weightRes">Weight</label>
                    <input class="mt-3" onkeyup="storeInSession(event);" name="weightRes" id="weightRes"
                        placeholder="Ex: 68 kg">
                </div>
                <div class="patient-field">
                    <label for="pulseRes">Pulse</label>
                    <input class="mt-3" onkeyup="storeInSession(event);" name="pulseRes" id="pulseRes"
                        placeholder="Ex: 70 bpm">
                </div>
                <div class="patient-field">
                    <label for="bpRes">Blood Pressure</label>
                    <input class="mt-3" onkeyup="storeInSession(event);" name="bpRes" id="bpRes"
                        placeholder="Ex: 120/80 mmHg">
                </div>
                <div class="patient-field">
                    <label for="oxygenRes">Oxygen Rate</label>
                    <input class="mt-3" onkeyup="storeInSession(event);" name="oxygenRes" id="oxygenRes"
                        placeholder="Ex: 98 %">
                </div>
                <div class="patient-field clearfix">
                    <button disabled class="mt-3 pull-right" type="button" id="sendVitalBtnRes"
                        onclick="sendVitalDataRes(event);">Save</button>
                </div>
                <button class="btn btn-outline-primary btn-primary" type="button" id="historyClose"
                    onclick="closeHistory();"><i class="fas fa-times"></i></button>
            </section>
        </div>
    </div>
    @endif
</div>
@if(!auth()->user()->api_token)
<button class="btn btn-primary backbtn" data-toggle="modal" data-target="#endSessionModal"><i class="fa fa-caret-left"
        aria-hidden="true"></i>
    Back</button>
@endif
@endsection

@push('js')
<script type="text/javascript">
    // set some global variable for custom_rtc.js
    @php
    echo "var iceServers = $result;";
    echo "var appointmentId = '$id';";
    echo "var roomId = '$room';";
    echo "var nickname = '$userName';";
    echo "var isPatients = '$ispatients';";
    @endphp

</script>
<!-- webRTC script -->
<script src="{{ asset('js/RTCMultiConnection.min.js')}}"></script>
<script src="{{ asset('js/socket.io.js')}}"></script>
<script src="{{ asset('js/RecordRTC.js')}}"></script>
<script src="{{ asset('js/webrtc-handler.js')}}"></script>
<script src="{{ asset('js/canvas-designer-widget.js')}}"></script>
<script src="{{ asset('js/custom_rtc.js')}}"></script>
<!-- fontawesome kit -->
<script src="https://kit.fontawesome.com/a516280526.js" crossorigin="anonymous"></script>
@endpush
