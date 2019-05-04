@extends('layouts.app')

@section('content')
    <not-joined-sub-team-list
      :not-joined-sub-teams="{{ json_encode($notJoinedSubTeams) }}"
      :user="{{ json_encode($user) }}"
    ></not-joined-sub-team-list>
@endsection
