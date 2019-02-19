@extends('layouts.app')

@section('content')
  @foreach($sub_team_users as $sub_team_user)
    <p>
      <a href="/sub_teams/{{ $sub_team_user->sub_team->id }}/{{ date('Ym') }}">{{ $sub_team_user->sub_team->name }}</a>
    </p>
  @endforeach
@endsection
