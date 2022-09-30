<?php

namespace Database\Seeders;

use App\Models\DemandType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemandTypeSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        DemandType::create([
            'name' => 'Resource',
            'slug' => 'resource',
        ]);

        DemandType::create([
            'name' => 'Service',
            'slug' => 'service',
        ]);

        DemandType::create([
            'name' => 'Information',
            'slug' => 'information',
        ]);

        DemandType::create([
            'name' => 'Other',
            'slug' => 'other',
        ]);
    }
}
