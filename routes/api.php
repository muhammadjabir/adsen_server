<?php

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


Route::middleware(['auth:api'])->group(function () {
Route::get('/schedule','Schedule\ScheduleController@index');
Route::get('/schedule/{id}/absen','Schedule\ScheduleController@absen');
Route::post('/schedule/{id}/absen','Schedule\ScheduleController@absen_student');

Route::get('/role-management','Role\RoleManagementController@index');
Route::post('/role-management','Role\RoleManagementController@store');
Route::get('/role-management/{id}/edit','Role\RoleManagementController@edit');
Route::post('/courses/status','Courses\CoursesController@ChangeStatus');
Route::post('/class-management/status','Kelas\KelasController@ChangeStatus');
Route::get('/students/class', 'Students\StudentsController@kelas');
Route::resource('masterdata', 'Masterdata\MasterdataController');
Route::resource('menu', 'Menu\MenuController');
Route::resource('users', 'Users\UsersController');
Route::resource('trainers', 'Users\TrainersController');
Route::resource('class-management', 'Kelas\KelasController');
Route::resource('courses', 'Courses\CoursesController');

Route::resource('students', 'Students\StudentsController');

});


Route::get('test',function(){
    // return \Carbon\Carbon::now()->daysInMonth;
     $tgl = \Carbon\Carbon::setLocale('id');
    return \Carbon\Carbon::parse('2020-01-09')->format('l');
});
