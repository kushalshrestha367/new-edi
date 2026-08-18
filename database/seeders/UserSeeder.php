<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataseed = [
            [
                'name' => 'Saffron Infosys Pvt Ltd',
                'email' => 'dev@saffron.info.np',
                'email_verified_at' => now(),
                'password' => bcrypt('Admin@123'), // Use a hashed password
                'active' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Administration',
                'email' => 'admin@saffron.info.np',
                'email_verified_at' => now(),
                'password' => bcrypt('Admin@123'), // Use a hashed password
                'active' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Commenter User',
                'email' => 'comment@saffron.info.np',
                'email_verified_at' => now(),
                'password' => bcrypt('Admin@123'), // Use a hashed password
                'active' => true,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];


        foreach ($dataseed as $dseed) {
            User::create($dseed);
        }

        DB::table('model_has_roles')->insert([
            'role_id' => 1, 
            'model_type' => 'App\Models\User',
            'model_id' => 1, 
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => 2, 
            'model_type' => 'App\Models\User',
            'model_id' => 2, 
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => 3, 
            'model_type' => 'App\Models\User',
            'model_id' => 3, 
        ]);
    }
}
