<?php

use App\Models\Tip;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// --- Zobrazenie tipov ---

it('zobrazí zoznam tipov na hlavnej stránke', function () {
    Tip::factory(3)->create();

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertViewIs('tips.index');
    $response->assertViewHas('tips');
});

// --- Pridanie tipu ---

it('prihlásený user môže pridať tip', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/tips', [
        'match_teams' => 'Real Madrid vs Barcelona',
        'prediction'  => 'Over 2.5',
        'odds'        => 1.85,
        'match_date'  => '2024-06-01',
    ]);

    $response->assertRedirect('/');
    $this->assertDatabaseHas('tips', [
        'match_teams' => 'Real Madrid vs Barcelona',
        'user_id'     => $user->id,
    ]);
});

it('neprihlásený user nemôže pridať tip', function () {
    $response = $this->post('/tips', [
        'match_teams' => 'Test',
        'prediction'  => 'Test',
        'odds'        => 1.5,
        'match_date'  => '2024-06-01',
    ]);

    $response->assertRedirect('/login');
    $this->assertDatabaseCount('tips', 0);
});

it('validácia odmietne tip bez zápasu', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/tips', [
        'match_teams' => '',
        'prediction'  => 'Over 2.5',
        'odds'        => 1.85,
        'match_date'  => '2024-06-01',
    ]);

    $response->assertSessionHasErrors('match_teams');
    $this->assertDatabaseCount('tips', 0);
});

// --- Editácia (len admin) ---

it('admin môže editovať tip', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $tip   = Tip::factory()->create();

    $response = $this->actingAs($admin)->patch("/tips/{$tip->id}", [
        'match_teams' => 'Updated Match',
        'prediction'  => 'Updated Prediction',
        'odds'        => 2.00,
        'match_date'  => '2024-06-01',
        'status'      => 'win',
    ]);

    $response->assertRedirect('/');
    $this->assertDatabaseHas('tips', [
        'id'          => $tip->id,
        'match_teams' => 'Updated Match',
    ]);
});

it('bežný user nemôže editovať tip', function () {
    $user = User::factory()->create(['is_admin' => false]);
    $tip  = Tip::factory()->create();

    $response = $this->actingAs($user)->patch("/tips/{$tip->id}", [
        'match_teams' => 'Hacked Match',
        'prediction'  => 'X',
        'odds'        => 2.00,
        'match_date'  => '2024-06-01',
        'status'      => 'win',
    ]);

    $response->assertStatus(403);
    $this->assertDatabaseMissing('tips', ['match_teams' => 'Hacked Match']);
});

// --- Mazanie (len admin) ---

it('admin môže zmazať tip', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $tip   = Tip::factory()->create();

    $response = $this->actingAs($admin)->delete("/tips/{$tip->id}");

    $response->assertRedirect('/');
    $this->assertDatabaseMissing('tips', ['id' => $tip->id]);
});

it('bežný user nemôže zmazať tip', function () {
    $user = User::factory()->create(['is_admin' => false]);
    $tip  = Tip::factory()->create();

    $response = $this->actingAs($user)->delete("/tips/{$tip->id}");

    $response->assertStatus(403);
    $this->assertDatabaseHas('tips', ['id' => $tip->id]);
});