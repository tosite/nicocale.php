@extends('layouts.app')

@section('content')
@foreach($joinedTeamList as $team)
    <h2>
        {{ $team['team']['name'] }}
{{--        <a href="{{ route('teams.show', $team['team']['id']) }}">show</a>--}}
    </h2>
    @foreach($team['sub_teams'] as $subTeam)
        <p>
            {{ $subTeam['name'] }}
            <a href="{{ route('sub_teams.show', ['subTeamId' => $subTeam['id'], 'yyyymm' => 201902]) }}">show</a>
        </p>
        @include('sub_teams._update_form', ['$subTeam' => $subTeam])
        <hr>
    @endforeach
    @include('sub_teams._store_form', ['teamId' => $team['team']['id']])
    <p><a href="">join sub teams</a></p>
    <hr>
@endforeach
@endsection
