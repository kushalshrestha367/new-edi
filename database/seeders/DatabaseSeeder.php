<?php

namespace Database\Seeders;

use App\Models\User;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (config('filament-shield.super_admin.enabled', false)) {
            FilamentShield::createRole(name: config('filament-shield.super_admin.name', 'super_admin'));
        }
        if (config('filament-shield.admin.enabled', false)) {
            FilamentShield::createRole(name: config('filament-shield.admin.name', 'admin'));
        }
        if (config('filament-shield.commenter.enabled', false)) {
            FilamentShield::createRole(name: config('filament-shield.commenter.name', 'commenter'));
        }

        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
        ]);
    }
}
