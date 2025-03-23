<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Services\TournamentService;
use App\Models\Player;
use App\Http\Requests\SimulateTournamentRequest;
use Illuminate\Http\JsonResponse;

class TournamentController extends Controller
{
    protected $tournamentService;

    public function __construct(TournamentService $tournamentService)
    {
        $this->tournamentService = $tournamentService;
    }

    public function simulateTournament(SimulateTournamentRequest $request): JsonResponse
    {

        $playerIds = array_column($request->players, 'id');
    

        $players = Player::whereIn('id', $playerIds)->get();
    

        if ($players->isEmpty()) {
            foreach ($request->players as $playerData) {
     
                $player = Player::create([
                    'name' => $playerData['name'],
                    'skill_level' => $playerData['skill_level'],
                    'gender' => $playerData['gender'],
                    'strength' => $playerData['strength'] ?? null,
                    'speed' => $playerData['speed'] ?? null,
                    'reaction_time' => $playerData['reaction_time'] ?? null,
                ]);
    

                $players->push($player);
            }
        }
    
        // Simular el torneo
        $tournament = $this->tournamentService->simulateTournament($players, $request->type);
    
        return response()->json([
            'tournament_id' => $tournament->id,
            'winner' => $tournament->winner->name,
            'date' => $tournament->date,
            'type' => $tournament->type,
        ]);
    }

    public function listTournaments()
    {

        $tournaments = Tournament::with('winner')->get();

        return response()->json($tournaments);
    }
    public function getTournament($id)
{

    $tournament = Tournament::with('winner')->find($id);


    if (!$tournament) {
        return response()->json([
            'message' => 'Torneo no encontrado',
        ], 404);
    }

    return response()->json([
        'tournament' => $tournament,
    ]);
}
}
