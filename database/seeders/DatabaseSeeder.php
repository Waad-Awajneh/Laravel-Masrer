<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        // \App\Models\Post::factory(100)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password' => Hash::make('password'),
        // ]);

        //attach user to wedding planner
        foreach (User::all() as $following) {
            $follower = User::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();
            $following->followingU()->attach($follower);
        }


        //attach wedding planner to users
        foreach (User::all() as $follower) {
            $following = User::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();
            $follower->followingW()->attach($following);
        }


        foreach (User::all() as $likes) {
            $post = Post::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();
            $likes->likes()->attach($post);
        }

        foreach (User::all() as $user) {
            $favorite = Post::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();
            $user->favorite()->attach($favorite);
        }
    }
}
