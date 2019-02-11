@extends('layouts.app')

@section('content')
    <?php
    $params = [
        'team'         => $team,
        'emotions'     => $emotions,
        'date_list'    => $date_list,
        'day_of_weeks' => $day_of_weeks,
        'users'        => $users,
        'user_id'      => $user_id,
    ];
    ?>
    @include('teams._team_table', $params)
@endsection