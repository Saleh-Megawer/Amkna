<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dashboard\Languages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Languages::count() == 0) {

            Languages::create([
                'language_name' => "English",
                'language_code' => "en"
            ]);

            Languages::create([
                'language_name' => "Arabic",
                'language_code' => "ar"
            ]);

        }
    }
}
