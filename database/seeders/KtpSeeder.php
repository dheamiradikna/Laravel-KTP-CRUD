<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KtpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        
        for ($i = 0; $i < 10000; $i++) {
            $gender = $faker->randomElement(['Laki-laki', 'Perempuan']);
            $maritalStatus = $faker->randomElement(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']);
            $religion = $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']);
            
            do {
                $nik = mt_rand(1000000000000000, 9999999999999999);
            } while (\App\Models\Ktp::where('nik', $nik)->exists());
            
            \App\Models\Ktp::create([
                'nik' => $nik,
                'nama' => $faker->name($gender == 'Laki-laki' ? 'male' : 'female'),
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->dateTimeBetween('-80 years', '-17 years')->format('Y-m-d'),
                'jenis_kelamin' => $gender,
                'alamat' => $faker->streetAddress,
                'rt_rw' => sprintf('%03d/%03d', $faker->numberBetween(1, 20), $faker->numberBetween(1, 10)),
                'kelurahan_desa' => $faker->word . ' ' . $faker->randomElement(['Utara', 'Selatan', 'Timur', 'Barat']),
                'kecamatan' => $faker->word . ' ' . $faker->randomElement(['Utara', 'Selatan', 'Timur', 'Barat']),
                'agama' => $religion,
                'status_perkawinan' => $maritalStatus,
                'pekerjaan' => $faker->jobTitle,
                'kewarganegaraan' => 'WNI',
                'foto' => null,
            ]);
            
            if ($i % 1000 === 0) {
                $this->command->info("Generated {$i} KTP records");
            }
        }
        
        $this->command->info('All 10,000 KTP records have been generated!');
    }
}
