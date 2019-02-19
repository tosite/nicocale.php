@extends('layouts.app')

@section('content')
  @foreach($team_users as $team_user)
    <sub-team-form-modal
      team-user-id="{{ $team_user->id }}"
      sub-team-name=""
    ></sub-team-form-modal>
  @endforeach
  @include('teams._teams', ['team_users' => $team_users])
@endsection
