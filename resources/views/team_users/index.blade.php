@extends('layouts.app')

@section('content')
    <h1>Team User Index</h1>
    @foreach($teamUsers as $tu)
        <div>
            {{ $tu->user->name }}
            <a href="{{ route('team_users.calendar', ['teamUserId' => $tu->id, 'year' => 2019, 'month' => 3]) }}">calendar</a>
            <a href="{{ route('team_users.list', ['teamUserId' => $tu->id, 'year' => 2019, 'month' => 3]) }}">list</a>
        </div>
    @endforeach
@endsection
