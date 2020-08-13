<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Http\Resources\Kelas\KelasCollection;
use App\Models\Student;
use App\User;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->keyword !=='') {
            $students = \App\Models\Student::with(['kelas'=> function($q) {
                $q->withTrashed()->select('name');
            }])
                    ->where('name','LIKE',"%{$request->keyword}%")
                    ->orWhereHas('kelas',function($q) use ($request){
                        $q->where('name','LIKE',"%{$request->keyword}%");
                    })->paginate(15);
        }else{
            $students = \App\Models\Student::with(['kelas'])->paginate(15);

        }
        return $students;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = \App\Models\Kelas::where('status',1)->get();
        return response()->json([
            'kelas' => $kelas
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
        $validator = \Validator::make($request->all(), [
            'username' => 'required|unique:users,email',
        ],[
            '*.unique' => 'Email Sudah Tersedia'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ],400);
        }
        $user = new User;
        $user->name = $request->name;
        $user->password = \Hash::make('123456');
        $user->email = $request->username;
        $user->kelamin= $request->kelamin;
        $user->id_role = 42;
        if ($user->save()) {
            $student = new \App\Models\Student;
            $student->name = $request->name;
            $student->kelamin = $request->kelamin;
            $student->created_by = auth()->user()->id;
            if ($request->file('foto')) {
                $foto = $request->file('foto')->store('foto_students','public');
                $student->foto= $foto;
            }else{
                $student->foto = 'default\icon_admin.jpg';
            }
            if($student->save()){
                $student->kelas()->attach(json_decode($request->kelas));


            }
        }


        return response()->json([
            'message' => 'Success Create New Student'
        ]);
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
        $student = Student::findOrFail($id);
        $kelas = \App\Models\Kelas::where('status',1)->get();
        $student->id_kelas = $student->kelas->pluck('id');
        return [
            'student' => $student,
            'kelas' => $kelas
        ];
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
        $student = \App\Models\Student::findOrFail($id);
        $student->name = $request->name;
        $student->kelamin = $request->kelamin;
        $student->created_by = auth()->user()->id;
        if ($request->file('foto')) {
            if ($student->foto && file_exists(storage_path('app/public/'.$student->foto)) ) {
                $cek = explode('\\',$student->foto);
                if ($cek[0] != 'default') \Storage::delete('public/'.$student->foto);
            }
            $foto = $request->file('foto')->store('foto_students','public');
            $student->foto= $foto;
        }
        if($student->save()){
            $student->kelas()->sync(json_decode($request->kelas));
        }
        return response()->json([
            'message' => 'Success Edit Student'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = \App\Models\Student::findOrFail($id);
        if($student->delete()){
            return response()->json([
                'message' => 'Success Delete Student'
            ]);
        }
    }


    public function kelas(){
        $user = \Auth::user();
        return response()->json([
            'message' => 'kelas yang diikuti',
            'kelas' =>new KelasCollection($user->student->kelas)
        ]);
    }
}
