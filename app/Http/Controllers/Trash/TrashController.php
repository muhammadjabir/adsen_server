<?php

namespace App\Http\Controllers\Trash;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use DB;

class TrashController extends Controller
{
    public function user(Request $request){
        // if ($request) {
        //     $user = User::onlyTrashed()->with('role')
            
        //             ->where('name','LIKE',"%{$request->keyword}%")
        //             ->orWhere('email','LIKE',"%{$request->keyword}%")
        //             ->orWhereHas('role',function($q) use ($request){
        //                 $q->where('description','LIKE',"%{$request->keyword}%");
        //             })
             
        //             ->paginate(15);
        // }
        $user = DB::table('users')->where('deleted_at','!=',null)->paginate(15);
        return $user;
    }

    public function student(Request $request) {
        if ($request->keyword !=='') {
            $students = \App\Models\Student::onlyTrashed()->with(['kelas'=> function($q) {
                $q->withTrashed()->select('name');
            }])
                    ->where('name','LIKE',"%{$request->keyword}%")
                    ->orWhereHas('kelas',function($q) use ($request){
                        $q->where('name','LIKE',"%{$request->keyword}%");
                    })->onlyTrashed()->paginate(15);
        }else{
            $students = \App\Models\Student::onlyTrashed()->with(['kelas'])->paginate(15);

        }
        return $students;
    }

    public function courses(Request $request) {
        if ($request->keyword != '') {
            $courses = \App\Models\Courses::onlyTrashed()->with('category');
            if($request->keyword == 'ACTIVE'){
                $courses->where('status',1);
            }elseif ($request->keyword == 'NON-ACTIVE') {
                $courses->where('status',0);

            }else{
                $courses
                ->where('name', "LIKE","%{$request->keyword}%")
                ->orWhereHas('category',function($q) use ($request) {
                    $q->where('description','LIKE', "{$request->keyword}");
                });
            }



        }else{
            $courses = \App\Models\Courses::onlyTrashed()->with('category');
        }

        return $courses->paginate(15);
    }

    public function kelas(Request $request) {
        // if ($request->keyword !=='') {
        //     $kelas = \App\Models\Kelas::onlyTrashed()->with(['courses'])
        //             ->where('name','LIKE',"%{$request->keyword}%")
        //             ->paginate(15);
        // }else{
        //     $kelas = \App\Models\Kelas::onlyTrashed()->with(['courses'])
        //     ->paginate(15);

        // }
        $kelas = DB::table('class')->where('deleted_at','!=',null)->paginate(15);
        return $kelas;
    }

    public function user_delete($id){
        $data = User::onlyTrashed()->findOrFail($id);
        $data->forceDelete();
        return response()->json([
            'message' => 'Success Delete Users'
        ]);
    }

    public function kelas_delete($id){
        $data = \App\Models\Kelas::onlyTrashed()->findOrFail($id);
        $data->forceDelete();
        return response()->json([
            'message' => 'Success Delete Class'
        ]);
    }

    public function courses_delete($id){
        $data = \App\Models\Courses::onlyTrashed()->findOrFail($id);
        $data->forceDelete();
        return response()->json([
            'message' => 'Success Delete Courses'
        ]);
    }
    public function student_delete($id){
        $data = \App\Models\Student::onlyTrashed()->findOrFail($id);
        $data->forceDelete();
        return response()->json([
            'message' => 'Success Delete Student'
        ]);
    }
}
