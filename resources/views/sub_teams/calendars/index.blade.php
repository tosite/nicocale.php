@extends('layouts.app')

@section('content')
    <h1>{{ $month->format('Y-m') }} Sub team emotion calendar</h1>

    <table>
        <thead>
        <tr>
            <th>name</th>
            @foreach($calendarWithEmotions as $c)
                <th>{{ $c['date']->format('j') }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>{{ \Auth::user()->name }}</th>
            @foreach($calendarWithEmotions as $e)
                <td>{{ optional($e['me'])->emoji }}</td>
            @endforeach
        </tr>
        @foreach($subTeamUsers as $u)
            <tr>
                <th>{{ $u->user->name }}</th>
                @foreach($calendarWithEmotions as $e)
                    <td>{{ optional($e['members'][$u->user_id])->emoji }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
