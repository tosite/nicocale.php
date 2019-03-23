@extends('layouts.app')

@section('content')
    <h1>Sub team user me</h1>
    <sub-team-user-me :sub-team-user="{{ json_encode($subTeamUser) }}"></sub-team-user-me>
@endsection
