@extends('layouts.app')

@section('content')
  <team-user-calendar
    :emotions="{{ json_encode($emotions) }}"
    :month="{{ json_encode($month) }}"
    :me="{{ json_encode($isMe) }}"
    :team-user="{{ json_encode($user) }}"
  ></team-user-calendar>
@endsection
