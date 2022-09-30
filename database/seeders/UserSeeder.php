<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        $user = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@gmail.com',
            'organization_id' => Organization::whereSlug('mha-national')->first()->id,
            'password' => \Hash::make('12345678'),
            'slug' => \Str::slug('John D ' . ' ' . \Str::random(6)),
        ]);
        $user->user_profile()->create([
            'mobile' => '9812345678',
        ]);

        $faker = \Faker\Factory::create('en_IN');

        User::factory()->count(10)->create()->each(function ($user) use ($faker) {
            $user->user_profile()->create([
                'mobile' => $faker->numerify('98########'),
            ]);
        });
    }
}
