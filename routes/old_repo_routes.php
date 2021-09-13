<?php
                                                                                                                                                                                                                                                                           
use Illuminate\Http\Request;
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
    Route::get('dashboard', [\App\http\Controllers\Admin\DashboardController::class,'index'])->name('dashboard');
    Route::resource('users', \App\http\Controllers\UserController::class);    
    Route::resource('appointments', \App\http\Controllers\AppointmentController::class);  
    Route::get('reschedule_appointment/{id}',[\App\http\Controllers\AppointmentController::class,'reschedule_appointment'])->name('reschedule_appointment');
    Route::post('reschedule_store',[\App\http\Controllers\AppointmentController::class,'rescheduleStore'])->name('reschedule_store');
    // if logged in portal
    Route::post('store-appointment',[\App\http\Controllers\AppointmentController::class,'AppointmentStore'])->name('store-appointment');
 
    Route::get('set_appointment/{id}',[\App\http\Controllers\AppointmentController::class,'reschedule_appointment'])->name('set_appointment'); 
    Route::get('prescription_edit/{id}', [\App\http\Controllers\AppointmentController::class,'prescription_edit'])->name('prescription_edit');
    Route::post('prescription_update/{id}',[\App\http\Controllers\AppointmentController::class,'prescription_update'])->name('prescription_update');
    Route::post('approve_user/{id}', [\App\http\Controllers\UserController::class,'approve_user'])->name('approve_user');
    Route::post('pending_user/{id}', [\App\http\Controllers\UserController::class,'pending_user'])->name('pending_user');
    Route::put('doctor-degree-update',[\App\http\Controllers\UserController::class,'updateDegree'])->name('doctor-degree-update');
    Route::put('doctor-schedule',[\App\http\Controllers\SettingsController::class,'doctorSchedule'])->name('doctor-schedule');
    Route::put('doctor-schedule-update',[\App\http\Controllers\UserController::class,'doctorSchedule'])->name('doctor-schedule-update');
    Route::get('settings/delete_schedule/{scdid}', [\App\http\Controllers\SettingsController::class,'deleteSchedule'])->name('delete_schedule');
    Route::get('users/{id}/edit/delete_scheduled/{scdid}', [\App\http\Controllers\UserController::class,'deleteSchedule'])->name('delete_scheduled');
    
    Route::put('doctor-personalinfo-update','UserController@doctorPersonalInfoUpdate')->name('doctor-personalinfo-update');

	Route::get('settings', 'SettingsController@index')->name('settings');
	Route::put('profile-update','SettingsController@updateProfile')->name('profile-update');
	Route::put('degree-update','SettingsController@updateDegree')->name('degree-update');
	Route::put('doctor-personal-info-update','SettingsController@doctorPersonalInfoUpdate')->name('doctor-personal-info-update');
    Route::put('password-update','SettingsController@updatePassword')->name('password-update');
    Route::get('message', 'MessageController@index')->name('message');
    Route::post('send_message', 'MessageController@message')->name('send_message');
    Route::get('chat/{id}/{room}/{name}', 'LiveChatController@chat')->name('chat');
    Route::post('send_session_data', 'LiveChatController@send_session_data')->name('send_session_data');
    // Route::post('send_session_data', function (Request $request) {
    //     return response()->json(['status' => $request->all()]);
    //     // dd("session data routs worked.");
    // });

    Route::get('patient_profile/{id}', 'ProfileController@patient_profile')->name('patient_profile');
    
    
    Route::get('/file','FileController@index')->name('viewfile');
    Route::get('/file/upload','FileController@create')->name('formfile');
    Route::post('/file/upload/{id}','FileController@store')->name('uploadfile');
    Route::delete('/file/{id}','FileController@destroy')->name('deletefile');
    Route::get('/file/download/{id}','FileController@show')->name('downloadfile');
    Route::get('/file/email/{id}','FileController@edit')->name('emailfile');
    Route::post('/file/dropzone','FileController@dropzone')->name('dropzone');

    Route::get('/file','FileController@viewFile')->name('viewfile');
    Route::post('/file/upload','FileController@storeFile')->name('storefile');
    Route::get('/file/download/{id}','ProfileController@fileDownload')->name('downloadfile');
    // hasibul
    
    Route::resource('clinic','ClinicController');
    Route::resource('features','FeaturesController');
    Route::resource('slot','SlotController');
    Route::resource('day','DayController');
    Route::resource('department','DepartmentController');
    Route::get('followup_patient', 'Admin\DashboardController@followup_patient_list')->name('followup_patient');
    Route::get('new_patient', 'Admin\DashboardController@new_patient_list')->name('new_patient');
    Route::get('all_patient', 'Admin\DashboardController@all_patient_list')->name('all_patient');
    Route::get('emergency', 'Admin\DashboardController@emergency')->name('emergency');

    Route::get('set_appointment/{id}/doctor_slot/{doc_id}/{visit_date}', 'AppointmentController@doctorAvailbleSlot')->name('doctor_slot');

    Route::get('prescription_download/{id}', 'AppointmentController@prescriptionDownload')->name('prescription_download');
    Route::get('prescription_form/{id}', 'AppointmentController@prescriptionPreview')->name('prescription_form');

});
// SSLCOMMERZ Start
Route::get('/example1', [\App\http\Controllers\SslCommerzPaymentController::class,'exampleEasyCheckout']);
Route::get('/example2', [\App\http\Controllers\SslCommerzPaymentController::class,'exampleHostedCheckout']);

Route::post('/pay', [\App\http\Controllers\SslCommerzPaymentController::class,'index'])->name('pay');
Route::post('/pay1', [\App\http\Controllers\SslCommerzPaymentController::class,'index1'])->name('pay1');
Route::post('/pay-via-ajax', [\App\http\Controllers\SslCommerzPaymentController::class,'payViaAjax']);

Route::post('/success', [\App\http\Controllers\SslCommerzPaymentController::class,'success']);
Route::post('/fail', [\App\http\Controllers\SslCommerzPaymentController::class,'fail']);
Route::post('/cancel', [\App\http\Controllers\SslCommerzPaymentController::class,'cancel']);

Route::post('/ipn', [\App\http\Controllers\SslCommerzPaymentController::class,'ipn']);
//SSLCOMMERZ END
// Auth::routes();
