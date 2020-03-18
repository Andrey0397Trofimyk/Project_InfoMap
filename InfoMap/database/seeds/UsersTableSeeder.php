<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('a787429t'),
                'is_admin' => 1
            ],
            [
                'name' => 'Alex',
                'email' => 'alex@gmail.com',
                'password' => bcrypt('tarter123'),
                'is_admin' => 0
            ]
        ];
        DB::table('users')->insert($users); 
    }
}
