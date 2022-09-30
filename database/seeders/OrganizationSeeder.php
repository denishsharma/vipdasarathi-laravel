<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        Organization::create([
            'name' => 'NDRF',
            'level' => 'national',
            'slug' => \Str::slug('NDRF national'),
            'description' => 'National Disaster Response Force',
        ]);

        Organization::create([
            'name' => 'NIDM',
            'level' => 'national',
            'slug' => \Str::slug('NIDM national'),
            'description' => 'National Institute of Disaster Management',
        ]);

        Organization::create([
            'name' => 'EOC',
            'level' => 'national',
            'slug' => \Str::slug('EOC national'),
            'description' => 'Emergency Operation Center',
        ]);

        Organization::create([
            'name' => 'MHA',
            'level' => 'national',
            'slug' => \Str::slug('MHA national'),
            'description' => 'Ministry of Home Affairs',
        ]);
    }
}
