<?php

namespace App\Http\Resources\OpenApi;

use Illuminate\Http\Resources\Json\JsonResource;

class Kelas extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $now = \Carbon\Carbon::now();
        
        return [  'name' => $this->name,
        'slug' => $this->slug,
        'harga' => number_format($this->courses->harga,0),
        'diskon' => $this->courses->diskon,
        'total_harga' => $this->courses->harga - ($this->courses->harga * ($this->courses->diskon/100)),
        'awal_pendaftaran' =>$this->awal_pendaftaran->format('d') .'-'. $this->bulans($this->awal_pendaftaran->format('m')) .'-'. $this->awal_pendaftaran->format('Y'),
        'akhir_pendaftaran' =>$this->akhir_pendaftaran->format('d') .'-'. $this->bulans($this->akhir_pendaftaran->format('m')) .'-'. $this->akhir_pendaftaran->format('Y'),
        'status_pendaftaran' => $now->diffInDays($this->akhir_pendaftaran,false)
        ];
    }
    public function bulans($bln){
        switch ($bln) {
            case '01':
                $bln = 'Januari';
                break;
                case '02':
                $bln = 'Februari';
                break;
                case '03':
                $bln = 'Maret';
                break;
                case '04':
                $bln = 'April';
                break;
                case '05':
                $bln = 'Mei';
                break;
                case '06':
                $bln = 'Juni';
                break;
                case '07':
                $bln = 'July';
                break;
                case '08':
                $bln = 'Agustus';
                break;
                case '09':
                $bln = 'September';
                break;
                case '10':
                $bln = 'Oktober';
                break;
                case '11':
                $bln = 'November';
                break;
                case '12':
                $bln = 'Desember';
                break;
            default:
                # code...
                break;
        }
        return $bln;
    }
}
