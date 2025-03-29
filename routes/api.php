<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;

Route::post('/tournament/simulate', [TournamentController::class, 'simulateTournament']);
Route::get('/tournaments', [TournamentController::class, 'listTournaments']);

Route::get('/tournaments/{id}', [TournamentController::class, 'getTournament']);


Route::get('/test', function () {
    return response()->json(['message' => 'Hello, World!']);
});
Route::get('/tournaments/by-date/{date}', [TournamentController::class, 'getTournamentsByDate']);

// Búsqueda por rango (opcional)
Route::get('/tournaments/by-range/{startDate}/{endDate?}', [TournamentController::class, 'getTournamentsByDateRange']);