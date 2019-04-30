@extends('layouts.app')

@section('content')
  <team-user-calendar :emotions="{{ json_encode($emotions) }}" :month="{{ json_encode($month) }}"></team-user-calendar>
@endsection
