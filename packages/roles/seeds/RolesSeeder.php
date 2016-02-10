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
        \Yadeshevle\Roles\Role::firstOrCreate(['name' => 'Исполнитель']);
        \Yadeshevle\Roles\Role::firstOrCreate(['name' => 'Заказчик']);
    }
}
