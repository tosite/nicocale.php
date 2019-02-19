@extends('layouts.app')

@section('content')
    <?php
    $params = [
        'team'           => $sub_team,
        'emotions'       => $emotions,
        'date_list'      => $date_list,
        'day_of_weeks'   => $day_of_weeks,
        'sub_team_users' => $sub_team_users,
        'user_id'        => $user_id,
        'months'         => $months,
    ];
    ?>
    @include('emotions._emotion_table', $params)
@endsection
