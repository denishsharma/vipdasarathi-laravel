<?php

namespace Database\Seeders;

use App\Models\TeamType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamTypeSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        TeamType::create([
            'name' => 'First Responders',
            'slug' => \Str::slug('First Responders'),
            'description' => 'First Responders',
        ]);

        TeamType::create([
            'name' => 'Rescue Team',
            'slug' => \Str::slug('Rescue Team'),
            'description' => 'Rescue Team',
        ]);

        TeamType::create([
            'name' => 'Medical Team',
            'slug' => \Str::slug('Medical Team'),
            'description' => 'Medical Team',
        ]);

        TeamType::create([
            'name' => 'Search and Rescue Team',
            'slug' => \Str::slug('Search and Rescue Team'),
            'description' => 'Search and Rescue Team',
        ]);

        TeamType::create([
            'name' => 'Disaster Management Team',
            'slug' => \Str::slug('Disaster Management Team'),
            'description' => 'Disaster Management Team',
        ]);

        TeamType::create([
            'name' => 'Disaster Management Volunteers',
            'slug' => \Str::slug('Disaster Management Volunteers'),
            'description' => 'Disaster Management Volunteers',
        ]);

        TeamType::create([
            'name' => 'Operational Team',
            'slug' => \Str::slug('Operational Team'),
            'description' => 'Operational Team',
        ]);
    }
}
