<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeed extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        (new Role())::insert([
            [
                "title"      => "Админ",
                "title_en"   => "Admin",
                "status"     => 1,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "title"      => "Логист",
                "title_en"   => "Logist",
                "status"     => 1,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "title"      => "Менеджер",
                "title_en"   => "Manager",
                "status"     => 1,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "title"      => "Персонал логистики",
                "title_en"   => "Logistics personnel",
                "status"     => 1,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "title"      => "Ответственный по водителям",
                "title_en"   => "Responsible for drivers",
                "status"     => 1,
                "created_at" => now(),
                "updated_at" => now(),
            ]
        ]);
    }
}
