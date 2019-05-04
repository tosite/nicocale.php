@extends('layouts.app')

@section('content')
    <sub-team-emotion-calendar-table
      :sub-team-id="{{ json_encode($subTeamId) }}"
      :month="{{ json_encode($month) }}"
    >
    </sub-team-emotion-calendar-table>

@endsection
