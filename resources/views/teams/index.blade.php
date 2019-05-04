@extends('layouts.app')

@section('content')
    <h1>Team Index</h1>
    @foreach($teamUsers as $tu)
        <div>
            <h2>{{ $tu->team->name }}</h2>
        </div>
    @endforeach
@endsection
