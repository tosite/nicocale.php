@extends('layouts.app')

@section('content')
    <team-user-me :team-user="{{ json_encode($teamUser) }}"></team-user-me>
@endsection
