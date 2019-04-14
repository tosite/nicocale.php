@extends('layouts.app')

@section('content')
    <sub-team-emotion-calendar-table :sub-team-id="{{ json_encode($subTeamId) }}">
    </sub-team-emotion-calendar-table>

@endsection
