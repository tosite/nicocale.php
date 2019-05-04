@extends('layouts.app')

@section('content')
    <sub-team-emotion-calendar-table
      :sub-team="{{ json_encode($subTeam) }}"
      :month="{{ json_encode($month) }}"
    >
    </sub-team-emotion-calendar-table>

@endsection
