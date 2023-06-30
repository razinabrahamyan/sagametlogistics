<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(UserSeeder::class);
        $this->call(DriversSeeder::class);
        $this->call(MachinesSeeder::class);
        $this->call(RoleSeed::class);
        $this->call(StatusesSeeder::class);
        $this->call(BasesSeed::class);
        $this->call(MetaltypesSeed::class);
        $this->call(QuerySeed::class);
//        $this->call(DepertureSeeder::class);
//        $this->call(NewDriverUserSeeder::class);
    }
}
