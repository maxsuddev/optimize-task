<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = User::create([
            'name' => 'User One',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
        ]);

        $user2 = User::create([
            'name' => 'User Two',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
        ]);

        $user1Leads = Lead::factory(10)->create([
            'user_id' => $user1->id,
        ]);

        $user2Leads = Lead::factory(10)->create([
            'user_id' => $user2->id,
        ]);

        $allLeads = $user1Leads->concat($user2Leads);

        for ($i = 0; $i < 15; $i++) {
            Task::factory()->create([
                'lead_id' => $allLeads->random()->id,
            ]);
        }
    }
}