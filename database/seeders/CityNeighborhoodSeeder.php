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

            // English values disabled - app is Arabic only
            $list = [
                ['ar' => 'الجيزة'],
                ['ar' => 'القاهرة'],
            ];

            foreach ($list as $city) {
                City::create([
                    'ar' => ['name' => $city['ar']],
                   // 'en' => ['name' => $city['en']],
                ]);
            }

            $cities_neighborhoods = [
                "الجيزة"  => [
                    ['ar' => '6 اكتوبر'],
                    ['ar' => 'الشيخ زايد'],
                    ['ar' => 'الهرم'],
                    ['ar' => 'الدقي'],
                    ['ar' => 'فيصل'],
                ],

                "القاهرة" => [
                    ['ar' => 'الزمالك'],
                    ['ar' => 'المعادي'],
                    ['ar' => 'مصر الجديدة'],
                    ['ar' => 'المهندسين'],
                    ['ar' => 'مدينة نصر'],
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
