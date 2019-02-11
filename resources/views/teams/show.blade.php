@extends('layouts.app')

@section('content')
    <?php
    $params = [
        'team'      => $team,
        'emotions'  => $emotions,
        'date_list' => $date_list,
        'week_days' => $week_days,
        'users'     => $users,
        'user_id'   => $user_id,
    ];
    ?>
    @include('teams._team_detail', $params)
@endsection
