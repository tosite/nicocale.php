@extends('layouts.app')

@section('content')
    <h1>Not Joined sub team User index</h1>
    @foreach($notJoinedSubTeamUsers as $row)
        <p>{{ $row->teamUser->user->name }}</p>
    @endforeach
@endsection
