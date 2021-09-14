<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class LiveChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function chat($id, $room, $name)
    {
        $appointment = Appointment::find($id);
        $ch = curl_init();
        $url = "https://teleassiststunturn.herokuapp.com/";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        $result = curl_exec($ch);
        if (Auth::check() && Auth::user()->hasRole('doctor')) {
            $ispatients = false;
        } else {
            $ispatients = true;
        }
        if (Auth::check()) {
            // dd(Auth::user()->name);
            $userName = Auth::user()->name;
        }
        $doctorInfo = User::find($appointment->doctor_id);
        // $vitalArrayFinal = [];
        // $vitalArray = explode(",", $appointment->vital_signs);
        // foreach ($vitalArray as $key => $value) {
        //     array_push($vitalArrayFinal, explode(":", $value)[1]);
        // }
        $medicalHistory = Appointment::orderBy('visit_date', 'desc')
            ->where('patient_id', $appointment->patient_id)
            ->limit(2)->get();
        if(count($medicalHistory) < 2){
            $medicalHistory = null;
        }
        // dd(count($medicalHistory));
        // dd($result);
        return view('admin.chat', compact('result', 'id', 'room', 'userName', 'appointment', 'ispatients', 'doctorInfo', 'medicalHistory'));
    }

    public function send_session_data(Request $request)
    {
        $appointmentId = $request->appointmentId;
        $diagonosis = $request->diagnosis;
        $prescribe_medicines = $request->medicine;
        $follow_up_visit_date = $request->followUpDate;
        $spent_hour = $request->spentHour;
        $cc = $request->complains;
        $investigation = $request->investigation;
        $instructions = $request->instruction;
        $vitalSign = $request->vitalSign;
        $virtualSessionStatus = $request->vrSessionStatus;
        $appointment = Appointment::find($appointmentId);
        $isService = 0;
        if ($virtualSessionStatus == 1 || $virtualSessionStatus == 4) {
            $isService = 1; // complete or manual
        } else if ($virtualSessionStatus == 2 || $virtualSessionStatus == 3) {
            //incomplete=2;interrupt=3;
            $isService = 0;
        }
        // dd($spent_hour);
        $appointment->where('id', $appointmentId)->update(array(
            'prescribe_medicines' => $prescribe_medicines,
            'diagonosis' => $diagonosis,
            'isServiced' => $isService,
            'follow_up_visit_date' => $follow_up_visit_date,
            'spent_hour' => $spent_hour,
            'cc' => $cc,
            'investigation' => $investigation,
            'instructions' => $instructions,
            'vital_signs' => $vitalSign,
            'virtualSessionStatus' => $virtualSessionStatus,
        ));
        return "success";
    }

    public function send_session_status_patient(Request $request)
    {
        $appointmentId = $request->appointmentId;
        $virtualSessionStatus = $request->vrSessionStatus;
        $appointment = Appointment::find($appointmentId);
        if ($virtualSessionStatus == 2 && $appointment->isServiced == 0) {
            $appointment->where('id', $appointmentId)->update(array(
                'isServiced' => 0,
                'virtualSessionStatus' => $virtualSessionStatus,
            ));
            return "success";
        }

    }
}
