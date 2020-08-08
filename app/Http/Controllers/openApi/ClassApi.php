<?php

namespace App\Http\Controllers\openApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\OpenApi\KelasCollection;
use App\Models\Kelas;
use Illuminate\Http\Request;

class ClassApi extends Controller
{
    public function index(){
        $data = Kelas::where('status',1)->get();
        return new KelasCollection($data);
    }
}
