<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\CalonSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    protected function settings() {
        return [
            'client_id' => 13,
            'client_secret' => 'ddkAk5wt41FEcqmmdaj6y46EwXYDvCWAsF2TGQur',
            'api_key' => 'gr-87046633',
            'api_secret' => '9lwelkyxx5tuentuylf1wa8fca5ptwxx'
        ];
    }
    public function get_token() {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://apidev.payhost.io/api/oauth/token',[
            "grant_type"=>"client_credentials",
            "client_id"=>env('CLIENT_ID'),
            "client_secret"=>env('CLIENT_SECRET'),
            "scope"=>"*"
        ]);
        return $response->json();
    }

    public function get_method() {
        $token=$this->get_token();
        $signature_pattern = "GET:/api/v1/get_payment_method:{$token['access_token']}";
        $signature = hash_hmac('sha256', $signature_pattern,env('API_SECRET_NUSPAY'));
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'x-signature' => $signature,
            'x-api-key' => env('API_KEY_NUSPAY')
        ])->withToken($token['access_token'])
        ->get('http://apidev.payhost.io/api/v1/get_payment_method');
        return $response->json();
    }

    public function create_invoice(Request $request) {
        $data_leads = CalonSiswa::with('kelas_pilihan.courses')->where('kode_invoice',$request->kode_invoice)->first();
        $token=$this->get_token();
        $category_courses = $data_leads->kelas_pilihan->courses->category_courses ? $data_leads->kelas_pilihan->courses->category_courses->description : '';
        $generate_md5= md5("RH{$data_leads->kode_invoice}:{$data_leads->harga}");
        $reference_no = $data_leads->kode_invoice . rand(10000000,99999999);
        $signature_pattern = "POST:/api/v1/create:{$token['access_token']}:$generate_md5";
        $signature = hash_hmac('sha256', $signature_pattern,env('API_SECRET_NUSPAY'));
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'x-signature' => $signature,
            'x-api-key' =>env('API_KEY_NUSPAY')
        ])->withToken($token['access_token'])
        ->post('http://apidev.payhost.io//api/v1/create',[
            "reference_no"  =>$reference_no,
            "invoice_no" => "RH$data_leads->kode_invoice",
            "customer_name" => $data_leads->nama,
            "customer_phone" => $data_leads->nohp,
            "customer_email" => $data_leads->email,
            "customer_address" => $data_leads->alamat,
            "description"=>"Pembelian Kelas {$category_courses}  ",
            "amount" => $data_leads->harga ,
            "payment_method_code" => $request->payment_method_code,
            "expire_in" => 12
        ]);
        return $response->json();
    }

    public function pembayaran_success(Request $request) {
        $validator = \Validator::make($request->all(), [
            'reference_no'=>'required',
            'key'=>'required',
        ],[
            '*.required'=> ':attribute required'
        ])->setAttributeNames(['reference_no'=>'Reference Number',
            'key' => 'Key',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status_code'=>400,
                'message' => $validator->errors()->first()
            ],400);
        }

        if ($request->key !== 'a45630023243') {
            return response()->json([
                'status_code' => 403,
                'message' => 'Unauthorized',
            ],403);
        }
        return response()->json([
            'message' => 'Success'
        ],200);
        
    }
    
}
