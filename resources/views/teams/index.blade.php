@extends('layouts.app')

@section('content')
    <h1>Team Index</h1>
    @foreach($teamUsers as $tu)
        <div>
            <h2>{{ $tu->team->name }}</h2>
            <a href="{{ route('sub_teams.index', ['teamId' => $tu->team_id]) }}">sub teams</a>
            <a href="{{ route('team_users.index', ['teamId' => $tu->team_id]) }}">team users</a>
            <a href="{{ route('sub_teams.not_joined', ['teamId' => $tu->team_id]) }}">not joined</a>
            <a href="{{ route('team_users.me', ['teamId' => $tu->team_id]) }}">me</a>
        </div>
    @endforeach
@endsection
