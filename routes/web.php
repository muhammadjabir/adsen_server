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
    $data = \DB::table('failed_jobs')->orderBy('failed_at','desc')->get();
    $view = '<table border="1">';
    foreach ($data as $key => $value) {
        $view = $view . "<tr>
         <td>$value->payload</td>
        </tr>";
    }
    $view = $view . '</table>';
    return $view;

});
Route::get('/test/email',function(){
    $data = CalonSiswa::with(['kelas_pilihan.courses'])->find(3);
    return view('email',compact('data'));
});

Route::get('/test/invoice',function(){
    $data = CalonSiswa::findOrFail(15);
    return view('invoice',compact('data'));
});

// Route::get('/',function(){
//     return redirect('/jadwal');
// });
Route::get('/{any}',function(){
    return view('index');
})->where('any', '.*')->name('home.index');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

