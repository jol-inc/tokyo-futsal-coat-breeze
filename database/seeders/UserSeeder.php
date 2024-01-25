<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DateTime;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        [
          'name' => 'm1',
          'email' => 'm1@m1.com',
          'password' => Hash::make('pppppppp'),
          'role' => 5,
          'created_at' => new DateTime(),
        ],
        [
          'name' => 'c1',
          'email' => 'c1@c1.com',
          'password' => Hash::make('pppppppp'),
          'role' => 9,
          'created_at' => new DateTime(),
        ]

      ]);



    }
}
