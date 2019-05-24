@extends('layouts.app')

@section('content')
    <team-user-me
      :team-user="{{ json_encode($teamUser) }}"
      :channels="{{ json_encode($channels) }}"
    ></team-user-me>
@endsection
