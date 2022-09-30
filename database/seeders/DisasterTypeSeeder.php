<?php

namespace Database\Seeders;

use App\Models\DisasterType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisasterTypeSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        DisasterType::create([
            'name' => 'Earthquake',
            'slug' => \Str::slug('Earthquake'),
        ]);

        DisasterType::create([
            'name' => 'Flood',
            'slug' => \Str::slug('Flood'),
        ]);

        DisasterType::create([
            'name' => 'Landslide',
            'slug' => \Str::slug('Landslide'),
        ]);

        DisasterType::create([
            'name' => 'Cyclone',
            'slug' => \Str::slug('Cyclone'),
        ]);

        DisasterType::create([
            'name' => 'Drought',
            'slug' => \Str::slug('Drought'),
        ]);

        DisasterType::create([
            'name' => 'Fire',
            'slug' => \Str::slug('Fire'),
        ]);

        DisasterType::create([
            'name' => 'Tsunami',
            'slug' => \Str::slug('Tsunami'),
        ]);

        DisasterType::create([
            'name' => 'Volcano',
            'slug' => \Str::slug('Volcano'),
        ]);

        DisasterType::create([
            'name' => 'Wildfire',
            'slug' => \Str::slug('Wildfire'),
        ]);

        DisasterType::create([
            'name' => 'Tornado',
            'slug' => \Str::slug('Tornado'),
        ]);

        DisasterType::create([
            'name' => 'Hurricane',
            'slug' => \Str::slug('Hurricane'),
        ]);

        DisasterType::create([
            'name' => 'Tropical Storm',
            'slug' => \Str::slug('Tropical Storm'),
        ]);
    }
}
