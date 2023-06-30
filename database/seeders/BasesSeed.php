<?php

namespace Database\Seeders;

use App\Models\Base;
use Illuminate\Database\Seeder;

class BasesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Base())::insert([
            [
                'title' => 'Наша База',
            ]
        ]);
    }
}
