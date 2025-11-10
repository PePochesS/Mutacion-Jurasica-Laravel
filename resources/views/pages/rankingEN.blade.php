@extends('layouts.app')
@section('title','Ranking')

@section('vite')
  @vite(['resources/css/styleR.css'])
@endsection

@push('page_head')
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Luckiest+Guy&display=swap" rel="stylesheet">
@endpush

@section('content')
  <div class="bg"></div>

  <main class="container">
    <section class="hero">
      <h1 class="page-title">SCOREBOARD</h1>

      @if (session('status'))
        <div class="flash flash-success" id="flash-status">
          <span class="flash-icon">✓</span>
          <span class="flash-text">{{ session('status') }}</span>
          <button class="flash-close" type="button" aria-label="Close" onclick="
            const f=document.getElementById('flash-status');
            if(f){ f.style.animation='flash-out .25s ease-out forwards'; setTimeout(()=>f.remove(),220); }
          ">&times;</button>
        </div>
      @endif
    </section>

    @if($game)
      {{-- Specific game view --}}
      <section class="scoreboard" style="margin-top:20px">
        <ul class="score-grid">
          @php $rank = 1; @endphp
          @foreach($scores as $s)
            <li class="score-card" data-rank="{{ $rank }}">
              <div class="rank">{{ $rank }}</div>
              <div class="who">
                <h3>Player {{ $s->player_number }}</h3>
              </div>
              <div class="points">{{ $s->points }} PTS</div>
            </li>
            @php $rank++; @endphp
          @endforeach
        </ul>

        @if($winner)
          <div class="menu-btn-container" style="margin-top:28px">
            <div class="back-menu" style="cursor:default">
              Winner: Player {{ $winner->player_number }} — {{ $winner->points }} pts
            </div>
          </div>
        @endif
      </section>

      <div class="menu-btn-container">
        <a class="back-menu" href="{{ route('en.home') }}">← Back to menu</a>
      </div>

    @else
      {{-- Finished games list with filter --}}
      <section class="scoreboard">
        <form method="GET" class="mb-3" style="display:flex; gap:10px; align-items:center">
          <label class="me-2">Filter by players:</label>
          <select name="players" onchange="this.form.submit()">
            <option value="">All</option>
            @for($i=1;$i<=4;$i++)
              <option value="{{ $i }}" @selected(($playersFilter ?? null)==(string)$i)>{{ $i }}</option>
            @endfor
          </select>
        </form>

        <ul class="score-grid">
          @forelse($games as $g)
            @php
              $top = \DB::table('scores')
                ->where('game_id',$g->id)->orderByDesc('points')->first();
            @endphp
            <li class="score-card" data-rank="0" style="grid-template-columns: 1fr auto">
              <a href="{{ route('en.ranking', ['game'=>$g->id]) }}" class="who" style="text-decoration:none; color:inherit">
                <h3>Game #{{ $g->id }} — {{ $g->player_count }} players</h3>
              </a>
              @if($top)
                <div class="points">{{ $top->points }} PTS</div>
              @endif
            </li>
          @empty
            <li class="score-card" data-rank="0">
              <div class="who"><h3>No finished games to show.</h3></div>
            </li>
          @endforelse
        </ul>
      </section>

      <div class="menu-btn-container">
        <a class="back-menu" href="{{ route('en.home') }}">← Back to menu</a>
      </div>
    @endif
  </main>

  <footer class="footer">
    <small>© 2025 DinoDiceTeam</small>
  </footer>
@endsection
