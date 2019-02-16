@extends('layouts.app')

@section('content')
    <?php
    $params = [
        'team'          => $team,
        'emotions'      => $emotions,
        'date_list'     => $date_list,
        'day_of_weeks'  => $day_of_weeks,
        'team_users'    => $team_users,
        'user_id'       => $user_id,
        'months'        => $months,
    ];
    ?>
    @include('teams._team_table', $params)
@endsection
