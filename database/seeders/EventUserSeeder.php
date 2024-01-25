<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class EventUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('event_user')->insert([[
        'user_id' => 1,
        'event_id' => 1,
        'number_of_people' => 1,
        'canceled_date' => null,
        'created_at' => new DateTime(),
        ],
        [
        'user_id' => 2,
        'event_id' => 2,
        'number_of_people' => 1,
        'canceled_date' => null,
        'created_at' => new DateTime(),
        ],
        [
        'user_id' => 1,
        'event_id' => 3,
        'number_of_people' => 1,
        'canceled_date' => null,
        'created_at' => new DateTime(),
        ]
      ]);
    }
}
