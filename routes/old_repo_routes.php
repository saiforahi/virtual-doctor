<?php
                                                                                                                                                                                                                                                                           
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FeaturesController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\DayController; 
use App\Http\Controllers\SettingsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Start File Upload
Route::get('/file','FileController@index')->name('viewfile');
Route::get('/file/upload','FileController@create')->name('formfile');
Route::post('/file/upload','FileController@store')->name('uploadfile');
Route::delete('/file/{id}','FileController@destroy')->name('deletefile');
Route::get('/file/download/{id}','FileController@show')->name('downloadfile');
Route::get('/file/email/{id}','FileController@edit')->name('emailfile');
Route::post('/file/dropzone','FileController@dropzone')->name('dropzone');
// End File Upload

//Clear route cache:
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return 'Routes cache cleared';
});

//Clear config cache:
Route::get('/config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return 'Config cache cleared';
});

// Clear application cache:
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return 'Application cache cleared';
});

// Clear view cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return 'View cache cleared';
});

Route::get('/logout', function () {
    Session::flush();
    return redirect('/');
});
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/patient-logout', function(){
    Session::flush();
    return redirect('/patient-login');
});

// Route::post('/send_session_data', function () {
//     return ['status'=>'success'];
//     // dd("session data routs worked.");
// });


Route::get('/', [\App\Http\Controllers\HomeController::class,'index'])->name('home');
Route::get('/home', [\App\Http\Controllers\HomeController::class,'index'])->name('home');
Route::get('/patient-login', [\App\Http\Controllers\HomeController::class,'patientLogin'])->name('patient-login');

Route::get('checkout/{id?}/{schedule_id?}', [\App\Http\Controllers\HomeController::class,'checkout'])->name('checkout');
Route::get('search-doctor/{kw?}/{loc?}', [\App\Http\Controllers\HomeController::class,'searchDoctor'])->name('search-doctor');
Route::get('doctor-profile/{id?}', [\App\Http\Controllers\HomeController::class,'doctorProfile'])->name('doctor-profile');
Route::get('book-appoinment/{id?}', [\App\Http\Controllers\HomeController::class,'bookAppoinment'])->name('book-appoinment');
Route::get('new-patient-register', [\App\Http\Controllers\RegisterController::class,'new_patient_register'])->name('new-patient-register');

Route::post('new_patient_registration', [\App\Http\Controllers\RegisterController::class,'new_patient_store'])->name('new_patient_registration');
Route::post('registration', [\App\Http\Controllers\RegisterController::class,'store'])->name('registration');

Route::get('booking-success', [\App\Http\Controllers\HomeController::class,'bookingSuccess'])->name('booking-success');


Route::group(['middleware' =>  ['role:admin|moderator|doctor|patient']], function() { 
    Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard')->middleware('ensure_profile_is_updated');
    Route::resource('users', UserController::class);    
    Route::resource('appointments', \App\Http\Controllers\AppointmentController::class);
    Route::resource('device', \App\Http\Controllers\api\DeviceController::class);
    Route::get('reschedule_appointment/{id}',[\App\Http\Controllers\AppointmentController::class,'reschedule_appointment'])->name('reschedule_appointment');
    Route::post('reschedule_store',[\App\Http\Controllers\AppointmentController::class,'rescheduleStore'])->name('reschedule_store');
    // if logged in portal
    Route::post('store-appointment',[\App\Http\Controllers\AppointmentController::class,'AppointmentStore'])->name('store-appointment');
 
    Route::get('set_appointment/{id}',[\App\Http\Controllers\AppointmentController::class,'reschedule_appointment'])->name('set_appointment'); 
    Route::get('prescription_edit/{id}', [\App\Http\Controllers\AppointmentController::class,'prescription_edit'])->name('prescription_edit');
    Route::post('prescription_update/{id}',[\App\Http\Controllers\AppointmentController::class,'prescription_update'])->name('prescription_update');
    Route::post('approve_user/{id}', [UserController::class,'approve_user'])->name('approve_user');
    Route::post('pending_user/{id}', [UserController::class,'pending_user'])->name('pending_user');
    Route::put('doctor-degree-update',[UserController::class,'updateDegree'])->name('doctor-degree-update');
    Route::put('doctor-schedule',[SettingsController::class,'doctorSchedule'])->name('doctor-schedule');
    Route::put('doctor-schedule-update',[UserController::class,'doctorSchedule'])->name('doctor-schedule-update');
    Route::get('settings/delete_schedule/{scdid}', [SettingsController::class,'deleteSchedule'])->name('delete_schedule');
    Route::get('users/{id}/edit/delete_scheduled/{scdid}', [UserController::class,'deleteSchedule'])->name('delete_scheduled');
    
    Route::put('doctor-personalinfo-update',[UserController::class,'doctorPersonalInfoUpdate'])->name('doctor-personalinfo-update');

	Route::get('settings', [SettingsController::class,'index'])->name('settings');
	Route::put('profile-update',[SettingsController::class,'updateProfile'])->name('profile-update');
	Route::put('degree-update',[SettingsController::class,'updateDegree'])->name('degree-update');
	Route::put('doctor-personal-info-update',[SettingsController::class,'doctorPersonalInfoUpdate'])->name('doctor-personal-info-update');
    Route::put('password-update',[SettingsController::class,'updatePassword'])->name('password-update');
    Route::get('message',[\App\Http\Controllers\MessageController::class,'index'])->name('message');
    Route::post('send_message', [\App\Http\Controllers\MessageController::class,'message'])->name('send_message');
    Route::get('chat/{id}/{room}/{name}', [\App\Http\Controllers\LiveChatController::class,'chat'])->name('chat');
    Route::post('send_session_data', [\App\Http\Controllers\LiveChatController::class,'send_session_data'])->name('send_session_data');
    // Route::post('send_session_data', function (Request $request) {
    //     return response()->json(['status' => $request->all()]);
    //     // dd("session data routs worked.");
    // });

    Route::get('patient_profile/{id}', [\App\Http\Controllers\ProfileController::class,'patient_profile'])->name('patient_profile');
    
    
    Route::get('/file',[FileController::class,'index'])->name('viewfile');
    Route::get('/file/upload',[FileController::class,'create'])->name('formfile');
    Route::post('/file/upload/{id}',[FileController::class,'store'])->name('uploadfile');
    Route::delete('/file/{id}',[FileController::class,'destroy'])->name('deletefile');
    Route::get('/file/download/{id}',[FileController::class,'show'])->name('downloadfile');
    Route::get('/file/email/{id}',[FileController::class,'edit'])->name('emailfile');
    Route::post('/file/dropzone',[FileController::class,'dropzone'])->name('dropzone');

    Route::get('/file',[FileController::class,'viewFile'])->name('viewfile');
    Route::post('/file/upload',[FileController::class,'storeFile'])->name('storefile');
    Route::get('/file/download/{id}',[ProfileController::class,'fileDownload'])->name('downloadfile');
    
    Route::resource('clinic',ClinicController::class);
    Route::resource('features',FeaturesController::class);
    Route::resource('slot',SlotController::class);
    Route::resource('day',DayController::class);
    Route::resource('department',DepartmentController::class);
    Route::get('followup_patient', [DashboardController::class,'followup_patient_list'])->name('followup_patient');
    Route::get('new_patient', [DashboardController::class,'new_patient_list'])->name('new_patient');
    Route::get('all_patient', [DashboardController::class,'all_patient_list'])->name('all_patient');
    Route::get('emergency', [DashboardController::class,'emergency'])->name('emergency');

    Route::get('set_appointment/{id}/doctor_slot/{doc_id}/{visit_date}', [\App\Http\Controllers\AppointmentController::class,'doctorAvailbleSlot'])->name('doctor_slot');

    Route::get('prescription_download/{id}',[\App\Http\Controllers\AppointmentController::class,'prescriptionDownload'])->name('prescription_download');
    Route::get('prescription_form/{id}',[\App\Http\Controllers\AppointmentController::class,'prescriptionPreview'])->name('prescription_form');

});
// SSLCOMMERZ Start
Route::get('/example1', [\App\Http\Controllers\SslCommerzPaymentController::class,'exampleEasyCheckout']);
Route::get('/example2', [\App\Http\Controllers\SslCommerzPaymentController::class,'exampleHostedCheckout']);

Route::post('/pay', [\App\Http\Controllers\SslCommerzPaymentController::class,'index'])->name('pay');
Route::post('/pay1', [\App\Http\Controllers\SslCommerzPaymentController::class,'index1'])->name('pay1');
Route::post('/pay-via-ajax', [\App\Http\Controllers\SslCommerzPaymentController::class,'payViaAjax']);

Route::post('/success', [\App\Http\Controllers\SslCommerzPaymentController::class,'success']);
Route::post('/fail', [\App\Http\Controllers\SslCommerzPaymentController::class,'fail']);
Route::post('/cancel', [\App\Http\Controllers\SslCommerzPaymentController::class,'cancel']);

Route::post('/ipn', [\App\Http\Controllers\SslCommerzPaymentController::class,'ipn']);
//SSLCOMMERZ END
// Auth::routes();
