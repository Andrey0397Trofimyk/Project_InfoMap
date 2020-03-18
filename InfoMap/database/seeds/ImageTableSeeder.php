<?php

use Illuminate\Database\Seeder;

class ImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = [
            [
                'location_id' => 1,
                'image_url' => 'location_images/lubart_1.jpg',
            ],
            [
                'location_id' => 1,
                'image_url' => 'location_images/lubart_2.jpg',
            ]
            ,
            [
                'location_id' => 1,
                'image_url' => 'location_images/lubart_3.jpg',
            ]
            ,
            [
                'location_id' => 1,
                'image_url' => 'location_images/lubart_4.jpg',
            ]
            ,
            [
                'location_id' => 1,
                'image_url' => 'location_images/lubart_5.jpg',
            ]
            ,
            [
                'location_id' => 2,
                'image_url' => 'location_images/warshava_1.jpg',
            ]
            ,
            [
                'location_id' => 2,
                'image_url' => 'location_images/warshava_2.jpg',
            ]
            ,
            [
                'location_id' => 2,
                'image_url' => 'location_images/warshava_3.jpg',
            ]
            ,
            [
                'location_id' => 2,
                'image_url' => 'location_images/warshava_4.jpg',
            ]
        ];
        DB::table('images')->insert($images);
    }
}
