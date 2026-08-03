<?php
namespace Database\Seeders;

use App\Models\Property\PropertyFeature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyFeatureSeeder extends Seeder
{
    public function run()
    {
        $features = [
            [
                'slug'         => 'sea-view',
                'translations' => [
                    // 'en' => 'Sea View', // English disabled - app is Arabic only
                    'ar' => 'إطلالة على البحر',
                ],
            ],
            [
                'slug'         => 'street-view',
                'translations' => [
                    // 'en' => 'Street View', // English disabled - app is Arabic only
                    'ar' => 'إطلالة على الشارع',
                ],
            ],
            [
                'slug'         => 'balcony',
                'translations' => [
                    // 'en' => 'Balcony', // English disabled - app is Arabic only
                    'ar' => 'بلكونة',
                ],
            ],
            [
                'slug'         => 'private-garden',
                'translations' => [
                    // 'en' => 'Private Garden', // English disabled - app is Arabic only
                    'ar' => 'حديقة خاصة',
                ],
            ],
            [
                'slug'         => 'high-ceiling',
                'translations' => [
                    // 'en' => 'High Ceiling', // English disabled - app is Arabic only
                    'ar' => 'أسقف عالية',
                ],
            ],
            [
                'slug'         => 'natural-light',
                'translations' => [
                    // 'en' => 'Natural Light', // English disabled - app is Arabic only
                    'ar' => 'إضاءة طبيعية',
                ],
            ],
            [
                'slug'         => 'double-glazing',
                'translations' => [
                    // 'en' => 'Double Glazing', // English disabled - app is Arabic only
                    'ar' => 'زجاج مزدوج',
                ],
            ],
            [
                'slug'         => 'built-in-wardrobes',
                'translations' => [
                    // 'en' => 'Built-in Wardrobes', // English disabled - app is Arabic only
                    'ar' => 'دواليب مدمجة',
                ],
            ],
            [
                'slug'         => 'smart-home',
                'translations' => [
                    // 'en' => 'Smart Home', // English disabled - app is Arabic only
                    'ar' => 'منزل ذكي',
                ],
            ],
            [
                'slug'         => 'central-heating',
                'translations' => [
                    // 'en' => 'Central Heating', // English disabled - app is Arabic only
                    'ar' => 'تدفئة مركزية',
                ],
            ],
            [
                'slug'         => 'marble-floor',
                'translations' => [
                    // 'en' => 'Marble Floor', // English disabled - app is Arabic only
                    'ar' => 'أرضيات رخام',
                ],
            ],
            [
                'slug'         => 'wooden-floor',
                'translations' => [
                    // 'en' => 'Wooden Floor', // English disabled - app is Arabic only
                    'ar' => 'أرضيات خشب',
                ],
            ],
        ];

        foreach ($features as $item) {
            $feature = PropertyFeature::create([
                'slug'       => $item['slug'],
                'created_by' => null,
            ]);

            foreach ($item['translations'] as $locale => $name) {
                DB::table('property_feature_translations')->insert([
                    'property_feature_id' => $feature->id,
                    'locale'              => $locale,
                    'name'                => $name,
                ]);
            }
        }
    }
}
