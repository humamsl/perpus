<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SettingSeeder::class,
            TaxonomySeeder::class,
            DdcCategorySeeder::class,
            ReadingSpotSeeder::class,
            DemoUserSeeder::class,
            BookSeeder::class,
            DemoDataSeeder::class,
        ]);
    }
}
