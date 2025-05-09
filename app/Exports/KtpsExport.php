<?php

namespace App\Exports;

use App\Models\Ktp;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KtpsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ktp::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'NIK',
            'Nama',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat',
            'RT/RW',
            'Kelurahan/Desa',
            'Kecamatan',
            'Agama',
            'Status Perkawinan',
            'Pekerjaan',
            'Kewarganegaraan',
            'Umur'
        ];
    }

    /**
     * @param Ktp $ktp
     * @return array
     */
    public function map($ktp): array
    {
        return [
            $ktp->nik,
            $ktp->nama,
            $ktp->tempat_lahir,
            $ktp->tanggal_lahir,
            $ktp->jenis_kelamin,
            $ktp->alamat,
            $ktp->rt_rw,
            $ktp->kelurahan_desa,
            $ktp->kecamatan,
            $ktp->agama,
            $ktp->status_perkawinan,
            $ktp->pekerjaan,
            $ktp->kewarganegaraan,
            $ktp->umur
        ];
    }
}
