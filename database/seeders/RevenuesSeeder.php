<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RevenuesSeeder extends Seeder
{
    public function run()
    {
        DB::table('revenues')->insert([
            'janvier' => 50000,
            'fevrier' => 45000,
            'mars' => 60000,
            'avril' => 55000,
            'mai' => 70000,
            'juin' => 65000,
            'juillet' => 72000,
            'aout' => 68000,
            'septembre' => 75000,
            'octobre' => 80000,
            'novembre' => 82000,
            'decembre' => 90000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}