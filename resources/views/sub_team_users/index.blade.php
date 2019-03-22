@extends('layouts.app')

@section('content')
  <h1>Sub team User index</h1>
  <sub-team-user-list
    :users="{{ json_encode($subTeamUsers) }}"
    :me="{{ json_encode($me) }}"
  ></sub-team-user-list>
@endsection
