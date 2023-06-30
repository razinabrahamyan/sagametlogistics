<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DepertureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::table('drivers', function ($table) {
            $table->integer('user_id')->default(0)->after('type_id')->index('drivers_user_id_index');
        });

        Driver::find(31)->update([
            'user_id' => 16,
        ]);
    }
}
