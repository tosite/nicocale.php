@extends('layouts.app')

@section('content')
    <h1>Sub team index</h1>
    @foreach($subTeamUsers as $st)
        <h4>{{ $st->subTeam->name }}</h4>
        <p>
            <a href="{{ route('sub_teams.calendar', ['subTeamId' => $st->sub_team_id, 'year'=> 2019, 'month'=> 3]) }}">calendar</a>
            <a href="{{ route('sub_team_users.index', ['subTeamId' => $st->sub_team_id]) }}">sub team users</a>
            <a href="{{ route('sub_team_users.not_joined', ['subTeamId' => $st->sub_team_id]) }}">not joined</a>
            <a href="{{ route('sub_team_users.me', ['subTeamUserId' => $st->id]) }}">me</a>
            <a href="{{ route('sub_teams.setting', ['subTeamId' => $st->sub_team_id]) }}">settings</a>
        </p>
    @endforeach
@endsection
