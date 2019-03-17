@extends('layouts.app')

@section('content')
    <h1>Sub team User index</h1>
    @foreach($subTeamUsers as $stu)
        <p>{{ $stu->teamUser->user->name }}</p>
    @endforeach
@endsection
