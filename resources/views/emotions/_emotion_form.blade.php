<form action="{{ route('emotions.store', ['team_id' => $team]) }}" method="POST">
  {{ csrf_field() }}
  <input type="text" name="hoge">
</form>