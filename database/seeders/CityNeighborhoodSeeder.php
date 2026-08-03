<?php
namespace Database\Seeders;

use App\Models\City;
use App\Models\Neighborhood;
use Illuminate\Database\Seeder;

class CityNeighborhoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $cities = City::count();

        if ($cities == 0) {

            $list = [
                ['ar' => 'الجيزة', 'en' => 'Giza'],
                ['ar' => 'القاهرة', 'en' => 'Cairo'],
            ];

            foreach ($list as $city) {
                City::create([
                    'ar' => ['name' => $city['ar']],
                   // 'en' => ['name' => $city['en']],
                ]);
            }

            $cities_neighborhoods = [
                "الجيزة"  => [
                    ['ar' => '6 اكتوبر', 'en' => '6 October'],
                    ['ar' => 'الشيخ زايد', 'en' => '6 October'],
                    ['ar' => 'الهرم', 'en' => 'Haram'],
                    ['ar' => 'الدقي', 'en' => 'Dokki'],
                    ['ar' => 'فيصل', 'en' => 'Faisal'],
                ],

                "القاهرة" => [
                    ['ar' => 'الزمالك', 'en' => 'Zamalek'],
                    ['ar' => 'المعادي', 'en' => 'Maadi'],
                    ['ar' => 'مصر الجديدة', 'en' => 'Heliopolis'],
                    ['ar' => 'المهندسين', 'en' => 'Mohandessin'],
                    ['ar' => 'مدينة نصر', 'en' => 'Nasr City'],
                ],
            ];

            foreach ($cities_neighborhoods as $cityName => $neighborhoods) {
                $city = City::whereTranslation('name', $cityName, 'ar')->first();

                if ($city) {
                    $loopIndex = 1;
                    foreach ($neighborhoods as $hood) {
                        Neighborhood::create([
                            'city_id' => $city->id,
                            'image'   => $loopIndex . '.webp',
                            'ar'      => ['name' => $hood['ar']],
                           // 'en'      => ['name' => $hood['en']],
                        ]);
                        $loopIndex++;
                    }
                }

            }
        }

    }
}
