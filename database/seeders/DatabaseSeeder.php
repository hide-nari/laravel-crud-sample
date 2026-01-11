<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Person::create([
            'name' => 'taro',
            'age' => 15,
        ]);

        Person::create([
            'name' => 'taro',
            'age' => 15,
        ]);
        Person::factory(3)->create();
    }
}
