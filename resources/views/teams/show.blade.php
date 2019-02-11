@extends('layouts.app')

@section('content')
  @include('teams._team_detail', ['emotions' => $emotions])
@endsection
