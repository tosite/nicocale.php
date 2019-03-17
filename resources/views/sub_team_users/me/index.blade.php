@extends('layouts.app')

@section('content')
    <h1>Sub team user me</h1>
    <p>{{ $subTeamUser->teamUser->user->name }}</p>
@endsection
