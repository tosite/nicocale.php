@extends('layouts.app')

@section('content')
    <team-user-me
      :team-user="{{ json_encode($teamUser) }}"
      :names="{{ json_encode($names) }}"
      :channels="{{ json_encode($channels) }}"
    ></team-user-me>
@endsection
