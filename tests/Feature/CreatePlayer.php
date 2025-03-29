<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePlayer extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_player()
    {
        // Datos del jugador
        $data = [
            'name' => 'Jugador 3',
            'skill_level' => 90,
            'gender' => 'Female',
            'reaction_time' => 50,
        ];
    
        // Hacer una solicitud POST al endpoint de creación de jugadores
        $response = $this->postJson('/api/players', $data);
    
        // Verificar que la respuesta es exitosa (código 201)
        $response->assertStatus(201);
    
        // Verificar que el jugador se creó en la base de datos
        $this->assertDatabaseHas('players', [
            'name' => 'Jugador 3',
            'skill_level' => 90,
        ]);
    }
}
