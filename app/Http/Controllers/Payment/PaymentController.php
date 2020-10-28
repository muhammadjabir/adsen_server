<?php

namespace App\Http\Controllers\Payment;

use App\Helpers\DataManipule;
use App\Http\Controllers\Controller;
use App\Http\Resources\CalonSiswa\CalonSiswa as CalonSiswaCalonSiswa;
use App\Jobs\SendAccountJobs;
use App\Models\CalonSiswa;
use App\Models\Courses;
use App\Models\Student;
use App\Models\Student_class;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;
class PaymentController extends Controller
{
    public function index($invoice) {
        $data_leads = CalonSiswa::where('encrypt_invoice',$invoice)->first();
        if ($data_leads && $data_leads->status_pendaftaran != 3) {
            if (!$data_leads->no_reference) {
                $category_courses = $data_leads->kelas_pilihan->courses->category_courses ? $data_leads->kelas_pilihan->courses->category_courses->description : '';
                if ($category_courses == 'Career Program') {
                    $id_category = $data_leads->kelas_pilihan->courses->category->id;
                    $courses = Courses::where('id_category',$id_category)->where('id','!=',$data_leads->kelas_pilihan->courses->id)->get();
                }else {
                    $courses = [$data_leads->kelas_pilihan->courses];
                }
                $message = [ 
                    'customer' => new CalonSiswaCalonSiswa($data_leads),
                    'courses' => $courses,
                    'category_courses' => $category_courses
                ];
                $status = 200;
            } else  {
                $message = $this->check_invoice($data_leads->no_reference);
                if ($message->successful()) {
                    $message = $message->json();
                    $status = 201;
                } else {
                    $message = [
                        'message' => 'Terjadi Kesalahan Gagal Check Invoice'
                    ];
                    $status = 400;
                }
            }
            
        } else {
            

            $message = [
                'message' => 'Terjadi Kesalahan Silakan Hubungi CS Kami'
            ];
            $status = 400;
        }

        return response()->json($message,$status);
        
    }

    // get bearer token nusapay
    public function get_token() {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://apidev.payhost.io/api/oauth/token',[
            "grant_type"=>"client_credentials",
            "client_id"=>env('CLIENT_ID'),
            "client_secret"=>env('CLIENT_SECRET'),
            "scope"=>"*"
        ]);
        return $response;
    }

    // mengambil method pembayaran ke nusapay
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

    // membuat invoice
    public function create_invoice(Request $request) {
        // CODE NUSPAY LAMA
        // $data_leads = CalonSiswa::with(['kelas_pilihan.courses'])->where('encrypt_invoice',$request->kode_invoice)->first();
        // $token=$this->get_token();
        // if (!$token->successful()) {
        //     return $token->json();
        // } else {
        //     $token = $token->json();
        // }
        // $category_courses = $data_leads->kelas_pilihan->courses->category_courses ? $data_leads->kelas_pilihan->courses->category_courses->description : '';
        // $generate_md5= md5("RH{$data_leads->kode_invoice}:{$data_leads->harga}");
        // $reference_no = $data_leads->kode_invoice . rand(10000000,99999999);
        // $signature_pattern = "POST:/api/v1/create:{$token['access_token']}:$generate_md5";
        // $headers = [
        //     'Content-Type' => 'application/json',
        //     'x-api-key' =>env('API_KEY_NUSPAY')
        // ];

        // $body = [
        //     "reference_no"  =>$reference_no,
        //     "invoice_no" => "RH$data_leads->kode_invoice",
        //     "customer_name" => $data_leads->nama,
        //     "customer_phone" => $data_leads->nohp,
        //     "customer_email" => $data_leads->email,
        //     "customer_address" => $data_leads->alamat,
        //     "description"=>"Pembelian Kelas {$category_courses}, {$data_leads->kelas_pilihan->courses->name}",
        //     "amount" => $data_leads->harga ,
        //     "payment_method_code" => $request->payment_method_code,
        //     "expire_in" => 12
        // ];
        // $url = 'http://apidev.payhost.io/api/v1/create';
        // $response = $this->request_post($headers,$body,$signature_pattern,$url,$token);
        // if ($response->successful()) {
        //     $data_leads->no_reference = $reference_no;
        //     $data_leads->save();
        // }
        // return $response->json();
    }

    // check invoice
    protected function check_invoice($request) {

        // nusapay lama
        // $token = $this->get_token();
        // $signature_pattern = "POST:/api/v1/check:{$token['access_token']}";
        // $headers = [
        //     'Content-Type' => 'application/json',
        //     'x-api-key' =>env('API_KEY_NUSPAY')
        // ];
        // $body = [
        //     "reference_no"  =>$reference_no,
        // ];
        // $url = 'http://apidev.payhost.io/api/v1/check';
        // $response = $this->request_post($headers,$body,$signature_pattern,$url,$token);

        $signature = hash_hmac('sha256',env('MERCHANT_CODE').":$request->reference_no",env('MERCHANT_SECRET'));
        $body = [
            "reference_no"  =>$request->reference_no,
            'merchant_code' => env('MERCHANT_CODE'),
            'signature' => $signature
        ];
        $response = Http::post('https://pga.growinc.dev/api/pay/check',$body);
        return $response;
    }

    // untuk request post ke nusapay dengan signature
    protected function request_post(array $headers,array $body,$signature_pattern,$url,$token) {
        $signature= hash_hmac('sha256', $signature_pattern,env('API_SECRET_NUSPAY'));
        $headers['x-signature'] = $signature;
        $response = Http::withHeaders($headers)->withToken($token['access_token'])
        ->post($url,$body);
        return $response;
    }

    public function pembayaran_success(Request $request) {
        $validator = \Validator::make($request->all(), [
            'reference_no'=>'required',
            'signature'=>'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status_code'=>400,
                'message' => $validator->errors()->first()
            ],400);
        }
        
        $error = 0;
        DB::beginTransaction();
        try {
            
            $data = $this->check_invoice($request);
            if ($data->successful()) {
            //    $data = $data->json();
                $no_invoice = explode("RH",$data->json()['data']['invoice_no']);
                $no_invoice = $no_invoice[1];
                $status = $data->json()['data']['paid_description'] == 'PAID' ? 1 : 0;
                $data = CalonSiswa::with('kelas_pilihan.trainer')->where('kode_invoice',$no_invoice)->first();
            } else {
                $error++;
                throw new \Exception('Data Tidak ditemukan');
            }
            $data->status_pendaftaran = $status;
            if ($status == 1) {
                $data->save();
                $cek_user = User::where('email',$data->email)->first();
                if ($cek_user) {
                    Student_class::firstOrCreate([
                        'id_kelas' => $data->kelas
                        ,'id_student' => $cek_user->student->id]);
                } else {
                    $user = new User;
                    $user->email = $data->email;
                    $user->name = $data->nama;
                    $user->password = \Hash::make('redhunter123');
                    $user->id_role = 42;
                    if($user->save()){
                        $siswa = new Student;
                        $siswa->name = $data->nama; 
                        $siswa->kelamin = $data->kelamin; 
                        $siswa->id_user = $user->id;
                        // $siswa->created_by = \Auth::user()->id;
                        if($siswa->save()){
                            Student_class::firstOrCreate([
                            'id_kelas' => $data->kelas
                            ,'id_student' => $siswa->id]);
                        }
                    } else {
                        $error++;
                        throw new \Exception('Gagal tambah users');
                    }
                }
                $datas = DataManipule::dataAccount($data);
            } else {
                $error++;
                throw new \Exception('Belum melakukan pembayaran');
            }

            if ($error === 0) {
                DB::commit();
                SendAccountJobs::dispatch($datas);
                $message = 'Success';
                $status = 200;
            }
        
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            $status = 500;
        }
        return response()->json([
            'message' => $message
        ],$status);
        
    }
    
}
