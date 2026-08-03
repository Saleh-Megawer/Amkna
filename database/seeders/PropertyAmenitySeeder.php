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
                    // 'en' => 'Parking', // English disabled - app is Arabic only
                    'ar' => 'موقف سيارات',
                ],
            ],
            [
                'slug'         => 'security',
                'translations' => [
                    // 'en' => 'Security', // English disabled - app is Arabic only
                    'ar' => 'أمن وحراسة',
                ],
            ],
            [
                'slug'         => 'elevator',
                'translations' => [
                    // 'en' => 'Elevator', // English disabled - app is Arabic only
                    'ar' => 'مصعد',
                ],
            ],
            [
                'slug'         => 'maintenance',
                'translations' => [
                    // 'en' => 'Maintenance', // English disabled - app is Arabic only
                    'ar' => 'صيانة',
                ],
            ],
            [
                'slug'         => 'cleaning',
                'translations' => [
                    // 'en' => 'Cleaning Service', // English disabled - app is Arabic only
                    'ar' => 'خدمة نظافة',
                ],
            ],
            [
                'slug'         => 'backup-generator',
                'translations' => [
                    // 'en' => 'Backup Generator', // English disabled - app is Arabic only
                    'ar' => 'مولد كهرباء احتياطي',
                ],
            ],
            [
                'slug'         => 'fire-system',
                'translations' => [
                    // 'en' => 'Fire System', // English disabled - app is Arabic only
                    'ar' => 'نظام إطفاء حريق',
                ],
            ],
            [
                'slug'         => 'central-reception',
                'translations' => [
                    // 'en' => 'Reception', // English disabled - app is Arabic only
                    'ar' => 'استقبال',
                ],
            ],
            [
                'slug'         => 'central-ac',
                'translations' => [
                    // 'en' => 'Central Air Conditioning', // English disabled - app is Arabic only
                    'ar' => 'تكييف مركزي',
                ],
            ],
            [
                'slug'         => 'disabled-access',
                'translations' => [
                    // 'en' => 'Disabled Access', // English disabled - app is Arabic only
                    'ar' => 'مداخل لذوي الاحتياجات الخاصة',
                ],
            ],
            [
                'slug'         => 'storage',
                'translations' => [
                    // 'en' => 'Storage Rooms', // English disabled - app is Arabic only
                    'ar' => 'مخازن',
                ],
            ],
            [
                'slug'         => 'solar-power',
                'translations' => [
                    // 'en' => 'Solar Power', // English disabled - app is Arabic only
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
