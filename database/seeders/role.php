<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class role extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            'nama_role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('role')->insert([
            'nama_role' => 'pasien',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('role')->insert([
            'nama_role' => 'dokter',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
