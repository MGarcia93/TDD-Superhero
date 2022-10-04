<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperpowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('superpowers')->insert([
            ['name' => 'agility'],
            ['name' => 'strngh'],
            ['name' => 'flight'],
            ['name' => 'invulnerability'],
            ['name' => 'Accelerated Healing']
        ]);
    }
}
