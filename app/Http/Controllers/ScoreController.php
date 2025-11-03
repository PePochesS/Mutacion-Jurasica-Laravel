<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    /**
     * GET /ranking
     * - Si viene ?game=ID, muestra el ranking de esa partida (tarjetas por jugador, ordenadas).
     * - Si no viene, lista partidas finalizadas con filtro por cantidad de jugadores (?players=1..4).
     */
    public function index(Request $request)
    {
        $gameId = $request->query('game', session('game'));

        if ($gameId) {
            $game = DB::table('games')->where('id', $gameId)->first();

            if (!$game) {
                return view('pages.ranking', [
                    'game'          => null,
                    'scores'        => collect(),
                    'winner'        => null,
                    'games'         => [],
                    'playersFilter' => null,
                ])->with('status', 'Partida no encontrada.');
            }

            $scores = DB::table('scores')
                ->where('game_id', $gameId)
                ->orderByDesc('points')
                ->get();

            $winner = $scores->first();

            return view('pages.ranking', [
                'game'          => $game,
                'scores'        => $scores,
                'winner'        => $winner,
                'games'         => [],
                'playersFilter' => null,
            ]);
        }

        // Listado de partidas finalizadas (+ filtro ?players=1..4)
        $players = $request->query('players'); // 1..4
        $games = DB::table('games')
            ->when($players, fn ($q) => $q->where('player_count', (int) $players))
            ->where('status', 'finished')
            ->orderByDesc('id')
            ->limit(30)
            ->get();

        return view('pages.ranking', [
            'game'          => null,
            'scores'        => collect(),
            'winner'        => null,
            'games'         => $games,
            'playersFilter' => $players,
        ]);
    }

    /**
     * POST /juego/end  (route: juego.end)
     * Recibe:
     * - game_id
     * - scores_json: JSON de [{player_number, points}, ...]
     * Guarda puntajes, marca la partida como finished y redirige a /ranking?game=ID.
     */
    public function end(Request $request)
    {
        $data = $request->validate([
            'game_id'     => ['required', 'integer', 'exists:games,id'],
            'scores_json' => ['required', 'string'],
        ]);

        $scores = json_decode($data['scores_json'], true);
        if (!is_array($scores)) {
            return back()->withErrors(['scores_json' => 'Formato de puntajes inválido.']);
        }

        // Calcular cantidad de jugadores desde el payload
        $playerCount = 0;
        foreach ($scores as $s) {
            $pn = (int)($s['player_number'] ?? 0);
            if ($pn > $playerCount) $playerCount = $pn;
        }
        if ($playerCount <= 0) $playerCount = count($scores);

        DB::transaction(function () use ($data, $scores, $playerCount) {
            // Actualizar partida como finalizada
            DB::table('games')->where('id', $data['game_id'])->update([
                'player_count' => $playerCount,
                'status'       => 'finished',
                'updated_at'   => now(),
            ]);

            // Evitar duplicados si se re-envía
            DB::table('scores')->where('game_id', $data['game_id'])->delete();

            $now = now();
            $authId = Auth::id(); // puede ser null si no hay usuario logueado

            foreach ($scores as $s) {
                DB::table('scores')->insert([
                    // IMPORTANTE: si tu columna user_id NO es nullable, hacela nullable en la migración,
                    // o asegurate de tener un usuario logueado.
                    'user_id'       => $authId, // null si anónimo
                    'game_id'       => (int)$data['game_id'],
                    'player_number' => (int)($s['player_number'] ?? $s['player'] ?? 0),
                    'points'        => (int)($s['points'] ?? 0),
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ]);
            }
        });

        return redirect()
            ->route('ranking', ['game' => $data['game_id']])
            ->with('status', 'Partida finalizada correctamente.');
    }
}
