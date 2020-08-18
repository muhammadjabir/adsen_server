<?php

namespace App\Http\Controllers\Kelas;

use App\Http\Controllers\Controller;
use App\Http\Resources\Kelas\Kelas as KelasKelas;
use App\Models\Courses;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->keyword !=='') {
            $kelas = Kelas::with(['courses','kelasHasDay','trainer'])
                    ->where('name','LIKE',"%{$request->keyword}%")
                    ->orWhereHas('trainer',function($q) use ($request){
                        $q->where('name','LIKE',"%{$request->keyword}%");
                    })
                    ->paginate(15);
        }else{
            $kelas = Kelas::with(['courses','kelasHasDay','trainer'])
            ->paginate(15);

        }
        return $kelas;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Courses::where('status',1)->get();
        $trainers = \App\User::trainers()->get();
        $days = \App\Models\MasterDataDetail::days();
        return response()->json([
            'courses' => $courses,
            'trainers' => $trainers,
            'days' =>$days
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request_validation = [
            'slug' => Str::slug($request->name,'-')
        ];
        $validator = \Validator::make($request_validation, [
            'slug' => 'required|unique:class,slug',
        ],[
            '*.unique' => 'class Sudah Tersedia'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ],400);
        }

        // DB::beginTransaction();
        $error = 0;
        // try {
            $course = Courses::findOrFail($request->id_courses);
            $class = new \App\Models\Kelas;
            $class->name = $request->name;
            $class->slug = Str::slug($request->name,'-');
            $class->id_trainer = $request->id_trainer;
            $class->id_kursus = $request->id_courses;
            $class->jam_masuk = $request->mulai;
            $class->jam_pulang = $request->sampai;
            $class->max_students = $request->max_student;
            // $class->harga = $course->harga;
            // $class->diskon = $course->diskon;
            if($class->save()){
                // DB::commit();
                if(!$class->kelasHasDay()->attach(json_decode($request->days))){
                    // $error++;
                    // throw  new \Exception('Failed Add Days');
                };
            }else{
                // $error++;
                // throw  new \Exception('Failed Save Class');
            };

            if ($error === 0) {
                // DB::rollback();
                $message = 'Success Create New Class';
                $status = 200;
            }

        // } catch (\Exception $e) {
        //     $message = $e->getMessage();
        //     $status = 500;


        // }

        return response()->json([
            'message'=>$message
        ],$status);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class = Kelas::findOrFail($id);
        $courses = Courses::where('status',1)->get();
        $trainers = \App\User::trainers()->get();
        $days = \App\Models\MasterDataDetail::days();
        $class = [
            'id' => $class->id,
            'name' => $class->name,
            'id_trainer' => $class->id_trainer,
            'id_courses' => $class->id_kursus,
            'days'=> $class->kelasHasDay->pluck('id'),
            'max_student' => $class->max_students,
            'mulai' =>$class->jam_masuk,
            'sampai' => $class->jam_pulang
        ];
        return response()->json([
            'courses' => $courses,
            'trainers' => $trainers,
            'days' =>$days,
            'class' => $class
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request_validation = [
            'slug' => Str::slug($request->name,'-')
        ];
        $validator = \Validator::make($request_validation, [
            'slug' => 'required|unique:class,slug,'.$id,
        ],[
            '*.unique' => 'class Sudah Tersedia'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ],400);
        }

        DB::beginTransaction();
        $error = 0;
        try {

            $class = \App\Models\Kelas::findOrFail($id);
            $class->name = $request->name;
            $class->slug = Str::slug($request->name,'-');
            $class->id_trainer = $request->id_trainer;
            $class->id_kursus = $request->id_courses;
            $class->jam_masuk = $request->mulai;
            $class->jam_pulang = $request->sampai;
            $class->max_students = $request->max_student;
            if($class->save()){
                if(!$class->kelasHasDay()->sync(json_decode($request->days))){
                    $error++;
                    throw  new \Exception('Failed Edit Days');
                };
            }else{
                $error++;
                throw  new \Exception('Failed Save Class');
            };

            if ($error === 0) {
                DB::commit();
                $message = 'Success Edit Class';
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = Kelas::findOrFail($id);
        if($class->status == 1){
            return response()->json([
                'message' => 'Tidak dapat menghapus status Class masih active'
            ],400);
        }

        $class->delete();
        return response()->json([
            'message' => 'Success delete Class'
        ],200);
    }

    public function ChangeStatus(Request $request){
        $class = Kelas::findOrFail($request->id);
        if ($request->status == 'pendaftaran') {
        $class->status_pendaftaran = !$class->status_pendaftaran;

        } else {
        $class->status = !$class->status;
        }
        $class->save();
        return response()->json([
            'message' => 'Berhasil Change Status '
        ],200);
    }
}
