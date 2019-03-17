<form action="/teams/{{ $teamId }}" method="POST">
  {{ csrf_field() }}
  <input type="text" name="name">
  <button type="submit" name="add">create sub team</button>
</form>
