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

  @foreach($team_users as $u)
    <tr>
      <th> {{ $u->user->name }}</th>
      @foreach($date_list as $d)
        <td>
            <?php $emotion = byKey("{$d->format('Y-m-d')}-{$u->id}", $emotions); ?>
          <emotion-modal
            emotion="{{ $emotion }}"
            entered-on="{{ $d->format('Y-m-d') }}"
            is-me="{{ $u->user->id === $user_id }}"
            team-user-id="{{ $u->id }}"
          ></emotion-modal>
        </td>
      @endforeach
    </tr>
  @endforeach
  </tbody>
</table>