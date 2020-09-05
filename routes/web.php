<?php

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

use App\Mail\SendInvoiceTemplate;
use App\Models\CalonSiswa;
use App\Models\Kelas;

Route::get('/test',function(){
    $user = \App\User::findOrFail(1);
    $user->password = \Hash::make(123456);
    $user->save();

});
Route::get('/test/email',function(){
    $data = CalonSiswa::with(['kelas_pilihan.courses'])->find(3);
    return view('email',compact('data'));
});
Route::get('/',function(){
    return redirect('/jadwal');
});
Route::get('/{any}',function(){
    return view('index');
})->where('any', '.*');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

