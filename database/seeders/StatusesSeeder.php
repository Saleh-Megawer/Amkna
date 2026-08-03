<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesSeeder extends Seeder
{
    public function run()
    {
        DB::table('statuses')->insert([
            [
                'name'  => 'جديد',
                'slug'  => 'new',
                'type'  => 'client',
                'color' => '#ffc107',
            ],

            [
                'name'  => 'تم التواصل',
                'slug'  => 'contacted',
                'type'  => 'client',
                'color' => '#9c27b0',
            ],
            [
                'name'  => 'زيارة',
                'slug'  => 'visited',
                'type'  => 'client',
                'color' => '#ff5d33',
            ],
            [
                'name'  => 'تفاوض',
                'slug'  => 'negotiation',
                'type'  => 'client',
                'color' => '#5d2cff',
            ],
            [
                'name'  => 'مكتمل',
                'slug'  => 'completed',
                'type'  => 'client',
                'color' => '#8bc34a',
            ],
            [
                'name'  => 'خسارة',
                'slug'  => 'lost',
                'type'  => 'client',
                'color' => '#ed1818ff',
            ],
            // // 🏠 حالات العقارات
            // ['name' => 'متاح', 'slug' => 'available', 'type' => 'property', 'color' => '#38c172'],
            // ['name' => 'محجوز', 'slug' => 'reserved', 'type' => 'property', 'color' => '#ffed4a'],
            // ['name' => 'مباع', 'slug' => 'sold', 'type' => 'property', 'color' => '#e3342f'],
        ]);
    }
}
