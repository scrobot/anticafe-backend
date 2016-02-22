<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Helpers\Roles\Role::firstOrCreate(['name' => 'Менеджер']);
    }
}
