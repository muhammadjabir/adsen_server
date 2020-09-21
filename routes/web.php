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
    // $user = \App\User::findOrFail(1);
    // $user->password = \Hash::make(123456);
    // $user->save();
    // $signature_pattern = "GET:/api/v1/get_payment_method:eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImEyYzIwN2QwOTc5MDIwNzhlNTY0MDVlODg5ZTUyYzdkOTkxYThlNjFhZjZjY2M1NTNhMzkxZjJjNGI2NzNhNGNjODU3MDM4ODVlNmRiNDg1In0.eyJhdWQiOiIxMyIsImp0aSI6ImEyYzIwN2QwOTc5MDIwNzhlNTY0MDVlODg5ZTUyYzdkOTkxYThlNjFhZjZjY2M1NTNhMzkxZjJjNGI2NzNhNGNjODU3MDM4ODVlNmRiNDg1IiwiaWF0IjoxNjAwNTAyNDMzLCJuYmYiOjE2MDA1MDI0MzMsImV4cCI6MTYwMDY3NTIzMywic3ViIjoiIiwic2NvcGVzIjpbIioiXX0.dHAgi3QFkl0dPo0GZRVv0efEfFCHTpKnTsZyTJKSK_4xhX673MNykRdeXzQENe_m6Sz3zwXixxuzGdh2yOH9wlNQn-SK_2p1VmsENKpVsqrtDDnG86ls8QU9kVNdSR1Y6HETvoWU8OPpFuV3nf6-VMhh3kiSTicsHSaxWmXAdMvDwGHh2J7_k8HnJvBf9wBNnBepwKJsO-ikquiIsaHu_1SpH7qGmk2pxj0NX3lwHsMZ9ZCJYdN-PtW-dMx3_rZ2vK4Xb9w-riTAdrVIRms_BNgHyn0cDx9B_39KffcB8pw0S49YOF3u2fP1Go8VpRvPpButHiKBZScljv3-8bHMQZswCWXnvEaUpGG97Jxj9pw4lszSSZoDQYglCBRVaIzDaz88Sarj6CKTF0x3w0s_bFVIeQnYgr9IIMbA7kjQEATdN6v47FbUWpAr98II4h06-urDpIdX0DAU3YVpbY5Zck8gc88dg5NYR_QtnD9FQCigB3XeyyAeTdjdx7asXfx-PddjoiT-slrRga6mbhMFGxAAZdnOWTlDwl5GgH0H5WJlh1YC8VkrDcNQZmWCRfEJlpXB7OKdQPWuL8wrboEOa7rZOCgYndtMIX3gveMBp0rfE7F0TNWpYXdkz2rPpuHd1iVbBaM8Le7j5MdDrAOXJwnHUbgA0MbvD2ibm6cd73E";
    // $signature = hash_hmac('sha256', $signature_pattern,'9lwelkyxx5tuentuylf1wa8fca5ptwxx');
    // // return $signature;
    // // $response = Http::withHeaders([
    // //     'Content-Type' => 'application/json',
    // // ])->post('http://apidev.payhost.io/api/oauth/token',[
    // //     "grant_type"=>"client_credentials",
    // //     "client_id"=>"13",
    // //     "client_secret"=>"ddkAk5wt41FEcqmmdaj6y46EwXYDvCWAsF2TGQur",
    // //     "scope"=>"*"
    // // ]);
    // $response = Http::withHeaders([
    //     'Content-Type' => 'application/json',
    //     'x-signature' => $signature,
    //     'x-api-key' => 'gr-87046633'
    // ])->withToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImEyYzIwN2QwOTc5MDIwNzhlNTY0MDVlODg5ZTUyYzdkOTkxYThlNjFhZjZjY2M1NTNhMzkxZjJjNGI2NzNhNGNjODU3MDM4ODVlNmRiNDg1In0.eyJhdWQiOiIxMyIsImp0aSI6ImEyYzIwN2QwOTc5MDIwNzhlNTY0MDVlODg5ZTUyYzdkOTkxYThlNjFhZjZjY2M1NTNhMzkxZjJjNGI2NzNhNGNjODU3MDM4ODVlNmRiNDg1IiwiaWF0IjoxNjAwNTAyNDMzLCJuYmYiOjE2MDA1MDI0MzMsImV4cCI6MTYwMDY3NTIzMywic3ViIjoiIiwic2NvcGVzIjpbIioiXX0.dHAgi3QFkl0dPo0GZRVv0efEfFCHTpKnTsZyTJKSK_4xhX673MNykRdeXzQENe_m6Sz3zwXixxuzGdh2yOH9wlNQn-SK_2p1VmsENKpVsqrtDDnG86ls8QU9kVNdSR1Y6HETvoWU8OPpFuV3nf6-VMhh3kiSTicsHSaxWmXAdMvDwGHh2J7_k8HnJvBf9wBNnBepwKJsO-ikquiIsaHu_1SpH7qGmk2pxj0NX3lwHsMZ9ZCJYdN-PtW-dMx3_rZ2vK4Xb9w-riTAdrVIRms_BNgHyn0cDx9B_39KffcB8pw0S49YOF3u2fP1Go8VpRvPpButHiKBZScljv3-8bHMQZswCWXnvEaUpGG97Jxj9pw4lszSSZoDQYglCBRVaIzDaz88Sarj6CKTF0x3w0s_bFVIeQnYgr9IIMbA7kjQEATdN6v47FbUWpAr98II4h06-urDpIdX0DAU3YVpbY5Zck8gc88dg5NYR_QtnD9FQCigB3XeyyAeTdjdx7asXfx-PddjoiT-slrRga6mbhMFGxAAZdnOWTlDwl5GgH0H5WJlh1YC8VkrDcNQZmWCRfEJlpXB7OKdQPWuL8wrboEOa7rZOCgYndtMIX3gveMBp0rfE7F0TNWpYXdkz2rPpuHd1iVbBaM8Le7j5MdDrAOXJwnHUbgA0MbvD2ibm6cd73E')
    // ->get('http://apidev.payhost.io/api/v1/get_payment_method');
    // return $response->json();
    return env('CLIENT_ID');

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

