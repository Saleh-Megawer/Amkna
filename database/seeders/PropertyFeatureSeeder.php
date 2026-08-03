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
                    'en' => 'Sea View',
                    'ar' => 'إطلالة على البحر',
                ],
            ],
            [
                'slug'         => 'street-view',
                'translations' => [
                    'en' => 'Street View',
                    'ar' => 'إطلالة على الشارع',
                ],
            ],
            [
                'slug'         => 'balcony',
                'translations' => [
                    'en' => 'Balcony',
                    'ar' => 'بلكونة',
                ],
            ],
            [
                'slug'         => 'private-garden',
                'translations' => [
                    'en' => 'Private Garden',
                    'ar' => 'حديقة خاصة',
                ],
            ],
            [
                'slug'         => 'high-ceiling',
                'translations' => [
                    'en' => 'High Ceiling',
                    'ar' => 'أسقف عالية',
                ],
            ],
            [
                'slug'         => 'natural-light',
                'translations' => [
                    'en' => 'Natural Light',
                    'ar' => 'إضاءة طبيعية',
                ],
            ],
            [
                'slug'         => 'double-glazing',
                'translations' => [
                    'en' => 'Double Glazing',
                    'ar' => 'زجاج مزدوج',
                ],
            ],
            [
                'slug'         => 'built-in-wardrobes',
                'translations' => [
                    'en' => 'Built-in Wardrobes',
                    'ar' => 'دواليب مدمجة',
                ],
            ],
            [
                'slug'         => 'smart-home',
                'translations' => [
                    'en' => 'Smart Home',
                    'ar' => 'منزل ذكي',
                ],
            ],
            [
                'slug'         => 'central-heating',
                'translations' => [
                    'en' => 'Central Heating',
                    'ar' => 'تدفئة مركزية',
                ],
            ],
            [
                'slug'         => 'marble-floor',
                'translations' => [
                    'en' => 'Marble Floor',
                    'ar' => 'أرضيات رخام',
                ],
            ],
            [
                'slug'         => 'wooden-floor',
                'translations' => [
                    'en' => 'Wooden Floor',
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
