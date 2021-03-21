<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;
use App\Models\User;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = User::orderBy('id')->limit(3)->pluck('id')->all();
        $faker = app(\Faker\Generator::class);
        $statuses = Status::factory()->times(100)->make()->each(function($status)use($faker,$user_ids){
            $status->user_id = $faker->randomElement($user_ids);
        });
        Status::insert($statuses->toArray());
    }
}
