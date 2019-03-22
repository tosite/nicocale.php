@extends('layouts.app')

@section('content')
    <h1>Sub team User index</h1>
    <?php $d = new \DateTime(); ?>
    @foreach($subTeamUsers as $stu)
        <p>
            <a href="{{ route('team_users.calendar', ['teamUserId' => $stu->team_user_id, 'year'=> $d->format('Y'), 'month'=> $d->format('n')]) }}">{{ $stu->user->name }}</a>
        </p>
    @endforeach
@endsection
