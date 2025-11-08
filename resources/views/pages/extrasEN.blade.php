@extends('layouts.app')

@section('vite')
  @vite(['resources/css/StyleExtra.css'])
@endsection

@section('content')
<div class="extras-wrap">
    <div class="extras-container">

        <h1 class="extras-title">Game Information</h1>

        <h2 class="extras-subtitle">Rules</h2>

        <ul class="extras-list">
            <li>Place one dinosaur per turn in the allowed enclosure.</li>
            <li>The die determines restrictions or special zones.</li>
            <li>Each enclosure has conditions that affect the score.</li>
            <li>When all turns are finished, total points are counted.</li>
            <li>The player with the highest score wins.</li>
        </ul>

        <a href="{{ route('en.home') }}" class="extras-back-btn">Back to Home</a>

    </div>
</div>
@endsection
