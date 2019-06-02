@extends('layouts.app')

@section('content')
  <team-index
    :team-user="{{ json_encode($teamUser) }}"
    :date="{{ json_encode($today) }}"
  ></team-index>
@endsection
