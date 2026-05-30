<?php

use App\Models\Tip;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('GET /api/tips vrátí JSON s tipmi', function () {
    Tip::factory(3)->create();

    $response = $this->getJson('/api/tips');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'match_teams',
                'prediction',
                'odds',
                'status',
                'match_date',
                'tipster' => ['id', 'name'],
            ]
        ]
    ]);
    $response->assertJsonCount(3, 'data');
});

it('GET /api/tipsters/{user}/stats vrátí štatistiky', function () {
    $user = User::factory()->create();
    Tip::factory()->create(['user_id' => $user->id, 'status' => 'win',  'odds' => 2.00]);
    Tip::factory()->create(['user_id' => $user->id, 'status' => 'loss', 'odds' => 1.50]);
    Tip::factory()->create(['user_id' => $user->id, 'status' => 'pending', 'odds' => 1.80]);

    $response = $this->getJson("/api/tipsters/{$user->id}/stats");

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'tipster' => ['id', 'name'],
        'stats'   => ['total', 'wins', 'losses', 'pending', 'win_rate', 'roi'],
    ]);
    $response->assertJsonPath('stats.total',   3);
    $response->assertJsonPath('stats.wins',    1);
    $response->assertJsonPath('stats.losses',  1);
    $response->assertJsonPath('stats.pending', 1);
});

it('GET /api/tipsters/999/stats vrátí 404', function () {
    $response = $this->getJson('/api/tipsters/999/stats');
    $response->assertStatus(404);
});