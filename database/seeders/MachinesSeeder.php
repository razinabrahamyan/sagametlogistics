<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class MachinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Machine::insert([
            [
                "title"    => "Валдаи",
                "title_en" => "valdai",
            ],
            [
                "title"    => "Камаз",
                "title_en" => "kamaz",
            ],
            [
                "title"    => "МАЗ",
                "title_en" => "maz",
            ],
            [
                "title"    => "МАН",
                "title_en" => "man",
            ],
            [
                "title"    => "Найм",
                "title_en" => "hire",
            ]
        ]);
    }
}
