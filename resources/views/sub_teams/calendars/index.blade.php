@extends('layouts.app')

@section('content')
    <h1>{{ $month->format('Y-m') }} Sub team emotion calendar</h1>

    <table class="table">
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
            <th>
                <a href="{{ route('team_users.calendar', ['teamUserId' => $mySubTeamUser->team_user_id, 'year'=> $month->format('Y'), 'month'=> $month->format('n')]) }}">{{ $mySubTeamUser->user->name }}</a>
            </th>
            @foreach($calendarWithEmotions as $e)
                <td>
                    <emotion-modal
                      :date="'{{ $e['date']->format('n月j日') }}'"
                      :emotion="{{ json_encode($e['me']) }}"
                    ></emotion-modal>
                </td>
            @endforeach
        </tr>
        @foreach($subTeamUsers as $u)
            <tr>
                <th>
                    <a href="{{ route('team_users.calendar', ['teamUserId' => $u->team_user_id, 'year'=> $month->format('Y'), 'month'=> $month->format('n')]) }}">{{ $u->user->name }}</a>
                </th>
                @foreach($calendarWithEmotions as $e)
                    <td>
                        <emotion-popper
                          :emotion="{{ json_encode($e['members'][$u->user_id]) }}"
                        ></emotion-popper>
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
