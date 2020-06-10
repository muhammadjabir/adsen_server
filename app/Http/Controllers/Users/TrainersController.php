<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use App\Models\MasterDataDetail;
use App\User;
use Illuminate\Http\Request;


class TrainersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->keyword != '') {
            $user = User::with('category')->where(function($q) use ($request) {
                      $q->where('name','LIKE',"%{$request->keyword}%")
                      ->where('id_role',34);
                    })
                    ->orWhere(function($q) use ($request) {
                        $q->where('email','LIKE',"%{$request->keyword}%")
                        ->where('id_role',34);
                      })
                    ->orWhereHas('category',function($q) use ($request){
                        $q->where('description','LIKE',"%{$request->keyword}%");
                    })
                    ->where('id_role',34)
                    ->paginate(15);
        }else{
            $user = User::with('category')
                    ->where('id_role',34)
                    ->paginate(15);
        }

        return $user;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = MasterDataDetail::where('id_master_data',8)->get();
        return response()->json([
            'category' => $category
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
            'email' => 'required|unique:users,email',
        ],[
            '*.unique' => 'Username Sudah Tersedia'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ],400);
        }
        $user = new User;
        $user->name = $request->name;
        $user->password = \Hash::make(123456);
        $user->email = $request->email;
        if ($request->file('foto_profile')) {
            $foto =  $request->file('foto_profile')->store('foto_profile','public');
            $user->foto = $foto;
        }else{
            $user->foto = 'default\icon_admin.jpg';
        }
        $user->id_category = $request->id_category;
        $user->id_role = 34;
        $user->kelamin = $request->kelamin;
        $user->save();

        return response()->json([
            'message' => 'Success Create New Trainer'
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
        $category = MasterDataDetail::where('id_master_data',8)->get();
        $user = User::findOrFail($id);
        return response()->json([
            'user' =>$user,
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
        $validator = \Validator::make($request->all(), [
            'email' => 'required|unique:users,email,'.$id,
        ],[
            '*.unique' => 'Username Sudah Tersedia'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ],400);
        }
        $user = User::findOrFail($id);
        $user->name = $request->name;
        if($request->file('foto_profile')){
            if($user->foto and file_exists(storage_path('app/public/'.$user->foto))){
                $cek = explode('\\',$user->foto);
                if ($cek[0] != 'default') \Storage::delete('public/'.$user->foto);
                }
            $file = $request->file('foto_profile')->store('foto_profile','public');
            $user->foto = $file;
        }
        $user->email = $request->email;
        $user->kelamin = $request->kelamin;

        $user->save();

        return response()->json([
            'message' => 'Success Edit Trainer'
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
        $user = User::findOrFail($id);
        if ($user->id_role !== 23) {
            $user->delete();
            return response()->json([
                'message' => 'Success Delete Trainer'
            ],200);
        }else{
            return response()->json([
                'message' => 'Tidak bisa menghapus User Developer'
            ],400);
        }
    }
}
