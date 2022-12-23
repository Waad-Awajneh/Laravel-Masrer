<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('posts')->delete();

        $faker = Factory::create();
        $users = DB::table('users')->pluck('id');
        foreach (range(1, 50) as $index) {
            // $users = User::orderByRaw("RAND")->pluck('id');;
            Post::create([
                'weddingP_id'     => $faker->randomElement($users),
                'content'         =>  $faker->paragraph(),
                'title'         =>  $faker->sentence(),
                'created_at'    => $faker->dateTime($max = 'now')
            ]);
        }

        foreach (User::all() as $likes) {
            $post = Post::inRandomOrder()->pluck('id')->unique()->toArray();
            $likes->likes()->attach($post);
        }


        foreach (User::all() as $users) {
            $favorite = Post::inRandomOrder()->pluck('id')->unique()->toArray();
            $users->favorites()->attach($favorite);
        }

        // foreach (Image::all() as $images) {
        //     $post = Post::inRandomOrder()->pluck('id')->toArray();
        //     $images->post()->attach($post);
        // }
    }
}
