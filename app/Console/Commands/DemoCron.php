<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Slot;
use Carbon\Carbon;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info('working cron on cpanel!');
        #sendSMSToRequest(15,10,10,2020-07-29);
        // $data = Appointment::find(9);
        // $doctor = User::find(4);
        // $patient = User::find(5);
        // $slot = Slot::find(10);
        #sendSMSToDoctorPatient($doctor,$patient,$slot,$data->visit_date);
        // \Log::info($data->visit_date);
        $apt_noti = '';
        $apt_noti =  Appointment::join('doctor_schedules', 'appointments.schedule_id', '=', 'doctor_schedules.id')
            ->where('isApproved',1)
            ->where('isServiced', 0)
            ->whereDate('visit_date', '=', Carbon::now())
            ->get();
        
        foreach ($apt_noti as $key) {
            //  \Log::info($key->slot_id);
            $timenow_get = Carbon::now(new \DateTimeZone('Asia/Dhaka'))->toTimeString();
            $timenow = Carbon::parse($timenow_get);
            $createdDate = Carbon::parse($key->start_time);
            $doctor = User::find($key->doctor_id);
            $patient = User::find($key->patient_id);

            $timenowstr = $timenow->format('H:i');
            $visitTimestr = $createdDate->subMinutes(15)->format('H:i');
            // $timenow->diff($createdDate)->format('H:i');
            // $timenow->subMinutes(15);
            // $elap_time = $timenow->diff($createdDate)->format('%H:%i');
            if($visitTimestr == $timenowstr){
                \Log::info($timenow);
                sendAlertSMSToDoctorPatient($doctor, $patient, $key->start_time, $key->end_time, $key->visit_date);
            }else{
                
                \Log::info($visitTimestr);
            }
            // if($timenow->diffInMinutes($createdDate) == 15){
            //     sendAlertSMSToDoctorPatient($doctor, $patient, $key->start_time, $key->end_time, $key->visit_date);
            // }else{
            //     \Log::info($timenow);
            // }
        }
        
     
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */
      
        $this->info('Demo:Cron Command Ran successfully!');
    }
}
