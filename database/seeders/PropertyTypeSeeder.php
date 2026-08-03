<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property\PropertyType;

class PropertyTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [

            [
                'ar' => ['name' => 'شقة'],
               // 'en' => ['name' => 'Apartment'],
            ],
            [
                'ar' => ['name' => 'فيلا'],
               // 'en' => ['name' => 'Villa'],
            ],
            [
                'ar' => ['name' => 'دوبلكس'],
               // 'en' => ['name' => 'Duplex'],
            ],
            [
                'ar' => ['name' => 'روف'],
              //  'en' => ['name' => 'Penthouse'],
            ],
            [
                'ar' => ['name' => 'ستوديو'],
              //  'en' => ['name' => 'Studio'],
            ],
            // [
            //     'ar' => ['name' => 'عمارة سكنية'],
            //     'en' => ['name' => 'Residential Building'],
            // ],
            [
                'ar' => ['name' => 'محل تجاري'],
              //  'en' => ['name' => 'Shop'],
            ],
            [
                'ar' => ['name' => 'معرض تجاري'],
               // 'en' => ['name' => 'Showroom'],
            ],
            [
                'ar' => ['name' => 'مكتب إداري'],
               // 'en' => ['name' => 'Office'],
            ],
            [
                'ar' => ['name' => 'عيادة'],
                //'en' => ['name' => 'Clinic'],
            ],
            [
                'ar' => ['name' => 'صيدلية'],
              //  'en' => ['name' => 'Pharmacy'],
            ],
            // [
            //     'ar' => ['name' => 'مخزن'],
            //     'en' => ['name' => 'Warehouse'],
            // ],
            // [
            //     'ar' => ['name' => 'مصنع'],
            //     'en' => ['name' => 'Factory'],
            // ],
            // [
            //     'ar' => ['name' => 'أرض سكنية'],
            //     'en' => ['name' => 'Residential Land'],
            // ],
            // [
            //     'ar' => ['name' => 'أرض تجارية'],
            //     'en' => ['name' => 'Commercial Land'],
            // ],
            // [
            //     'ar' => ['name' => 'أرض زراعية'],
            //     'en' => ['name' => 'Agricultural Land'],
            // ],
        ];

        foreach ($types as $type) {
            PropertyType::create($type);
        }
    }
}
