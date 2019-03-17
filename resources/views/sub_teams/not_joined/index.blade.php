@extends('layouts.app')

@section('content')
    <h1>Not joined sub teams</h1>
    @foreach($notJoinedSubTeams as $row)
        <p>{{ $row->team->name }}</p>
    @endforeach
@endsection
