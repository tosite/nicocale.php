<h1>happy</h1>

<table>
  <thead>
  <tr>
    <th>#</th>
    <th>name</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  @foreach($joined_teams as $cnt => $joined_team)
    <?php $joined_team = $joined_team->team; ?>
    <tr>
      <td>{{ ($cnt + 1) }}</td>
      <td>{{ $joined_team->name }}</td>
      <td><a href="/teams/{{ $joined_team->id }}">edit</a></td>
    </tr>
  @endforeach
  </tbody>
</table>