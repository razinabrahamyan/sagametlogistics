<?php

namespace Database\Seeders;

use App\Classes\Helpers\GF;
use App\Models\HlrPhone;
use Illuminate\Database\Seeder;

class HLRPhonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phones = [
            '+7 499 938-54-32',
            '8 999 333-47-09',
            '8 495 414-11-70',
            '8 499 938-40-90',
            '8 966 666-70-97',
            '8 999 333-14-68',
            '8 966 666-56-90',
            '8 999 333-16-84',
            '8 499 938-66-97',
            '8 499 938-92-12',
            '8 495 118-33-50',
            '8 499 938-80-63',
            '8 495 414-16-81',
            '8 499 938-94-24 ',
            '8 495 414-22-06',
            '8 495 118-27-84',
            '8 495 118-30-49',
            '8 495 118-38-21',
            '8 499 938-71-04',
            '8 499 938-71-87',
            '8 495 118-21-80',
            '8 495 118-25-48',
            '8 495 118-20-63',
            '8 495 118-22-43',
            '8 495 118-22-74',
            '8 495 414-28-19',
            '8 499 938-74-26',
            '8 495 118-34-55',
            '8 495 118-40-27',
            '8 495 414-11-14',
            '8 495 118-39-27',
            '8 495 118-30-65',
            '8 495 118-39-71',
            '8 495 414-25-78',
            '8 495 118-42-39',
            '8 495 118-42-71',
            '8 495 118-34-50',
            '8 495 118-30-21',
            ' 8 495 118-35-28',
            '8 495 118-39-98',
            '8 495 414-23-58',
            '8 495 118-29-72',
            '8 495 414-16-48',
            '8 495 118-29-76',
            '8 495 118-41-05',
            '8 495 414-27-83',
            '8 495 118-32-56',
            '8 495 414-22-58',
            '8 495 414-10-98',
            '8 495 118-34-81',
            '8 495 414-16-90',
            '8 495 118-25-39',
            '8 495 118-36-79',
            '8 495 118-40-20',
            '8 495 414-15-45',
            '8 999 333-16-58',
            '8 925 921-06-83',
            '8 926 007-12-88',
            '8 925 921-06-76',
            '8 925 921-06-71',
            '8 925 921-06-86',
            '8 926 007-16-48',
            '8 925 016-49-67',
            '8 925 921-06-82',
            '8 925 016-39-16',
            '8 925 921-06-84',
            '8 925 921-06-69',
            '8 925 016-37-97',
            '8 926 000-64-22',
            '8 925 921-06-74',
            '8 925 017-45-81',
            '8 925 017-08-81',
            '8 926 007-16-10',
            '8 925 921-06-81',
            '8 925 017-44-45',
            '8 926 007-16-48',
            '8 495 118 33 50',
            '  8 499 938 94 24',
            '  8 499 938 80 63',
            '  8 499 938 92 12',
            '  8 495 414 16 81',
            '  8 925 921 06 76',
            ' 8 925 921 06 82',
            '  8 999 333 14 68',
            '  8 499 938 40 90',
            '  8 495 118 39 98',
            '  8 999 333 47 09',
            '  8 966 666-56-90',
            '  8 968 930 05 01',
            '  8 968 930 05 02',
            '  8 968 930 05 03',
            '  8 925 433 35 56',
            '  8 925 431 06 82',
            ' 8 925 431 05 70',
            ' 8 925 431 04 62',
            ' 8 925 430-79-77',
        ];

        foreach ($phones as $phone) {
            $phone = GF::normalizeOnePhone(GF::clearPhoneNumber($phone));
            if (empty(HlrPhone::where('phone', $phone)->first()) && $phone[1] != 4) {
                HlrPhone::create([
                    'phone' => (int)$phone,
                ]);
            }
        }
    }
}
