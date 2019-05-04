@extends('layouts.app')

@section('content')
  <emotion-modal
    :team-user="{{ json_encode($teamUser) }}"
    :emotion="{{ json_encode($emotion) }}"
    :date="{{ json_encode($today->format('Y-m-d')) }}"
  ></emotion-modal>
@endsection
