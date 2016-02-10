<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Anticafe\Http\Models\User::create(
            [
                'email' => 'admin@anticafe.im',
                'username' => 'admin',
                'password' => "admin123",
                'level' => 0
            ]
        );
    }
}
