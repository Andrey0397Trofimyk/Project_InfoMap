<?php

use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments = [
            [
                'user_id' => 2,
                'location_id' => 1,
                'surname' => 'Alex',
                'review' => 'Живу тут і мені це подобається !!!!'
            ],
            [
                'user_id' => 2,
                'location_id' => 1,
                'surname' => 'Alex',
                'review' => 'Запрошую всіх!!!'
            ]
        ];
        DB::table('comments')->insert($comments);
    }
}
