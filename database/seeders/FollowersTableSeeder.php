<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //第一个用户
        $users = User::all();
        $user = $users->first();

        //其他用户
        $followers = $users->slice($user->id);
        $follower_ids = $followers->pluck('id')->toArray();

        //第一个用户关注其他用户
        $user->follow($follower_ids);

        //其他用户关注第一个用户
        $followers->each(function($follower)use($user){
           $follower->follow($user->id);
        });
    }
}
