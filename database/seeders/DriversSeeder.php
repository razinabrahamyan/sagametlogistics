<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;

class DriversSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Driver::insertOrIgnore([
            [
                "full_name"   => "Степанян Владимир Карапетович",
                "status"      => 7,
                "phone"       => "79779798898",
                "type_id"     => 3,
                "car_numbers" => "М456ВМ 29",
            ],
            [
                "full_name"   => "Мелконян Арутюн Гамлетович",
                "status"      => 7,
                "phone"       => "79857110530",
                "type_id"     => 3,
                "car_numbers" => "Н181ВВ 777",
            ],
            [
                "full_name"   => "Руслан",
                "status"      => 7,
                "phone"       => "79771033759",
                "type_id"     => 2,
                "car_numbers" => "Н216РС 750",
            ],
            [
                "full_name"   => "Манукян Саргис Самвелович",
                "status"      => 7,
                "phone"       => "79031899093",
                "type_id"     => 2,
                "car_numbers" => "Х576ТА 750",
            ],
            [
                "full_name"   => "Давтян Артур Нверович",
                "status"      => 7,
                "phone"       => "79260895989",
                "type_id"     => 3,
                "car_numbers" => "В184ТУ 750",
            ],
            [
                "full_name"   => "Оганнисян Геворг Ваганович",
                "status"      => 7,
                "phone"       => "79775919126",
                "type_id"     => 1,
                "car_numbers" => "Р170ХУ 86",
            ],
            [
                "full_name"   => "Зандарян Нодар Гришаевич",
                "status"      => 7,
                "phone"       => "79031421745",
                "type_id"     => 1,
                "car_numbers" => "Т539СУ 750",
            ],
            [
                "full_name"   => "Асатрян Зорайр Корюнович",
                "status"      => 7,
                "phone"       => "79268608081",
                "type_id"     => 1,
                "car_numbers" => "А127УК 750",
            ],
            [
                "full_name"   => "Оганнисян Эдвард Ваганович",
                "status"      => 7,
                "phone"       => "79268608081",
                "type_id"     => 1,
                "car_numbers" => "М381ТМ 750",
            ],
            [
                "full_name"   => "Сос",
                "status"      => 7,
                "phone"       => "79152559192",
                "type_id"     => 3,
                "car_numbers" => "Е249ХМ 750",
            ],
            [
                "full_name"   => "Зедгинидзе Карлен Шакроевич",
                "status"      => 7,
                "phone"       => "79199995582",
                "type_id"     => 3,
                "car_numbers" => "М885ЕХ 750",
            ],
            [
                "full_name"   => "Аветисян Акоб Араратович",
                "status"      => 7,
                "phone"       => "79166496049",
                "type_id"     => 4,
                "car_numbers" => "Т889ХМ 750",
            ],
            [
                "full_name"   => "Адлоян Варданик",
                "status"      => 7,
                "phone"       => "79253355117",
                "type_id"     => 1,
                "car_numbers" => "Е748ХТ 750",
            ],
            [
                "full_name"   => "Мовсесян Карен Валериевич",
                "status"      => 7,
                "phone"       => "79265949115",
                "type_id"     => 1,
                "car_numbers" => "Е771ХТ 750",
            ],
            [
                "full_name"   => "Кондрашов Николай Викторович",
                "status"      => 7,
                "phone"       => "79281732708",
                "type_id"     => 4,
                "car_numbers" => "Е628НВ 123",
            ],
            [
                "full_name"   => "Самвел",
                "status"      => 7,
                "phone"       => "79854784780",
                "type_id"     => 3,
                "car_numbers" => "Х943ХК 750",
            ],
            [
                "full_name"   => "Давтян Нвер Андраникович",
                "status"      => 7,
                "phone"       => "79998581961",
                "type_id"     => 1,
                "car_numbers" => "Х625ХЕ 750",
            ],
            [
                "full_name"   => "Полоян Сергей",
                "status"      => 7,
                "phone"       => "79892327903",
                "type_id"     => 1,
                "car_numbers" => "Т002АУ 790",
            ],
            [
                "full_name"   => "Дженебян Роберт Жирайрович",
                "status"      => 7,
                "phone"       => "79778507470",
                "type_id"     => 1,
                "car_numbers" => "Т094АУ 790",
            ],
            [
                "full_name"   => "Малхасян Эдвард Гагикович",
                "status"      => 7,
                "phone"       => "79253344480",
                "type_id"     => 2,
                "car_numbers" => "Т252АУ 790",
            ],
            [
                "full_name"   => "Ашот",
                "status"      => 7,
                "phone"       => "79998669909",
                "type_id"     => 3,
                "car_numbers" => "О314АХ 790",
            ],
            [
                "full_name"   => "Мосоян Лева Меружанович",
                "status"      => 7,
                "phone"       => "79656605452",
                "type_id"     => 1,
                "car_numbers" => "К672АА 790",
            ],
            [
                "full_name"   => "Чиркинян Тигран Валерикович",
                "status"      => 7,
                "phone"       => "79154824606",
                "type_id"     => 1,
                "car_numbers" => "А673ВМ 790",
            ],
            [
                "full_name"   => "Саркисян Размик Григорьевич",
                "status"      => 7,
                "phone"       => "79154824606",
                "type_id"     => 1,
                "car_numbers" => "Н347АТ 790",
            ],
            [
                "full_name"   => "Восканян Амбарцум Мамбреович",
                "status"      => 7,
                "phone"       => "79166186968",
                "type_id"     => 3,
                "car_numbers" => "Н360АТ 790",
            ],
            [
                "full_name"   => "Миронов Виктор Федорович",
                "status"      => 7,
                "phone"       => "79099086706",
                "type_id"     => 4,
                "car_numbers" => "Н341АТ 790",
            ],
            [
                "full_name"   => "Дженабян Эдуард Арутюнович",
                "status"      => 7,
                "phone"       => "79184745741",
                "type_id"     => 1,
                "car_numbers" => "О118АО 790",
            ],
            [
                "full_name"   => "Хачатрян Арсен Рафикович",
                "status"      => 7,
                "phone"       => "79265575876",
                "type_id"     => 1,
                "car_numbers" => "О832ВО 790",
            ],
            [
                "full_name"   => "Хачатарян Артак Рафикович",
                "status"      => 7,
                "phone"       => "79684332974",
                "type_id"     => 1,
                "car_numbers" => "Н253ВУ 790",
            ],
            [
                "full_name"   => "Антонян Нельсон Степанович",
                "status"      => 7,
                "phone"       => "79161267346",
                "type_id"     => 1,
                "car_numbers" => "Р761ВТ 790",
            ],
            [
                "full_name"   => "Тестовый водитель ВАЛДАЙ",
                "status"      => 7,
                "phone"       => "79169672786",
                "type_id"     => 1,
                "car_numbers" => "A111AA",
            ],
            [
                "full_name"   => "Тестовый водитель Камаз",
                "status"      => 7,
                "phone"       => "79169672786",
                "type_id"     => 3,
                "car_numbers" => "A111AA",
            ],
            [
                "full_name"   => "Тигран",
                "status"      => 7,
                "phone"       => "79637127860",
                "type_id"     => 1,
                "car_numbers" => "069",
            ],
            [
                "full_name"   => "Артем",
                "status"      => 7,
                "phone"       => "79189990313",
                "type_id"     => 1,
                "car_numbers" => "979",
            ],
            [
                "full_name"   => "Манвел",
                "status"      => 7,
                "phone"       => "995555996466",
                "type_id"     => 1,
                "car_numbers" => "006",
            ],
            [
                "full_name"   => "Дядь Самвел",
                "status"      => 7,
                "phone"       => "79953450648",
                "type_id"     => 1,
                "car_numbers" => "364",
            ],
            [
                "full_name"   => "Артур (Кяж)",
                "status"      => 7,
                "phone"       => "79067235856",
                "type_id"     => 1,
                "car_numbers" => "651",
            ],
            [
                "full_name"   => "Ягор",
                "status"      => 7,
                "phone"       => "79944444240",
                "type_id"     => 4,
                "car_numbers" => "689",
            ],
            [
                "full_name"   => "Норик",
                "status"      => 7,
                "phone"       => "79858726226",
                "type_id"     => 3,
                "car_numbers" => "792",
            ],
            [
                "full_name"   => "Андо",
                "status"      => 7,
                "phone"       => "79645107087",
                "type_id"     => 2,
                "car_numbers" => "703",
            ],
        ]);
    }
}
