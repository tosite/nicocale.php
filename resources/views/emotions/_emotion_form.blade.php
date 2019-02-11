<?php $form_id = "{$team_id}-{$entered_on}"; ?>
<form action="{{ route('emotions.store', ['team_id' => $team_id]) }}" method="POST">
  {{ csrf_field() }}
  <input type="text" id="{{ $form_id }}_entered_on" name="entered_on" value="{{ $entered_on }}">

  <div>
    <label for="{{ $form_id }}_emoji">emoji</label>
    <input type="text" id="{{ $form_id }}_emoji" name="emoji" max="1" value="{{ formValue('emoji', $emotion) }}">
  </div>

  <div>
    <label for="{{ $form_id }}_status_text">status_text</label>
    <input type="text" id="{{ $form_id }}_status_text" name="status_text" max="100" value="{{ formValue('status_text', $emotion) }}">
  </div>

  <div>
    <label for="{{ $form_id }}memo">memo</label>
    <textarea id="{{ $form_id }}_memo" name="memo">{{ formValue('memo', $emotion) }}</textarea>
  </div>

  <button type="submit">submit</button>
</form>
