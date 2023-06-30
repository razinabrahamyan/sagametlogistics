<?php

namespace Database\Seeders;

use App\Models\Query;
use Illuminate\Database\Seeder;
use Psy\Util\Str;

class QuerySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 20; $i++) {
            Query::insert([
                "status"               => rand(1, 6),
                "client_name"          => "Артур $i",
                "departure_date"       => date('Y-m-d H:i:s', strtotime(now()) + rand(0, 3600 * 24 * 3)),
                "phone"                => "79169672786",
                "need_call_client"     => "1",
                "regular_client"       => "1",
                "address"              => "Dominican Republic",
                "address_points"       => '{"longitude":37.754272,"latitude":55.444794}',
                "photos"               => null,
                "videos"               => null,
                "type_of_metal"        => "1",
                "price"                => rand(20000,24000),
                "weight"               => rand(1000,3000),
                "oxygen_count"         => rand(0,3),
                "loaders_count"        => rand(0,3),
                "cutters_count"        => rand(0,3),
                "machines"             => '{"valdai":{"count":"1","drivers":["31"]},"kamaz":{"count":"0","drivers":[]},"maz":{"count":"0","drivers":[]},"man":{"count":"0","drivers":[]}}',
                "base_address"         => "Наша база",
                "is_client_need_video" => "0",
                "comment"              => "Коммент $i",
                "user_id"              => rand(4, 6),
                "created_at"           => date('Y-m-d H:i:s', strtotime(now()) - rand(0, 3600 * 24 * 365)),
                'updated_at'           => now(),
                "access_token"         => \Illuminate\Support\Str::random(60),
                "scrap"         => \Illuminate\Support\Str::random(60),
            ]);
        }
    }
}
