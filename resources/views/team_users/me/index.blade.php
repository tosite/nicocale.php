@extends('layouts.app')

@section('content')
    <team-user-me
      :team-user="{{ json_encode($teamUser) }}"
      :channels="{{ json_encode($channels) }}"
      :settings="{{ json_encode($settings) }}"
    ></team-user-me>
@endsection
