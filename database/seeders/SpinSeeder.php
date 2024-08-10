<?php

namespace Database\Seeders;

use App\Models\Spin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            foreach (range(1, 3) as $index) {
                Spin::create([
                    'user_id' => $user->id,
                    'type' => 'free',
                ]);
            }
        }
    }
}
