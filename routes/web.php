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
use Illuminate\Support\Facades\Http;
Route::get('/test',function(){
    $data = CalonSiswa::with('kelas_pilihan.trainer')->where('kode_invoice','202009002')->first();
    
    $data = [
        'nama' => $data->nama,
        'hari' => $data->kelas_pilihan->hari_masuk,
        'email' => $data->email,
        'start_class' => $data->kelas_pilihan->start_class->format('d-m-Y'),
        'end_class' => $data->kelas_pilihan->end_class->format('d-m-Y'),
        'jam_masuk' => $data->kelas_pilihan->jam_masuk,
        'jam_pulang' => $data->kelas_pilihan->jam_pulang,
        'trainer' => $data->kelas_pilihan->trainer->name
    ];
    return view('akun_email',['data'=>$data]);

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
})->where('any', '.*')->name('home.index');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

