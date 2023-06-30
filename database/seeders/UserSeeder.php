<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        (new User())::insertOrIgnore([
            [
                "name"       => 'Логист Тестовый',
                "email"      => 'smnnartur1@gmail.com',
                "phone"      => '+79169672786',
                "password"   => bcrypt('alfa12345'),
                "role_id"    => 2,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Админ',
                "email"      => 'smnnartur3@gmail.com',
                "phone"      => '+79169672786',
                "password"   => bcrypt('alfa12345'),
                "role_id"    => 1,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Менеджер Тестовый',
                "email"      => 'smnnartur2@gmail.com',
                "phone"      => '+79169672786',
                "password"   => bcrypt('alfa12345'),
                "role_id"    => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Акоб Тоноян',
                "email"      => 'a.tonoyan@mail.ru',
                "phone"      => '+79648355547',
                "password"   => bcrypt('Jc64VV6D'),
                "role_id"    => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Максим Мухин',
                "email"      => 'maksim121292@gmail.com',
                "phone"      => '+79637585239',
                "password"   => bcrypt('HrRXn6mf'),
                "role_id"    => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Александр Вавилов',
                "email"      => 'aleksander.saw1@yandex.ru',
                "phone"      => '+79096896512',
                "password"   => bcrypt('j39jDbKp'),
                "role_id"    => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Григорий',
                "email"      => 'smnned@gmail.com',
                "phone"      => '+79645172000',
                "password"   => bcrypt('K5o1hP5J'),
                "role_id"    => 2,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Руслан Григорьев',
                "email"      => 'ruslanGrigoriev357@yandex.ru',
                "phone"      => '+79645172000',
                "password"   => bcrypt('fnXt9l3x'),
                "role_id"    => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Мгер',
                "email"      => 'mher.logistics1@yandex.ru',
                "phone"      => '+79645172000',
                "password"   => bcrypt('ngC6K1XV'),
                "role_id"    => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Кирил',
                "email"      => 'kiril.logistics1@yandex.ru',
                "phone"      => '+79645172000',
                "password"   => bcrypt('QQcZqAYt'),
                "role_id"    => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Араик',
                "email"      => 'araik.logistics1@yandex.ru',
                "phone"      => '+79645172000',
                "password"   => bcrypt('JnyjrvCy'),
                "role_id"    => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Стас',
                "email"      => 'stas.logistics1@yandex.ru',
                "phone"      => '+79645172000',
                "password"   => bcrypt('0YvM3Hp3'),
                "role_id"    => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Максим Базаров',
                "email"      => 'maksim.bazarov.logistics1@yandex.ru',
                "phone"      => '+79645172000',
                "password"   => bcrypt('2bgxYj4j'),
                "role_id"    => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Анна',
                "email"      => 'anna.logistics1@yandex.ru',
                "phone"      => '+79645172000',
                "password"   => bcrypt('esX3OJSJ'),
                "role_id"    => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Григорий Иванов',
                "email"      => 'g.ivanov@metallolom1.ru',
                "phone"      => '+79645172000',
                "password"   => bcrypt('esX3OJ12'),
                "role_id"    => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Тестовый персонал',
                "email"      => 'testpersonal@gmail.ru',
                "phone"      => '+79645172000',
                "password"   => bcrypt('alfa12345'),
                "role_id"    => 4,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Гриша',
                "email"      => 'grish.grigoryan98@gmail.com',
                "phone"      => '+79296773102',
                "password"   => bcrypt('esX3OJSJ'),
                "role_id"    => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => 'Норо',
                "email"      => 'noro.logistics@yandex.ru',
                "phone"      => '+79858728226',
                "password"   => bcrypt('esX3OJSJ'),
                "role_id"    => 5,
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ]);
    }

    public function role() {
        return $this->belongsTo('App\Role', 'role');
    }
}
