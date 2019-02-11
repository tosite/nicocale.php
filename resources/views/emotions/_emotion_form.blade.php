<form action="{{ route('emotions.store', ['team_id' => $team->id]) }}" method="POST">
  {{ csrf_field() }}
  <label for="{{ $form_id }}_emoji">emoji</label>
  <input type="text" id="{{ $form_id }}_emoji" name="emoji" max="1">

  <label for="{{ $form_id }}_entered_on">entered_on</label>
  <input type="date" id="{{ $form_id }}_entered_on" name="entered_on" value="{{ $entered_on }}">

  <label for="{{ $form_id }}_status_text">status_text</label>
  <input type="text" id="{{ $form_id }}_status_text" name="status_text" max="100">

  <label for="{{ $form_id }}memo">memo</label>
  <textarea id="{{ $form_id }}_memo" name="memo"></textarea>
</form>