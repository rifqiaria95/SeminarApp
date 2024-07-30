<?php

namespace Database\Seeders;

use App\Models\DataSeminar;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SeminarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataSeminar::insert([
            [
                'id'         => 1,
                'judul'      => 'Cara Membuat API',
                'link'       => 'https://www.google.com/',
                'tanggal'    => now(),
                'harga'      => 'Rp 90.000',
                'lampiran'   => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 2,
                'judul'      => 'Cara Backup Data',
                'link'       => 'https://www.google.com/',
                'tanggal'    => now(),
                'harga'      => 'Rp 120.000',
                'lampiran'   => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
