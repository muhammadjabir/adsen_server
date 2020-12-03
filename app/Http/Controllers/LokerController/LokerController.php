<?php

namespace App\Http\Controllers\LokerController;

use App\Http\Controllers\Controller;
use App\Http\Resources\Lokers\Lokers as LokersLokers;
use App\Http\Resources\Lokers\LokersCollection;
use App\Models\Lokers;
use Illuminate\Http\Request;

class LokerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->keyword) {
            $data = Lokers::where('judul','LIKE',"%$request->keyword%")->orderBy('created_at','desc')->paginate(10);
        } else {
            $data = Lokers::orderBy('created_at','desc')->paginate(10);
        }
        
        return new LokersCollection($data);
    }
    public function ChangeStatus(Request $request){
        $courses = Lokers::findOrFail($request->id);
        $courses->status = !$courses->status;
        $courses->save();
        return response()->json([
            'message' => 'Berhasil Change Status '
        ],200);
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
        $data = new Lokers();
        $data->judul = $request->judul;
        $data->deskripsi = $request->deskripsi;
        if ($request->file('foto')) {
            $foto =  $request->file('foto')->store('foto_loker','public');
            $data->foto = $foto;
        }
        $data->save();
        return response()->json([
            'message' => 'Berhasil tambah lowongan'
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
        $data = Lokers::findOrFail($id);
        return new LokersLokers($data);
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
        $data = Lokers::findOrFail($id);
        $data->judul = $request->judul;
        $data->deskripsi = $request->deskripsi;
        if ($request->file('foto')) {
            $foto =  $request->file('foto')->store('foto_loker','public');
            $data->foto = $foto;
        }
        $data->save();
        return response()->json([
            'message' => 'Berhasil Edit lowongan'
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
        $data = Lokers::findOrFail($id);
        $data->delete();
        return response()->json([
            'message' => 'Berhasil Hapus Lowongan'
        ]);
    }
}
