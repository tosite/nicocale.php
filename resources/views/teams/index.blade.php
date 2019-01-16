@extends('layouts.app')

@section('content')
  @include('teams/_joined_teams', ['joined_teams' => $joined_teams])
  <form action="/teams" method="post">
    {{ csrf_field() }}
    <input type="text" name="name">
    <button type="submit">submit</button>
  </form>
@endsection
