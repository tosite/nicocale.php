@extends('layouts.app')

@section('content')
    <h1>Not joined sub teams</h1>
    <not-joined-sub-team-list :not-joined-sub-teams="{{ json_encode($notJoinedSubTeams) }}"></not-joined-sub-team-list>
@endsection
