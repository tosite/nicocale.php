<form action="teams/{{ $team_user->team->id }}/sub_teams" method="POST">
  {{ csrf_field() }}
  <input type="text" name="name">
  <button type="submit" name="add">submit</button>
</form>
