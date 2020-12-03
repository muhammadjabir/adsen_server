<?php

use Faker\Provider\ar_SA\Payment;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/me','AuthJWT\AuthController@me');
Route::post('/register', 'AuthJWT\AuthController@register');
Route::post('/login', 'AuthJWT\AuthController@login');
Route::post('/logout', 'AuthJWT\AuthController@logout');
Route::post('/edit-profile','AuthJWT\AuthController@EditProfile');
Route::get('/jadwal','Schedule\ScheduleController@api_schedule');
Route::get('/class-register','openApi\ClassApi@index');
Route::post('/register-calon','openApi\ClassApi@create');
Route::post('/payment/create','Payment\PaymentController@create_invoice');
Route::get('/payment/method','Payment\PaymentController@get_method');
Route::post('/payment/courses/{invoice}','Payment\PaymentController@index');
Route::post('/v1/payment/courses', 'Payment\PaymentController@pembayaran_success');
Route::get('/loker/redhunter', 'openApi\ClassApi@loker');


Route::middleware(['auth:api'])->group(function () {
    Route::get('/dashboard-student','Dashboard\DashboardController@student');
    Route::get('/students/trash', 'Trash\TrashController@student');
    Route::get('/courses/trash', 'Trash\TrashController@courses');
    Route::get('/users/trash', 'Trash\TrashController@user');
    Route::get('/class-management/trash', 'Trash\TrashController@kelas');

Route::delete('/students/{id}/trash', 'Trash\TrashController@student_delete');
Route::delete('/courses/{id}/trash', 'Trash\TrashController@courses_delete');
Route::delete('/users/{id}/trash', 'Trash\TrashController@user_delete');
Route::delete('/class-management/{id}/trash', 'Trash\TrashController@kelas_delete');

Route::get('/schedule','Schedule\ScheduleController@index');
Route::post('/followup','Resepcionist\ResepcionistController@followup');
Route::get('/get-kelas','Resepcionist\ResepcionistController@getKelas');
Route::get('/schedule/{id}/absen','Schedule\ScheduleController@absen');
Route::post('/schedule/{id}/absen','Schedule\ScheduleController@absen_student');

Route::get('/role-management','Role\RoleManagementController@index');
Route::post('/role-management','Role\RoleManagementController@store');
Route::get('/role-management/{id}/edit','Role\RoleManagementController@edit');
Route::post('/courses/status','Courses\CoursesController@ChangeStatus');
Route::post('/loker/status','LokerController\LokerController@ChangeStatus');
Route::post('/class-management/status','Kelas\KelasController@ChangeStatus');
Route::get('/students/class', 'Students\StudentsController@kelas');
Route::get('/ganti-status', 'Resepcionist\ResepcionistController@changeStatus');
Route::post('/send-invoice/{id}/mail', 'Resepcionist\ResepcionistController@sendInvoice');
Route::get('/student-courses', 'Video\VideoController@student_courses');
Route::get('/student-courses/video/{slug}', 'Video\VideoController@student_video');
Route::resource('masterdata', 'Masterdata\MasterdataController');
Route::resource('menu', 'Menu\MenuController');
Route::resource('users', 'Users\UsersController');
Route::resource('trainers', 'Users\TrainersController');
Route::resource('class-management', 'Kelas\KelasController');
Route::resource('courses', 'Courses\CoursesController');
Route::resource('leads', 'Resepcionist\ResepcionistController');
Route::resource('rekening', 'Rekening\RekeningController');
Route::resource('video', 'Video\VideoController');
Route::resource('students', 'Students\StudentsController');
Route::resource('loker', 'LokerController\LokerController');

});


Route::get('test',function(){
    // return \Carbon\Carbon::now()->daysInMonth;
     $tgl = \Carbon\Carbon::setLocale('id');
    return \Carbon\Carbon::parse('2020-01-09')->format('l');
});
