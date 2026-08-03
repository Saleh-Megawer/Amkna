<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // $this->call([
        //     ClientsSeeder::class,
        // ]);

        $this->call([

            // System
            LanguageSeeder::class,
            PermissionSeeder::class, // Permission Will Set Admin Onwer
            SettingSeeder::class,
            CityNeighborhoodSeeder::class,

            // Property
            PropertyTypeSeeder::class,
            PropertyFacadeSeeder::class,
            FinishingTypeSeeder::class,
            PropertyAmenitySeeder::class,
            PropertyFeatureSeeder::class,
            // Set Data
            TagSeeder::class,
            SourcesSeeder::class,
            StatusesSeeder::class,
            ClientsSeeder::class,
            // DealSeeder::class,
            PropertySeeder::class,
            InterestSeeder::class,
            
        ]);

    }

}
