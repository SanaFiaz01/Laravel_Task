<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wholesalerRole = Role::firstOrCreate(['name' => 'Wholesaler']);
        $retailerRole = Role::firstOrCreate(['name' => 'Retailer']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        //  17 users with the Wholesaler role
        foreach (range(1, 17) as $index) {
            User::factory()->create([
                'name' => 'Wholesaler User ' . $index,
                'email' => 'wholesaler' . $index . '@example.com',
                'password' => Hash::make('password123'),
            ])->assignRole($wholesalerRole);
        }

        //  33 users with the Retailer role
        foreach (range(1, 33) as $index) {
            User::factory()->create([
                'name' => 'Retailer User ' . $index,
                'email' => 'retailer' . $index . '@example.com',
                'password' => Hash::make('password123'),
            ])->assignRole($retailerRole);
        }

        // 5 users with the Admin role
        foreach (range(1, 5) as $index) {
            User::factory()->create([
                'name' => 'Admin User ' . $index,
                'email' => 'admin' . $index . '@example.com',
                'password' => Hash::make('password123'),
            ])->assignRole($adminRole);
        }
    }
}
