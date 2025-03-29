<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Player;
use App\Models\Tournament;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TournamentTest extends TestCase
{
    use RefreshDatabase; // Reinicia la base de datos después de cada prueba

    public function test_simulate_tournament()
    {
        $data = [
            'players' => [
                [
                    'name' => 'Juan Perez',
                    'skill_level' => 80,
                    'gender' => 'Male',
                    'strength' => 70,
                    'speed' => 60,
                ],
                [
                    'name' => 'Pepe Argento',
                    'skill_level' => 85,
                    'gender' => 'Male',
                    'strength' => 75,
                    'speed' => 65,
                ]
            ],
            'type' => 'Male'
        ];
    
        $response = $this->postJson('/api/tournament/simulate', $data);
        $response->assertStatus(200);
    }

    public function test_get_tournament()
        {

            $tournament = Tournament::create([
                'type' => 'Male',
                'date' => now(),
                'winner_id' => Player::create([
                    'name' => 'Juan Martin',
                    'skill_level' => 80,
                    'gender' => 'Male',
                    'strength' => 70,
                    'speed' => 60,
                ])->id,
            ]);

            $response = $this->getJson("/api/tournaments/{$tournament->id}");

            $response->assertStatus(200);

            $response->assertJson([
                'tournament' => [
                    'id' => $tournament->id,
                    'type' => 'Male',
                    'winner' => [
                        'name' => 'Juan Martin',
                    ],
                ],
            ]);
        }
}
