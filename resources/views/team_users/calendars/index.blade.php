@extends('layouts.app')

@section('content')
  <h1>Team user emotion calendar</h1>
  <team-user-calendar :emotions="{{ json_encode($emotions) }}"></team-user-calendar>
@endsection
