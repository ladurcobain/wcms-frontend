<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
    	foreach (range(1,50) as $index) {
            DB::table('tm_albums')->insert([
                'title' => $faker->title,
                'name' => $faker->username,
                'label' => $faker->text,
                'description' => $faker->text,
            ]);
        }
    }
}
