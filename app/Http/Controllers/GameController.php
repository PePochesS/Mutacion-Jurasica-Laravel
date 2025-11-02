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

    public function play()
    {
        // Por ahora solo devuelve la vista. Luego podemos crear/recuperar partida.
        return view('pages.juego');
    }

    public function submitScore(Request $request)
    {
        // Mínimo viable para guardar puntajes (si ya corriste la migración de scores)
        $data = $request->validate([
            'points'  => 'required|integer|min:0',
            'details' => 'nullable|array',
        ]);

        DB::table('scores')->insert([
            'game_id'    => null, // lo agregamos cuando implementemos modelo Game
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
        return redirect()->route('ranking');
    }
}
