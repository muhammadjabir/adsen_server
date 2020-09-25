<?php

namespace App\Http\Controllers\Resepcionist;

use App\Http\Controllers\Controller;
use App\Http\Resources\CalonSiswa\CalonSiswaCollection;
use App\Jobs\SendInvoiceJobs;
use App\Models\CalonSiswa;
use App\Models\Courses;
use App\Models\Followup;
use App\Models\Kelas;
use App\Models\Student;
use App\User;
use Illuminate\Http\Request;
use DB;

class ResepcionistController extends Controller
{
    public function sendInvoice($id){
        $data = CalonSiswa::with(['kelas_pilihan'=>function($q){
            $q->withTrashed()->with(['courses'=>function($q){
                $q->withTrashed();
            }]);
        }])->findOrFail($id);
        $category_courses = $data->kelas_pilihan->courses->category_courses ? $data->kelas_pilihan->courses->category_courses->description : '';
        if ($category_courses == 'Career Program') {
            $id_category = $data->kelas_pilihan->courses->category->id;
            $courses = Courses::where('id_category',$id_category)->where('id','!=',$data->kelas_pilihan->courses->id)->get();
        }else {
            $courses = [$data->kelas_pilihan->courses];
        }
        // $tgl = \Carbon\Carbon::now();
        // $kode = CalonSiswa::whereYear('created_at',$tgl->format('Y'))->whereMonth('created_at',$tgl->format('m'))->orderBy('created_at','desc')
        // ->first();
        // $kode = $kode->kode ? $kode->kode + 1 : $tgl->format('Ym') . '001';
        // if (!$data->kode_invoice) {
        //     $data->kode_invoice = $kode;
        // }
       
        $data->harga = $data->kelas_pilihan->courses->harga;
        $data->diskon = $data->kelas_pilihan->courses->diskon;
        $data->no_reference = '';
        $data->save();
        $data = [
            'nama' => $data->nama,
            'email' => $data->email,
            'encrypt_invoice' => $data->encrypt_invoice,
            'kelas_pilihan' => $data->kelas_pilihan->name,
            'category_courses' => $category_courses,
            'courses' => $courses
        ];
        // return view('email',$data);
       SendInvoiceJobs::dispatch($data);

    }

    public function edit($id) {
        $lead = CalonSiswa::findOrFail($id);
        $kelas = \App\Models\Kelas::where('status_pendaftaran',1)->get();
        return response()->json([
            'lead' =>$lead,
            'kelas' => $kelas
        ]);
    }

    public function update(Request $request,$id) {
        $data = CalonSiswa::findOrFail($id);
        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->nohp = $request->nohp;
        $data->nowa = $request->nowa;
        $data->kelas = $request->kelas;
        $data->save();
        return response()->json([
            'message' => 'Success Edit data lead'
        ],200);
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
            $data->kelas = $request->kelas;
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

    public function getKelas(){
        $kelas = \App\Models\Kelas::where('status_pendaftaran',1)->get();
        return response()->json([
            'kelas' => $kelas
        ]);
    }

}
