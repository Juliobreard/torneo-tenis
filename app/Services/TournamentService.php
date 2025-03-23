<?php
namespace App\Services;

use App\Models\Tournament;
use App\Models\Player;
use Illuminate\Support\Collection;

class TournamentService
{
    public function simulateTournament(Collection $players, string $type): Tournament
    {
        $winner = $this->simulateRounds($players);

        // Save the tournament to the database
        $tournament = Tournament::create([
            'type' => $type,
            'date' => now(),
            'winner_id' => $winner->id,
        ]);

        return $tournament;
    }

    private function simulateRounds(Collection $players): Player
    {
        while ($players->count() > 1) {
            $winners = collect();
            for ($i = 0; $i < $players->count(); $i += 2) {
                $player1 = $players[$i];
                $player2 = $players[$i + 1];
                $winner = $this->determineWinner($player1, $player2);
                $winners->push($winner);
            }
            $players = $winners;
        }
        return $players->first();
    }

    private function determineWinner(Player $player1, Player $player2): Player
    {
        $luck = mt_rand(90, 110) / 100; // Luck factor between 0.9 and 1.1

        if ($player1->gender === 'Male') {
            $score1 = ($player1->skill_level + $player1->strength + $player1->speed) * $luck;
            $score2 = ($player2->skill_level + $player2->strength + $player2->speed) * $luck;
        } else {
            $score1 = ($player1->skill_level + $player1->reaction_time) * $luck;
            $score2 = ($player2->skill_level + $player2->reaction_time) * $luck;
        }

        return $score1 > $score2 ? $player1 : $player2;
    }
}