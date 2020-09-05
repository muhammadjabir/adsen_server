<?php

namespace App\Http\Controllers\Rekening;

use App\Http\Controllers\Controller;
use App\Models\Rekening;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request) {
            $user = Rekening::
                    where('nama','LIKE',"%{$request->keyword}%")
                    ->orWhere('norek','LIKE',"%{$request->keyword}%")
                   
                    ->paginate(15);
        }else{
            $user = Rekening::
                    paginate(15);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $courses = new Rekening();
        $courses->nama = $request->nama;
        $courses->norek = $request->norek;
        $courses->foto = $request->foto;
        if ($request->file('foto')) {
            $foto =  $request->file('foto')->store('foto_rekening','public');
            $courses->foto = $foto;
        }else{
            $courses->foto = 'default\icon_admin.jpg';
        }
        $courses->save();
        return response()->json([
            'message' => 'Success Create Rekening'
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
        $courses = Rekening::findOrFail($id);
        return response()->json([
            'courses' =>$courses,
           
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
        $courses = Rekening::findOrFail($id);
        $courses->nama = $request->nama;
        $courses->norek = $request->norek;
        $courses->foto = $request->foto;
        if ($request->file('foto')) {
            $foto =  $request->file('foto')->store('foto_rekening','public');
            $courses->foto = $foto;
        }
        $courses->save();
        return response()->json([
            'message' => 'Success Edit Rekening'
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
        //
    }
}
