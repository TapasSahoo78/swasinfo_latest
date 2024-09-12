<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryAndFacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed days of the week as categories with name and slug
        $days = [
            ['name' => 'Monday', 'slug' => Str::slug('Monday')],
            ['name' => 'Tuesday', 'slug' => Str::slug('Tuesday')],
            ['name' => 'Wednesday', 'slug' => Str::slug('Wednesday')],
            ['name' => 'Thursday', 'slug' => Str::slug('Thursday')],
            ['name' => 'Friday', 'slug' => Str::slug('Friday')],
            ['name' => 'Saturday', 'slug' => Str::slug('Saturday')],
            ['name' => 'Sunday', 'slug' => Str::slug('Sunday')],
        ];

        DB::table('gym_days')->insert($days);

        $categories = [
            ['name' => 'Gym', 'slug' => Str::slug('Gym')],
            ['name' => 'Yoga', 'slug' => Str::slug('Yoga')],
            ['name' => 'Zumba', 'slug' => Str::slug('Zumba')],
            ['name' => 'Aerobic Exercide', 'slug' => Str::slug('Aerobic Exercide')],
            ['name' => 'Dancing', 'slug' => Str::slug('Dancing')],
            ['name' => 'Cycling', 'slug' => Str::slug('Cycling')],
            ['name' => 'Running', 'slug' => Str::slug('Running')],
            ['name' => 'Swimming', 'slug' => Str::slug('Swimming')]
        ];
        DB::table('gym_categories')->insert($categories);

        // Seed facilities with name and slug
        $facilities = [
            ['name' => 'AC', 'slug' => Str::slug('AC')],
            ['name' => 'Parking', 'slug' => Str::slug('Parking')],
            ['name' => 'WiFi', 'slug' => Str::slug('WiFi')]
        ];

        DB::table('gym_facilities')->insert($facilities);
    }
}
