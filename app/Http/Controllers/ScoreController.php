<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    public function index(Request $request)
    {
        $gameId = $request->query('game', session('game'));

        if ($gameId) {
            $game = DB::table('games')->where('id', $gameId)->first();

            if (!$game) {
                // Renderiza la vista correspondiente al idioma actual
                $view = $this->isEn($request) ? 'pages.rankingEN' : 'pages.ranking';
                return view($view, [
                    'game'          => null,
                    'scores'        => collect(),
                    'winner'        => null,
                    'games'         => [],
                    'playersFilter' => null,
                ])->with('status', $this->isEn($request) ? 'Game not found.' : 'Partida no encontrada.');
            }

            $scores = DB::table('scores')
                ->where('game_id', $gameId)
                ->orderByDesc('points')
                ->get();

            $winner = $scores->first();

            $view = $this->isEn($request) ? 'pages.rankingEN' : 'pages.ranking';
            return view($view, [
                'game'          => $game,
                'scores'        => $scores,
                'winner'        => $winner,
                'games'         => [],
                'playersFilter' => null,
            ]);
        }

        // Listado
        $players = $request->query('players');
        $games = DB::table('games')
            ->when($players, fn ($q) => $q->where('player_count', (int) $players))
            ->where('status', 'finished')
            ->orderByDesc('id')
            ->limit(30)
            ->get();

        $view = $this->isEn($request) ? 'pages.rankingEN' : 'pages.ranking';
        return view($view, [
            'game'          => null,
            'scores'        => collect(),
            'winner'        => null,
            'games'         => $games,
            'playersFilter' => $players,
        ]);
    }

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

        // calcular cantidad de jugadores
        $playerCount = 0;
        foreach ($scores as $s) {
            $pn = (int)($s['player_number'] ?? 0);
            if ($pn > $playerCount) $playerCount = $pn;
        }
        if ($playerCount <= 0) $playerCount = count($scores);

        DB::transaction(function () use ($data, $scores, $playerCount) {
            DB::table('games')->where('id', $data['game_id'])->update([
                'player_count' => $playerCount,
                'status'       => 'finished',
                'updated_at'   => now(),
            ]);

            DB::table('scores')->where('game_id', $data['game_id'])->delete();

            $now = now();
            $authId = Auth::id();

            foreach ($scores as $s) {
                DB::table('scores')->insert([
                    'user_id'       => $authId,
                    'game_id'       => (int)$data['game_id'],
                    'player_number' => (int)($s['player_number'] ?? 0),
                    'points'        => (int)($s['points'] ?? 0),
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ]);
            }
        });

        $route = $this->isEn($request) ? 'en.ranking' : 'ranking';

        return redirect()
            ->route($route, ['game' => $data['game_id']])
            ->with('status', $this->isEn($request)
                ? 'Game finished successfully.'
                : 'Partida finalizada correctamente.');
    }

    private function isEn(Request $request): bool
    {
        // respeta el hidden del formulario y también la URL /en/...
        return $request->input('_lang') === 'en'
            || str_starts_with(trim($request->path(), '/'), 'en');
    }
}
