@extends('layouts.app')

@section('content')
  <team-user-calendar
    :emotions="{{ json_encode($emotions) }}"
    :month="{{ json_encode($month) }}"
    :me="{{ json_encode($isMe) }}"
    :sub-team-id="{{ json_encode($teamId) }}"
  ></team-user-calendar>
@endsection
