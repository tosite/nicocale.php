@extends('layouts.app')

@section('content')
@foreach($team->subTeams as $sub_team)
  <p>
    @if(!$sub_team->isJoin($sub_team->id, $team_user->id))
    <form method="POST" action="{{ route('sub_team_users.store', ['sub_team_id' => $sub_team->id]) }}">
      {{ $sub_team->name }}
      {{ csrf_field() }}
      <button type="submit">join</button>
    </form>
    @else
    <a href="{{ route('sub_teams.show', ['sub_team_id' => $sub_team->id, 'yyyymm' => date('Ym')]) }}">{{ $sub_team->name }}</a>
    @endif
  </p>
@endforeach
<form method="POST" action="{{ route('sub_teams.store') }}">
  {{ csrf_field() }}
  <input type="text" name="name">
  <input type="text" name="team_user_id" value="{{ $team_user->id }}">
  <button type="submit">create sub_team</button>
</form>
<a href="{{ route('team_users.show', ['team_user_id' => $team_user->id]) }}">user settings</a>
@endsection
