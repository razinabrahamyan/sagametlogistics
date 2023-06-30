<?php

namespace Database\Seeders;

use App\Models\MetalType;
use Illuminate\Database\Seeder;

class MetaltypesSeed extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        (new MetalType())::insert([
            [
                'title'      => 'Черный металл',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Цветной металл',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Микс',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
