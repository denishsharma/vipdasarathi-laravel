<?php

namespace Database\Seeders;

use App\Models\ActivityType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivityTypeSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        ActivityType::create([
            'name' => 'Resource Update',
            'slug' => \Str::slug('Resource Update'),
        ]);

        ActivityType::create([
            'name' => 'Resource Request',
            'slug' => \Str::slug('Resource Request'),
        ]);

        ActivityType::create([
            'name' => 'Resource Allocation',
            'slug' => \Str::slug('Resource Allocation'),
        ]);

        ActivityType::create([
            'name' => 'Resource Deployment',
            'slug' => \Str::slug('Resource Deployment'),
        ]);

        ActivityType::create([
            'name' => 'Comment Update',
            'slug' => \Str::slug('Comment Update'),
        ]);

        ActivityType::create([
            'name' => 'Status Update',
            'slug' => \Str::slug('Status Update'),
        ]);
    }
}
