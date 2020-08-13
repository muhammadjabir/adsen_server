<?php

namespace App\Http\Controllers\openApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\OpenApi\KelasCollection;
use App\Models\Kelas;
use App\Models\CalonSiswa;
use App\Models\MasterDataDetail;
use Illuminate\Http\Request;

class ClassApi extends Controller
{
    public function index(){
        $data = Kelas::where('status',1)->get();
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
        $id_kelas = Kelas::where('slug',$request->kelas)->first();
        $data = new CalonSiswa();
        $data->nohp = $request->nohp;
        $data->nowa = $request->nowa;
        $data->email = $request->email;
        $data->nama = $request->nama;
        $data->status = $request->status;
        $data->kelas = $id_kelas->id;
        $data->kelamin = $request->kelamin;
        $data->alamat = $request->alamat;
        $data->tgl_lahir = $request->tgl_lahir;
        $data->catatan = $request->catatan;
        $data->id_darimana = $cek_info->id;
        $data->save();

        return response()->json([
            'message'=>'success'
        ],200);
        
    }
}
