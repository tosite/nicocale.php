@extends('layouts.app')

@section('content')
  @include('teams._teams', ['team_users' => $team_users])
@endsection
