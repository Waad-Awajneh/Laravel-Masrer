<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
         $users = DB::table('users')->pluck('id');
         $posts = DB::table('posts')->pluck('id');
        foreach (range(1, 50) as $index) {
            // $users = User::orderByRaw("RAND")->pluck('id');;
            Comment::create([
                'user_id'     =>$faker->randomElement($users) ,
                'post_id'         =>$faker->randomElement($users),
                'comment'    => $faker->paragraph(),
            ]);
        }
    }
}
