@extends('layouts.app')

@section('content')
    <sub-team-emotion-calendar-table :sub-team-id="{{ json_encode($subTeamId) }}" :year="{{ $month->format('Y') }}" :month="{{ $month->format('n') }}">
    </sub-team-emotion-calendar-table>

@endsection
