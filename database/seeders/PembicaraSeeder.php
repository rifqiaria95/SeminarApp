<?php

namespace Database\Seeders;

use App\Models\Pembicara;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PembicaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pembicara::insert([
            [
                'nama_lengkap' => 'John Doe',
                'phone'        => '081210396217',
                'email'        => 'john@gmail.com',
                'company'      => 'PT John Doe',
            ],
            [
                'nama_lengkap' => 'John Wick',
                'phone'        => '081210396219',
                'email'        => 'wick@gmail.com',
                'company'      => 'PT Wick',
            ],
        ]);
    }
}
