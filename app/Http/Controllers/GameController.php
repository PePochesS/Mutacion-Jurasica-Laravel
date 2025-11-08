<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GameController extends Controller
{
    public function index()
    {
        // Home ES (el home EN ya es Route::view en /en/)
        return view('pages.inicio');
    }

    /**
     * Crea la partida y guarda contexto en sesión.
     * Redirige a /juego (ES) o /en/game (EN) según la ruta o el _lang enviado.
     */
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

        // Persistir contexto
        $request->session()->put('game_id', $gameId);
        $request->session()->put('player_count', (int) $data['player_count']);
        $request->session()->put('turn', 1);

        // Detectar si es EN por:
        // - nombre de la ruta (en.*)
        // - prefijo de URL /en
        // - campo oculto _lang = en
        $isEn = $request->routeIs('en.*')
             || Str::startsWith($request->path(), 'en')
             || $request->input('_lang') === 'en';

        if ($isEn) {
            return redirect()->route('en.game')
                ->with('status', "Game created: {$data['player_count']} player(s). Player 1’s turn.");
        }

        return redirect()->route('juego')
            ->with('status', "Partida creada: {$data['player_count']} jugador(es). Turno del Jugador 1.");
    }

    /* Muestra la pantalla de juego.Renderiza juegoEN si estás en rutas /en/*; si no, juego (ES). Si no hay game_id en sesión, devuelve al home correspondiente.*/
    public function play(Request $request)
    {
        $hasGame = $request->session()->has('game_id');

        $isEn = $request->routeIs('en.*') || Str::startsWith($request->path(), 'en');

        if (!$hasGame) {
            if ($isEn) {
                return redirect()->route('en.home')
                    ->with('status', 'Choose “Play” and set the number of players to start a game.');
            }
            return redirect()->route('home')
                ->with('status', 'Elegí “Jugar” y define la cantidad de jugadores para iniciar una partida.');
        }

        $view = $isEn ? 'pages.juegoEN' : 'pages.juego';

        return view($view, [
            'gameId'      => (int) $request->session()->get('game_id'),
            'playerCount' => (int) $request->session()->get('player_count', 1),
            'turn'        => (int) $request->session()->get('turn', 1),
        ]);
    }

    /*Guarda puntaje parcial*/
    public function submitScore(Request $request)
    {
        $data = $request->validate([
            'points'  => 'required|integer|min:0',
            'details' => 'nullable|array',
        ]);

        DB::table('scores')->insert([
            'game_id'    => session('game_id'),
            'user_id'    => Auth::id(),
            'points'     => $data['points'],
            'details'    => isset($data['details']) ? json_encode($data['details']) : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['ok' => true]);
    }
}
