<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->keyword != '') {
            $courses = Courses::with('category');
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
            $courses = Courses::with('category');
        }

        return $courses->paginate(15);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = \App\Models\MasterDataDetail::where('id_master_data',8)->get();
        return response()->json([
            'category' => $category
        ]);
    }

    public function ChangeStatus(Request $request){
        $courses = Courses::findOrFail($request->id);
        $courses->status = !$courses->status;
        $courses->save();
        return response()->json([
            'message' => 'Berhasil Change Status '
        ],200);
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
            'slug' => 'required|unique:courses,slug',
        ],[
            '*.unique' => 'Courses Sudah Tersedia'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ],400);
        }
        $courses = new Courses;
        $courses->name = $request->name;
        $courses->slug = Str::slug($request->name,'-');
        $courses->id_category = $request->id_category;
        if ($request->file('foto')) {
            $foto =  $request->file('foto')->store('foto_courses','public');
            $courses->foto = $foto;
        }else{
            $courses->foto = 'default\icon_admin.jpg';
        }
        $courses->created_by=auth()->user()->id;
        $courses->save();
        return response()->json([
            'message' => 'Success Create Courses'
        ],200);
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
        $category =  \App\Models\MasterDataDetail::where('id_master_data',8)->get();
        $courses = Courses::findOrFail($id);
        return response()->json([
            'courses' =>$courses,
            'category' => $category
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
            'slug' => 'required|unique:courses,slug,' .$id,
        ],[
            '*.unique' => 'Courses Sudah Tersedia'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ],400);
        }
        $courses = Courses::findOrFail($id);
        $courses->name = $request->name;
        $courses->slug = Str::slug($request->name,'-');
        $courses->id_category = $request->id_category;
        if ($request->file('foto')) {
            if($courses->foto and file_exists(storage_path('app/public/'.$courses->foto))){
                $cek = explode('\\',$courses->foto);
                if ($cek[0] != 'default') \Storage::delete('public/'.$courses->foto);
                }
            $foto =  $request->file('foto')->store('foto_courses','public');
            $courses->foto = $foto;
        }
        $courses->created_by=auth()->user()->id;
        $courses->save();
        return response()->json([
            'message' => 'Success Edit Courses'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $courses = Courses::findOrFail($id);
        if($courses->status == 1){
            return response()->json([
                'message' => 'Tidak dapat menghapus status course masih active'
            ],400);
        }

        $courses->delete();
        return response()->json([
            'message' => 'Success delete Courses'
        ],200);
    }
}
