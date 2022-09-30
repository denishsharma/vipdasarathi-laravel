<?php

namespace Database\Seeders;

use App\Models\TaskType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskTypeSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        TaskType::create([
            'name' => 'Search and Rescue',
            'slug' => \Str::slug('Search and Rescue'),
        ]);

        TaskType::create([
            'name' => 'Medical',
            'slug' => \Str::slug('Medical'),
        ]);

        TaskType::create([
            'name' => 'Logistics',
            'slug' => \Str::slug('Logistics'),
        ]);

        TaskType::create([
            'name' => 'Security',
            'slug' => \Str::slug('Security'),
        ]);

        TaskType::create([
            'name' => 'Relief',
            'slug' => \Str::slug('Relief'),
        ]);

        TaskType::create([
            'name' => 'Rehabilitation',
            'slug' => \Str::slug('Rehabilitation'),
        ]);

        TaskType::create([
            'name' => 'Reconstruction',
            'slug' => \Str::slug('Reconstruction'),
        ]);

        TaskType::create([
            'name' => 'Operational',
            'slug' => \Str::slug('Operational'),
        ]);

        TaskType::create([
            'name' => 'Other',
            'slug' => \Str::slug('Other'),
        ]);
    }
}
