<?php

namespace Database\Seeders;

use App\Models\Dashboard\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            [
                'name' => 'VIP',
                'color' => '#FFD700',
                'type'  => 'client',
            ],
            [
                'name' => 'مهتم بالعروض',
                'color' => '#28A745',
                'type'  => 'client',
            ],
            [
                'name' => 'تم البيع',
                'color' => '#007BFF',
                'type'  => 'client',
            ],
            [
                'name' => 'محجوز',
                'color' => '#DC3545',
                'type'  => 'client',
            ],
            [
                'name' => 'متابعة لاحقة',
                'color' => '#6C757D',
                'type'  => 'client',
            ],
        ];

        foreach ($tags as $tag) {
            Tag::updateOrCreate(['name' => $tag['name']], $tag);
        }
    }
}
