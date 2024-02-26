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
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);

        $this->call(AttributeSeeder::class);

        $this->call(CategorySeeder::class);
        // $this->call(BrandSeeder::class);

        $this->call(CountriesTableDataSeeder::class);
        $this->call(StatesTableDataSeeder::class);

        // $this->call(CitiesTableDataSeeder::class);
    }
}
