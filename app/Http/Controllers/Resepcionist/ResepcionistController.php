<?php

namespace App\Http\Controllers\Resepcionist;

use App\Http\Controllers\Controller;
use App\Http\Resources\CalonSiswa\CalonSiswaCollection;
use App\Models\CalonSiswa;
use App\Models\Followup;
use App\Models\Kelas;
use App\Models\Student;
use App\User;
use Illuminate\Http\Request;
use DB;

class ResepcionistController extends Controller
{
    public function create(Request $request){
       
    }

    public function index(Request $request){
        if ($request) {
            $data = CalonSiswa::with(['kelas_pilihan'=> function($q) {
                $q->withTrashed();
            },'info','followup'])
            ->where(function($q) use ($request) {
                $q->where('nama','LIKE',"%{$request->keyword}%")
                ->orWhere('email','LIKE',"%{$request->keyword}%")
                ->orWhereHas('kelas_pilihan',function($q) use ($request){
                $q->where('name','LIKE',"%{$request->keyword}%");
                });
                // ->orWhere('status','LIKE',"%{$request->keyword}%");
            })
            ->where(function($q) use ($request) {
                if ($request->status) {
                   $q->where('status_pendaftaran',$request->status);
                }
            })
            ->orderBy('created_at','desc')
            ->paginate(15);
        }
        return new CalonSiswaCollection($data) ;
    }

    public function changeStatus(Request $request){
        $error = 0;
        DB::beginTransaction();
        try {
            $data = CalonSiswa::findOrFail($request->id);
            $data->status_pendaftaran = $request->status;
            if ($data->save()) {
                if ($data->status_pendaftaran == 1 ) {
                    $cek_user = User::where('email',$data->email)->first();
                    if ($cek_user) {
                        DB::table('students_class')->insert([
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
                            $siswa->created_by = \Auth::user()->id;
                            if($siswa->save()){
                                DB::table('students_class')->insert([
                                'id_kelas' => $data->kelas
                                ,'id_student' => $siswa->id]);
                            }
                        } else {
                            $error++;
                            throw new \Exception('Gagal tambah users');
                        }
                    }
                   
                    
                }
            } else {
                $error++;
                throw new \Exception('Gagal mengubah status Leads');
            }

            if ($error === 0) {
                DB::commit();
                $message = 'Berhasil Tambah Menu';
                $status = 200;
            }
        
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $status = 500;
        }
        return response()->json([
            'message'=>$message
        ],$status);

    }

    public function followup(Request $request){
        $data = new Followup;
        $data->id_calon_siswa = $request->id_calon;
        $data->deskripsi = $request->deskipsi;
        $data->save();
        return response()->json([
            'message' => 'Success Simpan Follow Up',
            'data' => CalonSiswa::with('followup')->findOrFail($request->id_calon)
        ]);
    }

    public function destroy($id)
    {
        $student = \App\Models\CalonSiswa::findOrFail($id);
        if($student->delete()){
            return response()->json([
                'message' => 'Success Delete Leads'
            ]);
        }
    }

}
