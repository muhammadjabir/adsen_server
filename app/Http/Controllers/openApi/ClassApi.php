<?php

namespace App\Http\Controllers\openApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\OpenApi\KelasCollection;
use App\Models\Kelas;
use App\Models\CalonSiswa;
use App\Models\MasterDataDetail;
use Illuminate\Http\Request;
use App\Events\push;

class ClassApi extends Controller
{
    public function index(){
        $data = Kelas::with('courses')->where('status_pendaftaran',1)->get();
        $data_info = MasterDataDetail::select('description')->where('id_master_data',10)->get();
        return ['data'=>new KelasCollection($data),'data_info'=>$data_info];
    }

    public function create(Request $request){
        $validator = \Validator::make($request->all(), [
            'nohp'=>'required|numeric',
            'nowa'=>'required|numeric',
            'email'=>'email|required',
            'nama'=> 'required',
            'status'=>'required',
            'kelas'=>'required|exists:class,slug',
            'alamat'=>'required',
            'tgl_lahir' => 'required|date',
            'info'=>'required',
            'kelamin'=>'required',

        ],[
            '*.required'=> ':attribute Tidak Boleh Kosong'
        ])->setAttributeNames(['nohp'=>'Nomor Handphone',
            'nowa' => 'Nomor Whatsapp',
            'email' => 'Email',
            'nama' => 'Nama',
            'status' => 'Status',
            'kelas' => 'Kelas',
            'alamat'=>'Alamat',
            'tgl_lahir' => 'Tanggal Lahir',
            'info'=>'Info Darimana',
            'kelamin'=>'Kelamin',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ],400);
        }

        if ($request->status != 'mahasiswa' && $request->status != 'karyawan' ) {
                return response()->json([
                    'message' => 'Status Tidak Boleh Kosong'
                ],400);
        }
        if ($request->kelamin != 'Pria' && $request->kelamin != 'Wanita') {
            return response()->json([
                'message' => 'Kelamin Tidak Boleh Kosong'
            ],400);
        }
        $cek_info = MasterDataDetail::where('description',$request->info)->first();
        if (!$cek_info) {
            return response()->json([
                'message' => 'Info darimana Tidak Boleh Kosong'
            ],400);
        }
        $cek_data = CalonSiswa::where('email',$request->email)->where('status_pendaftaran',0)->first();
        if ($cek_data) {
            return response()->json([
                'message' => 'Silakan Menunggu dihubungi CS kami'
            ],400);
        }
        $id_kelas = Kelas::with('courses')->where('slug',$request->kelas)->first();
        $tgl = \Carbon\Carbon::now();
        $kode = CalonSiswa::whereYear('created_at',$tgl->format('Y'))
        ->whereMonth('created_at',$tgl->format('m'))
        ->orderBy('created_at','desc')
        ->first();
        $kode = $kode ? $kode->kode_invoice + 1 : $tgl->format('Ym') . '001';
        $data = new CalonSiswa();
        $data->nohp = $request->nohp;
        $data->nowa = $request->nowa;
        $data->email = $request->email;
        $data->kode_invoice = $kode;
        $data->nama = $request->nama;
        $data->status = $request->status;
        $data->kelas = $id_kelas->id;
        $data->kelamin = $request->kelamin;
        $data->alamat = $request->alamat;
        $data->tgl_lahir = $request->tgl_lahir;
        $data->catatan = $request->catatan;
        $data->id_darimana = $cek_info->id;
        $data->harga = $id_kelas->courses->harga;
        $patern = env('MERCHANT_CODE') . ":$kode";
        $secret = env('MERCHANT_SECRET');
        $signature = hash_hmac('sha256',$patern,$secret);
        $data->encrypt_invoice = $signature;
        if($data->save()){
            event(new push($data));
        };

        return response()->json([
            'message'=>'success'
        ],200);
        
    }
}
