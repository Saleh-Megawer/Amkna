<?php
namespace Database\Seeders;

use App\Models\Property\PropertyFacade;
use Illuminate\Database\Seeder;

class PropertyFacadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // English values disabled - app is Arabic only
        $facades = [
            ['slug' => 'north', 'ar' => 'شمالية'], // 'en' => 'North'
            ['slug' => 'east', 'ar' => 'شرقية'], // 'en' => 'East'
            ['slug' => 'east-west', 'ar' => 'شرقية غربية'], // 'en' => 'East West'
            ['slug' => 'west', 'ar' => 'غربية'], // 'en' => 'West'
            ['slug' => 'south', 'ar' => 'جنوبية'], // 'en' => 'South'
            ['slug' => 'north-east', 'ar' => 'شمالية شرقية'], // 'en' => 'North East'
            ['slug' => 'north-west', 'ar' => 'شمالية غربية'], // 'en' => 'North West'
            ['slug' => 'south-east', 'ar' => 'جنوبية شرقية'], // 'en' => 'South East'
            ['slug' => 'south-west', 'ar' => 'جنوبية غربية'], // 'en' => 'South West'

            ['slug' => 'north-south', 'ar' => 'شمالية جنوبية'], // 'en' => 'North South'
            ['slug' => 'north-south-east', 'ar' => 'شمالية جنوبية شرقية'], // 'en' => 'North South East'
            ['slug' => 'north-south-west', 'ar' => 'شمالية جنوبية غربية'], // 'en' => 'North South West'

            ['slug' => 'east-south', 'ar' => 'شرقية جنوبية'], // 'en' => 'East South'
            ['slug' => 'east-south-west', 'ar' => 'شرقية جنوبية غربية'], // 'en' => 'East South West'
            ['slug' => 'south-east-west', 'ar' => 'جنوبية شرقية غربية'], // 'en' => 'South East West'

            ['slug' => 'north-east-west', 'ar' => 'شمالية شرقية غربية'], // 'en' => 'North East West'
            ['slug' => 'north-south-east-west', 'ar' => 'شمالية جنوبية شرقية غربية'], // 'en' => 'North South East West'
        ];

        foreach ($facades as $item) {

            $facade = PropertyFacade::create([
                'slug' => $item['slug'],
            ]);

            $facade->translateOrNew('ar')->name = $item['ar'];
            // $facade->translateOrNew('en')->name = $item['en']; // English disabled - app is Arabic only
            $facade->save();
        }
    }

    
}
