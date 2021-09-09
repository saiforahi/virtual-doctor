<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Slot;
use App\Models\DoctorSchedule;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use DateTime;
use PDF;
use Mail;

class AppointmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $patients = '';
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super-admin')) {
            $patients = Appointment::latest()
                ->where('isbooked', 1)
                ->where('isServiced', 1)
                ->get();
        }
        if (Auth::user()->hasRole('power-user')) {
            $patients = Appointment::latest()
                ->where('isbooked', 1)
                ->where('isServiced', 1)
                ->where('doctor_id', Auth::user()->id)
                ->get();
        }
        if (Auth::user()->hasRole('user')) {
            $patients = Appointment::latest()
                ->where('isbooked', 1)
                ->where('isServiced', 1)
                ->where('patient_id', Auth::user()->id)
                ->get();
        }
        return view('admin.patient_history', compact('patients'));
    }

    public function set_appointment($id)
    {
        // $slot = Slot::all();
        $slot = DoctorSchedule::all();
        $user = User::find($id);

        $doctor = User::with('roles')
            ->whereHas('roles', function ($q) {
                $q->where('slug', '=', 'power-user');
            })
            ->orderBy('created_at', 'desc')
            ->where('is_deleted', '0')->get();

        // dd($projects);
        return view('admin.create_appointment', compact('user', 'doctor', 'slot', 'id'));
    }


    public function reschedule_appointment($id)
    {
        // $slot = Slot::all();
        $slot = DoctorSchedule::all();
        $appointment = Appointment::findOrFail($id);
        // dd($appointment);
        if (!empty($appointment->vital_signs)) {
            $vitalsigns = explode(',', $appointment->vital_signs);
        } else {
            // dd('noooooo');
            $vitalsigns = [];
        }


        // dd($vitalsigns);

        return view('admin.reschedule_appointment', compact('slot', 'id', 'appointment', 'vitalsigns'));
    }

    public function create()
    {
        //
    }

    public function AppointmentStore(Request $request)
    {
        $uniqid = Str::random(9);
        $vital_signs = 'Temperature: ' . $request->temperature . ' F,Pulse: ' . $request->pulse . ' bpm,Blood Pressure:
         ' . $request->blood_pressure . ' mmHg,Oxygen Rate: ' . $request->oxygen_rate . ' %' . 'Weight: ' .
            $request->weight;

        $data = Appointment::create([
            'patient_id' => Auth::user()->id,
            'doctor_id' => $request->doctor_id,
            'room_id' => $uniqid,
            'patient_type' => 'New',
            'vital_signs' => $vital_signs,
            'patient_symptoms' => $request->patient_symptoms,
            'visit_date' => date("Y-m-d", strtotime($request->visit_date)),
            'schedule_id' => $request->schedule_id,
            'isbooked' => 1,
            'isApproved' => 0,
        ]);

        $doctor = User::find($request->doctor_id);
        $patient = User::find(Auth::user()->id);
        $slot = DoctorSchedule::find($request->schedule_id);
        $moderators = User::with('roles')
            ->whereHas('roles', function ($q) {
                $q->where('slug', '=', 'admin');
            })
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->get();

        foreach ($moderators as $data) {
            $mail_body = '<html>
             <h3>Dear ' . $data->name . ',</h1>
                 <h3>A patient named ' . $patient->name . ', Phone: ' . $patient->phone . ' has been requested to get an
                     appointment with ' . $doctor->name . '</h3>
                 <h3><a href="https://virtualdr.com.bd/login">Click Here</a> to Login your Dashboard and Approve the
                     request.</h3>
            </html>';

            $toModerator = $data->email;

            Mail::send([], [], function ($message) use ($mail_body, $toModerator) {
                $message->from('contact@virtualdr.com.bd', 'Virtual Doctor');
                $message->to($toModerator);
                $message->subject('New Appointment Request!');
                $message->setBody(
                    $mail_body,
                    'text/html'
                );
            });
        }
        sendSMSToRequest($doctor, $patient, $slot, $request->visit_date);
        return redirect('booking-success');
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Dhaka");
        $uniqid = Str::random(9);
        // dd($uniqid);
        $visit_date = $request->visit_date;

        $vital_signs = 'Temperature: ' . $request->temperature . ' F,Pulse: ' . $request->pulse . ' bpm,Blood Pressure: ' . $request->blood_pressure . ' mmHg,Oxygen Rate: ' . $request->oxygen_rate . ' %' . 'Weight: ' . $request->weight;
        // dd($vital_signs);                
        $patientinfo = Appointment::latest()
            ->where('patient_id', $request->patient_id)
            ->limit(1, 0)
            ->first();

        if (!empty($patientinfo)) {
            $exiting_doctor = $patientinfo->doctor_id;
        } else {
            $exiting_doctor = '';
        }

        if (Auth::user()->hasRole('user')) {
            $is_approved = 0;
        } else {
            $is_approved = 1;
        }

        // dd($exiting_doctor);
        if ($exiting_doctor) {

            if ($exiting_doctor == $request->doctor_id) {

                $slot_id = $request->slot_id;
                $data = Appointment::create([
                    'patient_id' => $request->patient_id,
                    'doctor_id' => $request->doctor_id,
                    'room_id' => $uniqid,
                    'patient_type' => $request->patient_type,
                    'patient_symptoms' => $request->patient_symptoms,
                    'vital_signs' => $vital_signs,
                    'visit_date' => $request->visit_date,
                    // 'slot_id' => $slot_id,
                    'schedule_id' => $slot_id,
                    'isbooked' => 1,
                    'isApproved' => $is_approved,
                ]);

                $doctor = User::find($data['doctor_id']);
                $patient = User::find($data['patient_id']);
                // dd($doctor);
                // $slot = Slot::find($slot_id);
                $slot = DoctorSchedule::find($slot_id);

                if (Auth::user()->hasRole('user')) {

                    $moderators = User::with('roles')
                        ->whereHas('roles', function ($q) {
                            $q->where('slug', '=', 'admin');
                        })
                        ->where('is_active', 1)
                        ->where('is_deleted', 0)
                        ->get();

                    foreach ($moderators as $data) {

                        $mail_body = '<html>
                            <h3>Dear ' . $data->name . ',</h1>                            
                            <h3>A patient named ' . $patient->name . ', Phone: ' . $patient->phone . ' has been requested to get an appointment with ' . $doctor->name . '</h3>
                            <h3><a href="https://virtualdr.com.bd/login">Click Here</a> to Login your Dashboard and Approve the request.</h3>
                            </html>';

                        $toModerator = $data->email;

                        Mail::send([], [], function ($message) use ($mail_body, $toModerator) {
                            $message->from('contact@virtualdr.com.bd', 'Virtual Doctor');
                            $message->to($toModerator);
                            $message->subject('New Appointment Request!');
                            $message->setBody(
                                $mail_body,
                                'text/html'
                            );
                        });
                    }
                    sendSMSToRequest($doctor, $patient, $slot, $visit_date);
                } else {

                    sendSMSToDoctorPatient($doctor, $patient, $slot, $visit_date);
                }



                Toastr::success('Appointment Setup Completed Successfully :)', 'success');
            }
        } else {

            // if ($request->start_time && $request->end_time) {
            //     $slotInfo = DoctorSchedule::create([
            //         'start_time' => $request->start_time,
            //         'end_time' => $request->end_time,
            //         'created_at' => new DateTime()
            //     ]);

            //     $slotid = $slotInfo->id;
            // }


            $slot_id = $request->slot_id;


            $data = Appointment::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'room_id' => $uniqid,
                'patient_type' => $request->patient_type,
                'patient_symptoms' => $request->patient_symptoms,
                'vital_signs' => $vital_signs,
                'visit_date' => $request->visit_date,
                // 'slot_id' => $slot_id,
                'schedule_id' => $slot_id,
                'isbooked' => 1,
                'isApproved' => $is_approved,
            ]);
            $doctor = User::find($data['doctor_id']);
            $patient = User::find($data['patient_id']);
            // dd($doctor);
            $slot = DoctorSchedule::find($slot_id);


            if (Auth::user()->hasRole('user')) {

                $moderators = User::with('roles')
                    ->whereHas('roles', function ($q) {
                        $q->where('slug', '=', 'admin');
                    })
                    ->where('is_active', 1)
                    ->where('is_deleted', 0)
                    ->get();

                foreach ($moderators as $data) {

                    $mail_body = '<html>
                            <h3>Dear ' . $data->name . ',</h1>                            
                            <h3>A patient named ' . $patient->name . ', Phone: ' . $patient->phone . ' has been requested to get an appointment with ' . $doctor->name . '</h3>
                            <h3><a href="https://virtualdr.com.bd/login">Click Here</a> to Login your Dashboard and Approve the request.</h3>
                            </html>';

                    $toModerator = $data->email;

                    Mail::send([], [], function ($message) use ($mail_body, $toModerator) {
                        $message->from('contact@virtualdr.com.bd', 'Virtual Doctor');
                        $message->to($toModerator);
                        $message->subject('New Appointment Request!');
                        $message->setBody(
                            $mail_body,
                            'text/html'
                        );
                    });
                }
                sendSMSToRequest($doctor, $patient, $slot, $visit_date);
            } else {

                sendSMSToDoctorPatient($doctor, $patient, $slot, $visit_date);
            }


            Toastr::success('Appointment Setup Completed Successfully :)', 'success');
        }


        return redirect('dashboard');
    }


    public function rescheduleStore(Request $request)
    {
        date_default_timezone_set("Asia/Dhaka");
        $uniqid = Str::random(9);
        $pre_apt_id = $request->pre_appointId;

        $visit_date = $request->follow_up_visit_date;
        $patientinfo = Appointment::latest()
            ->where('patient_id', $request->patient_id)
            ->limit(1, 0)
            ->first();

        if (!empty($patientinfo)) {
            $exiting_doctor = $patientinfo->doctor_id;
        } else {
            $exiting_doctor = '';
        }

        if (Auth::user()->hasRole('user')) {
            $is_approved = 0;
        } else {
            $is_approved = 1;
        }

        // dd($exiting_doctor);
        if ($exiting_doctor) {

            if ($exiting_doctor == $request->doctor_id) {

                $slot_id = $request->slot_id;
                $data = Appointment::create([
                    'patient_id' => $request->patient_id,
                    'doctor_id' => $request->doctor_id,
                    'room_id' => $uniqid,
                    'patient_type' => $request->patient_type,
                    'patient_symptoms' => $request->patient_symptoms,
                    'visit_date' => $request->follow_up_visit_date,
                    'schedule_id' => $slot_id,
                    'isbooked' => 1,
                    'isApproved' => $is_approved,
                ]);

                $doctor = User::find($data['doctor_id']);
                $patient = User::find($data['patient_id']);
                // dd($doctor);
                $slot = DoctorSchedule::find($slot_id);
                //dd($pre_apt_id);
                Appointment::where('id', $pre_apt_id)->update(['isScheduled' => 1]);

                if (Auth::user()->hasRole('user')) {

                    $moderators = User::with('roles')
                        ->whereHas('roles', function ($q) {
                            $q->where('slug', '=', 'admin');
                        })
                        ->where('is_active', 1)
                        ->where('is_deleted', 0)
                        ->get();

                    foreach ($moderators as $data) {

                        $mail_body = '<html>
                            <h3>Dear ' . $data->name . ',</h1>                            
                            <h3>A patient named ' . $patient->name . ', Phone: ' . $patient->phone . ' has been requested to get an appointment with ' . $doctor->name . '</h3>
                            <h3><a href="https://virtualdr.com.bd/login">Click Here</a> to Login your Dashboard and Approve the request.</h3>
                            </html>';

                        $toModerator = $data->email;

                        Mail::send([], [], function ($message) use ($mail_body, $toModerator) {
                            $message->from('contact@virtualdr.com.bd', 'Virtual Doctor');
                            $message->to($toModerator);
                            $message->subject('New Appointment Request!');
                            $message->setBody(
                                $mail_body,
                                'text/html'
                            );
                        });
                    }
                    sendSMSToRequest($doctor, $patient, $slot, $visit_date);
                } else {

                    sendSMSToDoctorPatient($doctor, $patient, $slot, $visit_date);
                }



                Toastr::success('Appointment Rescheduled Successfully :)', 'success');
            }
        } else {

            if ($request->start_time && $request->end_time) {
                $slotInfo = DoctorSchedule::create([
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'created_at' => new DateTime()
                ]);

                $slotid = $slotInfo->id;
            }


            $slot_id = $request->slot_id;


            $data = Appointment::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'room_id' => $uniqid,
                'patient_type' => $request->patient_type,
                'patient_symptoms' => $request->patient_symptoms,
                'visit_date' => $request->follow_up_visit_date,
                'schedule_id' => $slot_id,
                'isbooked' => 1,
                'isApproved' => $is_approved,
            ]);
            $doctor = User::find($data['doctor_id']);
            $patient = User::find($data['patient_id']);
            // dd($doctor);
            $slot = DoctorSchedule::find($slot_id);

            if (Auth::user()->hasRole('user')) {

                $moderators = User::with('roles')
                    ->whereHas('roles', function ($q) {
                        $q->where('slug', '=', 'admin');
                    })
                    ->where('is_active', 1)
                    ->where('is_deleted', 0)
                    ->get();

                foreach ($moderators as $data) {

                    $mail_body = '<html>
                            <h3>Dear ' . $data->name . ',</h1>                            
                            <h3>A patient named ' . $patient->name . ', Phone: ' . $patient->phone . ' has been requested to get an appointment with ' . $doctor->name . '</h3>
                            <h3><a href="https://virtualdr.com.bd/login">Click Here</a> to Login your Dashboard and Approve the request.</h3>
                            </html>';

                    $toModerator = $data->email;

                    Mail::send([], [], function ($message) use ($mail_body, $toModerator) {
                        $message->from('contact@virtualdr.com.bd', 'Virtual Doctor');
                        $message->to($toModerator);
                        $message->subject('New Appointment Request!');
                        $message->setBody(
                            $mail_body,
                            'text/html'
                        );
                    });
                }
                sendSMSToRequest($doctor, $patient, $slot, $visit_date);
            } else {

                sendSMSToDoctorPatient($doctor, $patient, $slot, $visit_date);
            }


            Toastr::success('Appointment Rescheduled Successfully :)', 'success');
        }
        return redirect('dashboard');
    }


    public function show(Appointment $appointment)
    {
        //
    }


    public function edit(Appointment $appointment)
    {
        $sloti_id = array();

        $patientinfo = Appointment::where('doctor_id', $appointment->doctor_id)
            ->whereDate('visit_date', $appointment->visit_date)
            ->get();
        foreach ($patientinfo as $value) {
            if ($value->schedule_id != $appointment->schedule_id) {
                $sloti_id[] = $value->schedule_id;
            }
        }


        // $sloti_id[] = $appointment->slot_id;

        $slot = DoctorSchedule::latest()->whereNotIn('id', $sloti_id)->get();


        $doctor = User::with('roles')
            ->whereHas('roles', function ($q) {
                $q->where('slug', '=', 'power-user');
            })
            ->orderBy('created_at', 'desc')
            ->where('is_deleted', '0')->get();
        return view('admin.edit_appointment', compact('appointment', 'doctor', 'slot'));
    }


    public function update(Request $request, Appointment $appointment)
    {
        date_default_timezone_set("Asia/Dhaka");
        $visit_date = $request->visit_date;
        $appoint_info = Appointment::find($appointment->id);
        $isApproved = $appoint_info->isApproved;
        $slot_id = $appoint_info->slot_id;

        
        $appointment->patient_id = $request->patient_id;
        $appointment->doctor_id = $request->doctor_id;
        $appointment->patient_symptoms = $request->patient_symptoms;
        $appointment->visit_date = $request->visit_date;
        $appointment->schedule_id = $request->slot_id;
        $appointment->isApproved = $request->is_approved;
        $appointment->save();


        $slot = DoctorSchedule::find($request->slot_id);
        $doctor = User::find($request->patient_id);
        $patient = User::find($request->doctor_id);


        if ($isApproved == 0 && $appointment->isApproved == 1) {
            sendSMSToDoctorPatient($doctor, $patient, $slot, $visit_date);
        } else if ($slot_id != $appointment->slot_id && $isApproved == 1 && $appointment->isApproved == 1) {
            sendSMSToDoctorPatient($doctor, $patient, $slot, $visit_date);
        }

        Toastr::success('Appointment Updated Successfully :)', 'success');
        return redirect('dashboard');
    }

    public function prescription_edit($id)
    {
        $appointment = Appointment::find($id);
        return view('admin.edit_prescription', compact('appointment'));
    }

    public function prescription_update(Request $request, $id)
    {
        $appointment = Appointment::find($id);
        $appointment->where('id', $id)->update(array(
            'prescribe_medicines' => $request->prescribe_medicines
        ));
        Toastr::success('Appointment Updated successfully.');
        return redirect('appointments');
    }

    public function destroy($id)
    {
        $appointment = Appointment::find($id);
        $appointment->where('id', $id)->update(array('isbooked' => '0'));
        Toastr::success('Appointment Cancelled successfully!');
        return redirect()->back();
    }


    public function doctorAvailbleSlot($id, $doc_id, $visit_date)
    {
        $sloti_id = array();

        $patientinfo = Appointment::where('doctor_id', $doc_id)
            ->whereDate('visit_date', $visit_date)
            ->get();

        foreach ($patientinfo as $value) {
            $sloti_id[] = $value->schedule_id;
        }

        if (!empty($sloti_id)) {
            // dd($sloti_id);
            $slot = DoctorSchedule::latest()
                ->whereNotIn('id', $sloti_id)
                ->where('doctor_id', $doc_id)
                ->get();
        } else {
            // dd($doc_id);
            $slot = DoctorSchedule::where('doctor_id', $doc_id)->get();
        }

        // $slot = DoctorSchedule::latest()->whereNotIn('id', $sloti_id)->get();

        return view('admin.available_slot', compact('slot'));
    }


    public function prescriptionDownload($id)
    {

        $appointment = Appointment::find($id);
        $vital_signs = $appointment->vital_signs;

        $vitalsigns = explode(',', $vital_signs);
        $vital_weight = 0;
        foreach ($vitalsigns as $vluevital) {
            $weight = substr($vluevital, 0, 6);

            if ($weight === 'Weight') {
                $vital_weight = $vluevital;
            }
        }

        $patient_weight = substr($vital_weight, 7);

        // return view('admin.prescription_form', compact('appointment','patient_weight'));
        $pdf = PDF::loadView('admin.prescription_form', compact('appointment', 'patient_weight'));

        return $pdf->download('prescription.pdf');
    }
    public function prescriptionPreview($id)
    {

        $appointment = Appointment::find($id);
        $vital_signs = $appointment->vital_signs;

        $vitalsigns = explode(',', $vital_signs);
        $vital_weight = 0;
        foreach ($vitalsigns as $vluevital) {
            $weight = substr($vluevital, 0, 6);

            if ($weight === 'Weight') {
                $vital_weight = $vluevital;
            }
        }

        $patient_weight = substr($vital_weight, 7);

        return view('admin.prescription_form', compact('appointment', 'patient_weight'));
        // $pdf = PDF::loadView('admin.prescription_form', compact('appointment', 'patient_weight'));

        // return $pdf->download('prescription.pdf');
    }
}
