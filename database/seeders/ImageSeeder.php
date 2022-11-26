<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        $faker = Factory::create();
         $posts = DB::table('posts')->pluck('id');
        foreach (range(1, 50) as $index) {
            Image::create([
                'post_id' =>$faker->randomElement($posts) ,
                'post_img' => $faker->imageUrl($width = 640, $height = 480),
                       
            ]);
        }
    }
}
