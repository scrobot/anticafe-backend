<?php

use Anticafe\Http\Models\ImageOption;
use Illuminate\Database\Seeder;

class OptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(ImageOption::where('name', '100x100')->first() == null) {
            ImageOption::create(
                [
                    'name' => '100x100',
                    'width' => '100',
                    'height' => '100',
                    'anchor' => 'center'
                ]
            );
        }
    }
}
