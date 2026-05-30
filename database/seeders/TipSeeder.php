<?php

namespace Database\Seeders;

use App\Models\Tip;
use App\Models\User;
use Illuminate\Database\Seeder;

class TipSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
    ['email' => 'test@example.com'],
    ['name' => 'Test User', 'password' => bcrypt('password'), 'is_admin' => true]
);
        Tip::create([
            'user_id'     => $user->id,
            'match_teams' => 'Real Madrid vs Barcelona',
            'prediction'  => 'Over 2.5 gólov',
            'odds'        => 1.85,
            'status'      => 'win',
            'match_date'  => '2024-03-10',
        ]);

        Tip::create([
            'user_id'     => $user->id,
            'match_teams' => 'Liverpool vs Man City',
            'prediction'  => 'X (remíza)',
            'odds'        => 3.40,
            'status'      => 'loss',
            'match_date'  => '2024-03-15',
        ]);

        Tip::create([
            'user_id'     => $user->id,
            'match_teams' => 'Bayern vs Dortmund',
            'prediction'  => '1 (Bayern win)',
            'odds'        => 1.60,
            'status'      => 'pending',
            'match_date'  => '2024-04-01',
        ]);
    }
}