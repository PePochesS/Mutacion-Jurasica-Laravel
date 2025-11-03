<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function index()
    {
        return view('pages.inicio');
    }

    // NUEVO: crear partida y guardar datos en sesión
    public function start(Request $request)
    {
        $data = $request->validate([
            'player_count' => 'required|integer|min:1|max:4',
        ]);

        $gameId = DB::table('games')->insertGetId([
            'owner_id'     => Auth::id(),
            'name'         => 'Partida ' . now()->format('Y-m-d H:i'),
            'player_count' => $data['player_count'],
            'status'       => 'active',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // guardar contexto de la partida en sesión
        $request->session()->put('game_id', $gameId);
        $request->session()->put('player_count', (int)$data['player_count']);
        $request->session()->put('turn', 1);

        return redirect()->route('juego')
            ->with('status', "Partida creada: {$data['player_count']} jugador(es). Turno del Jugador 1.");
    }

    // actualizada: lee datos de la sesión y los pasa a la vista
    public function play(Request $request)
    {
        if (!$request->session()->has('game_id')) {
            return redirect()->route('home')
                ->with('status', 'Elegí “Jugar” y define la cantidad de jugadores para iniciar una partida.');
        }

        return view('pages.juego', [
            'gameId'      => $request->session()->get('game_id'),
            'playerCount' => (int)$request->session()->get('player_count', 1),
            'turn'        => (int)$request->session()->get('turn', 1),
        ]);
    }

    // igual que antes: guarda puntajes
    public function submitScore(Request $request)
    {
        $data = $request->validate([
            'points'  => 'required|integer|min:0',
            'details' => 'nullable|array',
        ]);

        DB::table('scores')->insert([
            'game_id'    => session('game_id'), // ahora guardamos la partida actual
            'user_id'    => Auth::id(),
            'points'     => $data['points'],
            'details'    => isset($data['details']) ? json_encode($data['details']) : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['ok' => true]);
    }

public function endGame(Request $request)
{
    $request->validate([
        'game_id'     => 'required|integer|exists:games,id',
        'scores_json' => 'required|string',
    ]);

    $gameId = (int) $request->input('game_id');
    $scores = json_decode($request->input('scores_json'), true);

    if (!is_array($scores) || empty($scores)) {
        return redirect()->route('ranking')->with('status', 'No llegaron puntajes.');
    }

    // Guardar puntajes (player_number, points)
    foreach ($scores as $row) {
        // Esperamos { player_number: 1..N, points: int }
        if (!isset($row['player_number'], $row['points'])) continue;

        \DB::table('scores')->insert([
            'game_id'       => $gameId,
            'player_number' => (int) $row['player_number'],
            'points'        => (int) $row['points'],
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }

    // Marcar partida como finalizada
    \DB::table('games')->where('id', $gameId)->update([
        'status'     => 'finished',
        'updated_at' => now(),
    ]);

    // Redirigir al ranking de ESTA partida
    return redirect()->route('ranking', ['game' => $gameId])
        ->with('status', 'Partida finalizada correctamente.');
     }

}
