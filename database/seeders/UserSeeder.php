<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'NguyenCongDuy',
            'email'=> 'duync@gmail.com',
            'password' => 124435,
            'remember_token' => 'nguodung',
        ]);
    }
}
