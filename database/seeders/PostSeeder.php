<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Post;
use App\Models\User;
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
        DB::table('posts')->delete();

        $faker = Factory::create();

        foreach (range(1, 1000) as $index) {
            $users = User::orderByRaw("RAND()")->first();
            Post::create([
                'WeddingP_id'     => $users->id,
                'content'         => "jijijijiji",
                'created_at'    => $faker->dateTime($max = 'now')
            ]);
        }
    }
}
