<?php

use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Clinic;
use App\Models\DoctorSchedule;
use Spatie\Permission\Models\Role;

function getRoles(){
    return Role::all();
}

function get_departments(){
    return Department::all();
}
function getPatientAppointmentStatus($id)
{

    $data = Appointment::where('patient_id', $id)
        ->where('isbooked', 1)
        ->where('isServiced', 0)
        ->get()->count();

    if (isset($data)) {
        return $data;
    } else {
        return 0;
    }
}

function getDoctorNameById($id)
{
    $data = Appointment::where('patient_id', $id)->first();
    if (isset($data)) {
        $doctor_name = User::find($data->doctor_id);
        // dd($doctor_name->name);
        return $doctor_name->name;
    } else {
        $doctor_name = 0;
        return "N/A";
    }
}


function sendSMSToDoctorPatient($doctor, $patient, $slot, $visit_date)
{
    $doctor_name = $doctor->name;
    $patient_name = $patient->name;

    $visitDate = date('F j Y', strtotime($visit_date));

    $startTime = date('g:i A', strtotime($slot->start_time));
    $endTime = date('g:i A', strtotime($slot->end_time));
    // message
    if (!defined('API_ACCESS_KEY')) define('API_ACCESS_KEY', 'AAAAq_wHm7E:APA91bGMsE-gkkC7Iq7XGxIkPhB33zJXco3DhisWaLfhgvx3h-XjRbuvxZfJgDYsoeg3C4jd5u6uEtrdC9XGfXeMAF5PMpaci1IWho7RYR_NZaGjHf4b0wL4Hzckozc_BropyyNhDU4b');

    $msg_number = $patient->phone;
    $doc_numbr = $doctor->phone;


    $phone_number = substr($msg_number, -11);
    $country_code = substr($msg_number, 0, -11);

    $doc_phone_number = substr($doc_numbr, -11);
    $doc_country_code = substr($doc_numbr, 0, -11);

    $message = 'Dear ' . $patient_name . ', Your appointment with ' . $doctor_name . ' has been set at ' . $startTime . ' - ' . $endTime . ' on ' . $visitDate . ' Please log in at this site https://www.virtualdr.com.bd';

    $registrationIds = 'eCGR2SJWoC8:APA91bFBfcWNmTeNWdl3BGKxNDtDV7Bt8TWDZttZAMS3liU_b1ynG-TRay4iIc9KYoP2_RhUg_UCboo2cr8Bw3Ew3Bgsa7zQYfFN20pmASwiD5cMj7hKg6BqlwE1M-jLXzuHlcuMXqHe';
    // prep the bundle
    $msg = array(
        'to' => $registrationIds,
        'data' => array(
            'code' => $message,
            'country' => $country_code,
            'host_number' => $phone_number
        )
    );


    $headers = array(
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($msg));
    $result = curl_exec($ch);
    // echo $result;
    // exit();
    curl_close($ch);

    $message2 = 'Dear ' . $doctor_name . ', Your appointment with  ' . $patient_name . ' has been set at ' . $startTime . ' - ' . $endTime . ' on ' . $visitDate . ' Please log in at this site https://www.virtualdr.com.bd';


    $msg2 = array(
        'to' => $registrationIds,
        'data' => array(
            'code' => $message2,
            'country' => $doc_country_code,
            'host_number' => $doc_phone_number
        )
    );

    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch2, CURLOPT_POST, true);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($msg2));
    $result = curl_exec($ch2);
    // echo $result;
    // exit();
    curl_close($ch2);
}

function sendRescheduleSMSToDoctorPatient($doctor, $patient, $slot, $visit_date)
{
    $doctor_name = $doctor->name;
    $patient_name = $patient->name;

    $visitDate = date('F j Y', strtotime($visit_date));

    $startTime = date('g:i A', strtotime($slot->start_time));
    $endTime = date('g:i A', strtotime($slot->end_time));
    // message
    if (!defined('API_ACCESS_KEY')) define('API_ACCESS_KEY', 'AAAAq_wHm7E:APA91bGMsE-gkkC7Iq7XGxIkPhB33zJXco3DhisWaLfhgvx3h-XjRbuvxZfJgDYsoeg3C4jd5u6uEtrdC9XGfXeMAF5PMpaci1IWho7RYR_NZaGjHf4b0wL4Hzckozc_BropyyNhDU4b');

    $msg_number = $patient->phone;
    $doc_numbr = $doctor->phone;


    $phone_number = substr($msg_number, -11);
    $country_code = substr($msg_number, 0, -11);

    $doc_phone_number = substr($doc_numbr, -11);
    $doc_country_code = substr($doc_numbr, 0, -11);

    $message = 'Dear ' . $patient_name . ', Your appointment with ' . $doctor_name . ' has been set reschedule at ' . $startTime . ' - ' . $endTime . ' on ' . $visitDate . ' Please log in at this site https://www.virtualdr.com.bd';

    $registrationIds = 'eCGR2SJWoC8:APA91bFBfcWNmTeNWdl3BGKxNDtDV7Bt8TWDZttZAMS3liU_b1ynG-TRay4iIc9KYoP2_RhUg_UCboo2cr8Bw3Ew3Bgsa7zQYfFN20pmASwiD5cMj7hKg6BqlwE1M-jLXzuHlcuMXqHe';
    // prep the bundle
    $msg = array(
        'to' => $registrationIds,
        'data' => array(
            'code' => $message,
            'country' => $country_code,
            'host_number' => $phone_number
        )
    );


    $headers = array(
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($msg));
    $result = curl_exec($ch);
    // echo $result;
    // exit();
    curl_close($ch);

    $message2 = 'Dear ' . $doctor_name . ', Your appointment with  ' . $patient_name . ' has been set reschedule at ' . $startTime . ' - ' . $endTime . ' on ' . $visitDate . ' Please log in at this site https://www.virtualdr.com.bd';


    $msg2 = array(
        'to' => $registrationIds,
        'data' => array(
            'code' => $message2,
            'country' => $doc_country_code,
            'host_number' => $doc_phone_number
        )
    );

    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch2, CURLOPT_POST, true);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($msg2));
    $result = curl_exec($ch2);
    // echo $result;
    // exit();
    curl_close($ch2);
}


function sendSMSToRequest($doctor, $patient, $slot, $visit_date)
{

    $doctor_name = $doctor->name;
    $patient_name = $patient->name;


    $visitDate = date('F j Y', strtotime($visit_date));

    $startTime = date('g:i A', strtotime($slot->start_time));
    $endTime = date('g:i A', strtotime($slot->end_time));
    // message
    if (!defined('API_ACCESS_KEY')) define('API_ACCESS_KEY', 'AAAAq_wHm7E:APA91bGMsE-gkkC7Iq7XGxIkPhB33zJXco3DhisWaLfhgvx3h-XjRbuvxZfJgDYsoeg3C4jd5u6uEtrdC9XGfXeMAF5PMpaci1IWho7RYR_NZaGjHf4b0wL4Hzckozc_BropyyNhDU4b');

    $msg_number = $patient->phone;
    $doc_numbr = $doctor->phone;


    $phone_number = substr($msg_number, -11);
    $country_code = substr($msg_number, 0, -11);

    //    $doc_phone_number = substr($doc_numbr, -11);
    //    $doc_country_code = substr($doc_numbr, 0, -11);
    $message = 'Dear ' . $patient_name . ',Your appoinment request has sent to moderator for approval. Please wait for the confirmation sms. Thank you.';

    $registrationIds = 'eCGR2SJWoC8:APA91bFBfcWNmTeNWdl3BGKxNDtDV7Bt8TWDZttZAMS3liU_b1ynG-TRay4iIc9KYoP2_RhUg_UCboo2cr8Bw3Ew3Bgsa7zQYfFN20pmASwiD5cMj7hKg6BqlwE1M-jLXzuHlcuMXqHe';
    // prep the bundle
    $msg = array(
        'to' => $registrationIds,
        'data' => array(
            'code' => $message,
            'country' => $country_code,
            'host_number' => $phone_number
        )
    );


    $headers = array(
        'Authorization: key=' . API_ACCESS_KEY,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($msg));
    $result = curl_exec($ch);
    // echo $result;
    // exit();
    curl_close($ch);
}

function doctor_degree($id)
{
    $doctor_degrees = Doctor::where('user_id', $id)->first();

    $educational_degrees = $doctor_degrees->educational_degrees;

    $single_degree = explode('|', $educational_degrees);
    foreach ($single_degree as $single_value) {
        $singlevalue = explode(',', $single_value);
        $sgv[] = $singlevalue[1];
    }
    $result = implode(",", $sgv);
    return $result;
}


function doctor_degree_details($id)
{
    if (Doctor::where('user_id', $id)->first()->educational_degrees != null) {
        $educational_degrees = Doctor::where('user_id', $id)->first()->educational_degrees;
        $single_degree = explode('|', $educational_degrees);
        foreach ($single_degree as $single_value) {
            $singlevalue = explode(',', $single_value);
            $sgv[] = $singlevalue[1] . '(' . $singlevalue[2] . ')';
        }
        $result = implode(", ", $sgv);
    } else {
        $result = 'Degree: N/A';
    }

    return $result;
}

function doctor_professional_info($id)
{
    $professional = Doctor::where('user_id', $id)->first();

    $professional_info['registration_no'] = $professional->registration_no;
    $professional_info['licence_no'] = $professional->licence_no;
    $professional_info['ptr_no'] = $professional->ptr_no;
    $professional_info['s2_no'] = $professional->s2_no;
    $professional_info['visit_fee'] = $professional->visit_fee;
    return $professional_info;
}

function getDeptNameById($id)
{
    if($id != null){
        $data = Department::findOrFail($id);
        //dd($data);
        if ($data) {
            //dd($data->name);  
            return $data->name;
        } else {
            return "N/A";
        }
    }
    else{
        return "N/A";
    }
    // dd($id);
    
}

function getClinicInfo()
{
    $clinic = Clinic::all();
    return $clinic;
}

function getDoctorSchedule($id, $day)
{
    // dd($day);
    $ds = DoctorSchedule::where('doctor_id', '=', $id)
        ->where('day_name', '=', $day)
        ->orderBy('start_time', 'ASC')
        ->get();

    $schedule_id = [];
    $time = [];

    foreach ($ds as $d) {
        array_push($schedule_id, $d->id);
        array_push($time, $d->start_time);
    }

    $data = array_combine($schedule_id, $time);

    // dd($data);

    return $data;
}

function getDayName($id, $day)
{
    // dd($day);
    $ds = DoctorSchedule::where('doctor_id', '=', $id)
        ->where('day_name', '=', $day)
        ->orderBy('start_time', 'ASC')
        ->get();


    $time = [];

    foreach ($ds as $d) {
        array_push($time, $d->start_time);
    }

    if (!empty($time)) {
        $data1 = min($time);
        $data2 = max($time);

        $final = date('h:i A', strtotime($data1)) . '-' . date('h:i A', strtotime($data2));
    } else {
        $final = "";
    }


    if ($final != "") {
        return $final;
    } else {
        return 'N/A';
    }
}


function getOpenCloseDay($id, $day)
{
    // dd($day);
    $ds = DoctorSchedule::where('doctor_id', '=', $id)
        ->where('day_name', '=', $day)
        ->orderBy('start_time', 'ASC')
        ->get();


    $time = [];

    foreach ($ds as $d) {
        array_push($time, $d->start_time);
    }

    if (!empty($time)) {
        $data = max($time);
        $now = date("H:i A");
        // $d = date('h:i A', strtotime($now));
        if ($now > $data) {
            $final = "Closed Now";
        } else {
            $final = "Open Now";
        }
    } else {
        $final = "";
    }


    if ($final != "") {
        return $final;
    } else {
        return 'N/A';
    }
}

function getIsBooked($id)
{
    // dd($day);
    // select('appointments.*')
    // ->join('doctor_schedules', 'appointments.slot_id', '=', 'slots.id')
    $ds = Appointment::where('doctor_id', '=', $id)
        ->where('isbooked', '=', 1)
        ->where('isServiced', '=', 0)
        ->get();
    
    $days = [];
    $time = [];

    foreach ($ds as $d) {
        array_push($days, $d->slots->day_name);
        array_push($time, $d->slots->start_time);
    }

    $data = array_combine($days, $time);
    

    // dd($data);

    return $data;
}

function getVisitDate($id)
{
    return Appointment::select('visit_date')
        ->where('doctor_id', '=', $id)
        ->where('isbooked', '=', 1)
        ->where('isServiced', '=', 0)
        ->get();    
}

