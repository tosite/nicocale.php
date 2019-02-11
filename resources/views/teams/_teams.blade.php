<h1>happy</h1>

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
        <td>{{ $team->name }}</td>
        <td>
          <img src="{{ $team->avatar }}">
        </td>
      </tr>
  @endforeach
  </tbody>
</table>