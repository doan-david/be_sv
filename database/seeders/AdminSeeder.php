<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456'),
                'role_id' => 1,
            ],
            [
                'name' => 'david',
                'email' => 'doanhgminhit@gmail.com',
                'password' => bcrypt('123456'),
                'role_id' => 2,
            ]

        ]);
    }
}
