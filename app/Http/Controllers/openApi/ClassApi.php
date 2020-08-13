<?php

namespace App\Http\Controllers\openApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\OpenApi\KelasCollection;
use App\Models\Kelas;
use App\Models\CalonSiswa;
use Illuminate\Http\Request;

class ClassApi extends Controller
{
    public function index(){
        $data = Kelas::where('status',1)->get();
        return new KelasCollection($data);
    }

    public function create(Request $request){
        $validator = \Validator::make($request->all(), [
            'nohp'=>'required|numeric',
            'nowa'=>'required|numeric',
            'email'=>'email|required',
            'nama'=> 'required',
            'status'=>'required',
            'kelas'=>'required|exists:class,slug'
        ],[
            '*.required'=> ':attribute Tidak Boleh Kosong'
        ])->setAttributeNames(['nohp'=>'Nomor Handphone',
            'nowa' => 'Nomor Whatsapp',
            'email' => 'Email',
            'nama' => 'Nama',
            'status' => 'Status',
            'kelas' => 'Kelas',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ],400);
        }

        if ($request->status != 'mahasiswa' && $request->status != 'karyawan') {
           
                return response()->json([
                    'message' => 'Status Tidak Boleh Kosong'
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
        $data->save();

        return response()->json([
            'message'=>'success'
        ],200);
        
    }
}
