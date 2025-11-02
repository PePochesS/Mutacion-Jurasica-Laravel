<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    public function index()
    {
        $scores = DB::table('scores')
            ->leftJoin('users', 'scores.user_id', '=', 'users.id')
            ->select('scores.id', 'scores.points', 'scores.created_at', 'users.name')
            ->orderByDesc('scores.points')
            ->orderByDesc('scores.created_at')
            ->limit(50)
            ->get();

        return view('pages.ranking', ['scores' => $scores]);
    }
}
