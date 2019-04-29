@extends('layouts.app')

@section('content')
    <not-joined-sub-team-list :not-joined-sub-teams="{{ json_encode($notJoinedSubTeams) }}"></not-joined-sub-team-list>
@endsection
