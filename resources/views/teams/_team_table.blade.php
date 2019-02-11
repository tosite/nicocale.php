<?php $entered_on = date('Y-m-d') ?>

<table>
  <thead>
  <tr>
    <th>name</th>
    @foreach($date_list as $date)
      <th>{{ $date->day }} ({{ $day_of_weeks[$date->dayOfWeek] }})</th>
    @endforeach
  </tr>
  </thead>
  <tbody>

  @foreach($users as $u)
    <tr>
      <th> {{ $u->user->name }}</th>
      @foreach($date_list as $d)
        <td>
          @if($u->user->id === $user_id)
            <?php $e = isset($emotions["{$d->format('Y-m-d')}-{$u->id}"]) ? $emotions["{$d->format('Y-m-d')}-{$u->id}"] : null; ?>
            @include('emotions._emotion_form', ['team_id'=>$team->id, 'emotion' => $e, 'entered_on' => $d->format('Y-m-d')])
          @elseif(isset($emotions["{$d->format('Y-m-d')}-{$u->id}"]))
            <?php $e = $emotions["{$d->format('Y-m-d')}-{$u->id}"]; ?>
            {{ $e->emoji }}
          @endif
        </td>
      @endforeach
    </tr>
  @endforeach
  </tbody>
</table>