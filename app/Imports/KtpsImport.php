<?php

namespace App\Imports;

use App\Models\Ktp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class KtpsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $nik = isset($row['nik']) && !empty($row['nik']) 
            ? $row['nik'] 
            : $this->generateUniqueNIK();

        return new Ktp([
            'nik' => $nik,
            'nama' => $row['nama'] ?? null,
            'tempat_lahir' => $row['tempat_lahir'] ?? null,
            'tanggal_lahir' => $row['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $row['jenis_kelamin'] ?? 'Laki-laki',
            'alamat' => $row['alamat'] ?? null,
            'rt_rw' => $row['rt_rw'] ?? null,
            'kelurahan_desa' => $row['kelurahan_desa'] ?? null,
            'kecamatan' => $row['kecamatan'] ?? null,
            'agama' => $row['agama'] ?? null,
            'status_perkawinan' => $row['status_perkawinan'] ?? 'Belum Kawin',
            'pekerjaan' => $row['pekerjaan'] ?? null,
            'kewarganegaraan' => $row['kewarganegaraan'] ?? 'WNI',
            'foto' => null, // Photos cannot be imported via CSV
        ]);
    }

    /**
     * Generate a unique NIK
     */
    private function generateUniqueNIK()
    {
        do {
            $nik = mt_rand(1000000000000000, 9999999999999999);
        } while (Ktp::where('nik', $nik)->exists());

        return (string) $nik;
    }
}
