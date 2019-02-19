<table>
  <thead>
  <tr>
    <th>#</th>
    <th>name</th>
  </tr>
  </thead>
  <tbody>
  @foreach($team_users as $cnt => $team_user)
      <?php $team = $team_user->team; ?>
      <tr>
        <td>{{ ($cnt + 1) }}</td>
        <td>
          <a href="{{ route('teams.show', ['team_id'=>$team->id,'yyyymm'=>date('Ym')]) }}">{{ $team->name }}</a>
        </td>
        <td>
          <img src="{{ $team->avatar }}">
        </td>
      </tr>
  @endforeach
  </tbody>
</table>