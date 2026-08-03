<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property\FinishingType;
use App\Models\Property\PropertyFinishingType;

class FinishingTypeSeeder extends Seeder
{
    public function run()
    {
        
        $types = [
            [
                'slug' => 'no-finish',
                'ar'   => 'بدون تشطيب',
                // 'en'   => 'No Finish', // English disabled - app is Arabic only
            ],
            [
                'slug' => 'half-finish',
                'ar'   => 'نصف تشطيب',
                // 'en'   => 'Half Finished', // English disabled - app is Arabic only
            ],
            [
                'slug' => 'full-finish',
                'ar'   => 'تشطيب كامل',
                // 'en'   => 'Fully Finished', // English disabled - app is Arabic only
            ],
            [
                'slug' => 'super-lux',
                'ar'   => 'سوبر لوكس',
                // 'en'   => 'Super Lux', // English disabled - app is Arabic only
            ],
            [
                'slug' => 'ultra-super-lux',
                'ar'   => 'ألترا سوبر لوكس',
                // 'en'   => 'Ultra Super Lux', // English disabled - app is Arabic only
            ],
        ];

        foreach ($types as $item) {

            $type = PropertyFinishingType::create([
                'slug' => $item['slug'],
            ]);

            $type->translateOrNew('ar')->name = $item['ar'];
            // $type->translateOrNew('en')->name = $item['en']; // English disabled - app is Arabic only

            $type->save();
        }
    }
}
