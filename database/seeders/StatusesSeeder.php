<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Status::insert([
            [
                'title'      => 'Новая',
                'color'      => '#403294',
                'type'       => 'query',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Отправлено',
                'color'      => '#36B37E',
                'type'       => 'query',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'На удержании',
                'color'      => '#9ea7ad',
                'type'       => 'query',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Обработано',
                'color'      => '#0747A6',
                'type'       => 'query',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Срочно',
                'color'      => '#ffb302',
                'type'       => 'query',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title'      => 'Отменено',
                'color'      => '#dc143c',
                'type'       => 'query',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
