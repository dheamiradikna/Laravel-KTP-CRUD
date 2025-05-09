<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ktp extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'rt_rw',
        'kelurahan_desa',
        'kecamatan',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'kewarganegaraan',
        'foto'
    ];

    protected $appends = ['umur'];

    public function getUmurAttribute()
    {
        return \Carbon\Carbon::parse($this->tanggal_lahir)->age;
    }
}
