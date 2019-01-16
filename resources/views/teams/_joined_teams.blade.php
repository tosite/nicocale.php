<h1>happy</h1>

<table>
  <thead>
  <tr>
    <th>#</th>
    <th>name</th>
  </tr>
  </thead>
  <tbody>
  @foreach($joined_teams as $cnt => $joined_team)
    <tr>
      <td>{{ ($cnt + 1) }}</td>
      <td>{{ $joined_team->team->name }}</td>
    </tr>
  @endforeach
  </tbody>
</table>