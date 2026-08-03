<?php
namespace Database\Seeders;

use App\Models\Property\PropertyAmenity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyAmenitySeeder extends Seeder
{
    public function run()
    {
        
        $amenities = [
            [
                'slug'         => 'parking',
                'translations' => [
                    'en' => 'Parking',
                    'ar' => 'موقف سيارات',
                ],
            ],
            [
                'slug'         => 'security',
                'translations' => [
                    'en' => 'Security',
                    'ar' => 'أمن وحراسة',
                ],
            ],
            [
                'slug'         => 'elevator',
                'translations' => [
                    'en' => 'Elevator',
                    'ar' => 'مصعد',
                ],
            ],
            [
                'slug'         => 'maintenance',
                'translations' => [
                    'en' => 'Maintenance',
                    'ar' => 'صيانة',
                ],
            ],
            [
                'slug'         => 'cleaning',
                'translations' => [
                    'en' => 'Cleaning Service',
                    'ar' => 'خدمة نظافة',
                ],
            ],
            [
                'slug'         => 'backup-generator',
                'translations' => [
                    'en' => 'Backup Generator',
                    'ar' => 'مولد كهرباء احتياطي',
                ],
            ],
            [
                'slug'         => 'fire-system',
                'translations' => [
                    'en' => 'Fire System',
                    'ar' => 'نظام إطفاء حريق',
                ],
            ],
            [
                'slug'         => 'central-reception',
                'translations' => [
                    'en' => 'Reception',
                    'ar' => 'استقبال',
                ],
            ],
            [
                'slug'         => 'central-ac',
                'translations' => [
                    'en' => 'Central Air Conditioning',
                    'ar' => 'تكييف مركزي',
                ],
            ],
            [
                'slug'         => 'disabled-access',
                'translations' => [
                    'en' => 'Disabled Access',
                    'ar' => 'مداخل لذوي الاحتياجات الخاصة',
                ],
            ],
            [
                'slug'         => 'storage',
                'translations' => [
                    'en' => 'Storage Rooms',
                    'ar' => 'مخازن',
                ],
            ],
            [
                'slug'         => 'solar-power',
                'translations' => [
                    'en' => 'Solar Power',
                    'ar' => 'طاقة شمسية',
                ],
            ],
        ];

        foreach ($amenities as $item) {
            $amenity = PropertyAmenity::create([
                'slug'       => $item['slug'],
                'created_by' => null,
            ]);

            foreach ($item['translations'] as $locale => $name) {
                DB::table('property_amenity_translations')->insert([
                    'property_amenity_id' => $amenity->id,
                    'locale'              => $locale,
                    'name'                => $name,
                ]);
            }
        }
    }
}
