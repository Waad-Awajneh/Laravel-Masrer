<?php

namespace Database\Seeders;
use \App\Models\Post;
use \App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        // \App\Models\Post::factory(100)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password' => Hash::make('password'),
        // ]);

        //attach user to wedding planner
        foreach (User::all() as $following) {
            $follower = User::inRandomOrder()->take(rand(1, 3))->pluck('id')->unique()->toArray();
            $following->following()->attach($follower);
        }


        //attach wedding planner to users
        foreach (User::all() as $follower) {
            $following = User::inRandomOrder()->take(rand(1, 3))->pluck('id')->unique()->toArray();
            $follower->followers()->attach($following);
        }



    }
    }

