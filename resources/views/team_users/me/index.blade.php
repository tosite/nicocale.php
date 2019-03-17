@extends('layouts.app')

@section('content')
    <h1>Team user settings</h1>
    {{ $teamUser->user->name }}
@endsection
