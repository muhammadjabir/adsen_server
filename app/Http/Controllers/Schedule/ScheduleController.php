<?php

namespace App\Http\Controllers\Schedule;

use App\Events\push;
use App\Http\Controllers\Controller;
use App\Http\Resources\Kelas\Kelas as KelasKelas;
use App\Http\Resources\Kelas\KelasResource;
use App\Models\Absensi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index(){
        $day = \Carbon\Carbon::now();
        $day = $this->getDays($day->format('l'));
        $user = Auth::guard()->user();
        if ($user->role()->first()->description === 'Trainer') {
            $kelas = \App\Models\Kelas::with('courses')->where('status',1)
            ->where('id_trainer',$user->id)
            ->whereHas('kelasHasDay',function($q) use ($day) {
            $q->where('description',$day);
        })->paginate(15);
        }else{
            $kelas = \App\Models\Kelas::with('courses')->where('status',1)
            ->whereHas('kelasHasDay',function($q) use ($day) {
                $q->where('description',$day);
            })->paginate(15);
        }
        return $kelas;
    }

    public function absen($id){
        $kelas = Kelas::with(['trainer','courses'])->findOrFail($id);
        $day = \Carbon\Carbon::now();
        $hadir = \App\Models\Absensi::where('id_kelas',$kelas->id)
        ->whereDate('created_at',$day->format('Y-m-d'))
        ->first();

        return response()->json([
            'kelas' => $kelas,
            'students' => $kelas->students()->get(),
            'absen' => $hadir ? $hadir->id_siswa : []
        ],200);
    }

    public function absen_student($id,Request $request){
        $day = \Carbon\Carbon::now();
        $absen = Absensi::where('id_kelas',$id)->whereDate('created_at',$day->format('Y-m-d'))
        ->first();
        if (!$absen) $absen = new Absensi;

        $absen->id_kelas = $id;
        $absen->id_siswa = $request->id_student;
        $absen->created_by = \Auth::user()->id;
        $absen->save();

        event(new push($absen));
        return $absen;
    }

    public function api_schedule(){
        $day = \Carbon\Carbon::now();
        $day = $this->getDays($day->format('l'));
        $kelas = Kelas::with(['trainer','courses'])
        ->where('status',1)
        ->whereHas('kelasHasDay',function($q) use ($day) {
            $q->where('description',$day);
        })->get();
        $data = [];
        foreach($kelas as $value){
            $data_collection = new KelasKelas($value);
            array_push($data,$data_collection);
        }
        return new KelasResource($data);
    }

    public function getDays($days){
        switch ($days) {
            case 'Sunday':
                $day = 'Minggu';
                break;
            case 'Monday':
                $day = 'Senin';
                break;
            case 'Tuesday':
                $day = 'Selasa';
                break;
            case 'Wednesday':
                $day = 'Rabu';
                break;
            case 'Thursday':
                $day = 'Kamis';
                break;
            case 'Friday':
                $day = 'Jumat';
                break;
            case 'Saturday':
                $day = 'Sabtu';
                break;
            default:
                $day = 'None';
                break;
        }

        return $day;
    }
}
