@extends('layouts.app')

@section('content')
    <h1>Team user settings</h1>
    <team-user-me :team-user="{{ json_encode($teamUser) }}"></team-user-me>
@endsection
