<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'email' => "alice@mail.com",
                'name' => 'alice',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
            ],
            [
                'email' => "bob@mail.com",
                'name' => 'bob',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
            ]
        ]);
    }
}
