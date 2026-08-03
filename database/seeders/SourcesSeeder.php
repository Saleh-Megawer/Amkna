<?php
namespace Database\Seeders;

use App\Models\Dashboard\Source;
use Illuminate\Database\Seeder;

class SourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $sources = [
            [
                'name' => 'إضافة يدوية من لوحة التحكم', 
                'key'  => 'manual',
                'type' => 'client',
            ],
            [
                'name' => 'تسجيل مباشر من الموقع',
                'key'  => 'website',
                'type' => 'client',
            ],
            [
                'name' => 'صفحة حملة إعلانية', 
                'key'  => 'campaign',
                'type' => 'client',
            ],
            [
                'name' => 'تسجيل من صفحة عرض العقار', 
                'key'  => 'property',
                'type' => 'client',
            ],
        ];

        foreach ($sources as $source) {
            Source::updateOrCreate(['key' => $source['key']], $source);
        }
    }
}
