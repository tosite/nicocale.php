@extends('layouts.app')

@section('content')
  @include('teams/_joined_teams', ['team_users' => $team_users])
@endsection
