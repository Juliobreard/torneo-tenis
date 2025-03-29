<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Player;
use App\Models\Tournament;

class GetTournamentId extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_tournament()
    {
        // Crear un torneo de prueba
        $tournament = Tournament::create([
            'type' => 'Male',
            'date' => now(),
            'winner_id' => Player::create([
                'name' => 'Roberto',
                'skill_level' => 80,
                'gender' => 'Male',
                'strength' => 70,
                'speed' => 60,
            ])->id,
        ]);
    
        // Hacer una solicitud GET al endpoint
        $response = $this->getJson("/api/tournaments/{$tournament->id}");
    
        // Verificar que la respuesta es exitosa (código 200)
        $response->assertStatus(200);
    
        // Verificar que la respuesta contiene los datos esperados
        $response->assertJson([
            'tournament' => [
                'id' => $tournament->id,
                'type' => 'Male',
                'winner' => [
                    'name' => 'Roberto',
                ],
            ],
        ]);
    }
}
