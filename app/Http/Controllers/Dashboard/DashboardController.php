<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Kelas\Kelas as KelasKelas;
use App\Http\Resources\Kelas\KelasCollection;
use App\Http\Resources\Kelas\KelasResource;
use App\Models\Kelas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function student(){
        $user = \Auth::user();
        $kelas = Kelas::whereHas('students', function($q) use($user) {
           return $q->where('id_user', $user->id );
        })->get();
        return new KelasCollection($kelas);
    }
}
