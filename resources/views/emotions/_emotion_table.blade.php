<month-selector
  months="{{ json_encode($months) }}"
  uri="/sub_teams/{{ $team->id }}/"
></month-selector>
<table>
  <thead>
  <tr>
    <th>name</th>
    @foreach($date_list as $date)
      <th class="text-xs-center lighten-5 @if($date->dayOfWeek == 6) blue @elseif($date->dayOfWeek ==0) red @endif">
        {{ $date->day }} ({{ $day_of_weeks[$date->dayOfWeek] }})
      </th>
    @endforeach
  </tr>
  </thead>
  <tbody>

  @foreach($sub_team_users as $u)
    <tr>
      <th> {{ $u->team_user->user->name }}</th>
      @foreach($date_list as $d)
        <td class="pl-3 pr-3 pt-1 pb-1 text-xs-center lighten-5 @if($d->dayOfWeek == 6) blue @elseif($d->dayOfWeek ==0) red @endif">
            <?php $emotion = byKey("{$d->format('Y-m-d')}-{$u->team_user->id}", $emotions); ?>
          <emotion-modal
            emotion="{{ $emotion }}"
            entered-on="{{ $d->format('Y-m-d') }}"
            is-me="{{ $u->team_user->user_id === $user_id }}"
            team-user-id="{{ $u->team_user->id }}"
          ></emotion-modal>
        </td>
      @endforeach
    </tr>
  @endforeach
  </tbody>
</table>