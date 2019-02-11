<?php $form_id = "{$team_id}-{$entered_on}"; ?>
<form action="{{ route('emotions.store', ['team_id' => $team_id]) }}" method="POST">
  {{ csrf_field() }}
  <input type="text" id="{{ $form_id }}_entered_on" name="entered_on" value="{{ $entered_on }}">

  <div>
    <label for="{{ $form_id }}_emoji">emoji</label>
    <input type="text" id="{{ $form_id }}_emoji" name="emoji" max="1" value="{{ isset($emotion) ? $emotion->emoji : old('emoji') }}">
    @if($errors->has('emoji')) <p>{{ $errors->first('emoji') }}</p> @endif
  </div>

  <div>
    <label for="{{ $form_id }}_status_text">status_text</label>
    <input type="text" id="{{ $form_id }}_status_text" name="status_text" max="100" value="{{ isset($emotion) ? $emotion->status_text : old('emoji') }}">
    @if($errors->has('status_text')) <p>{{ $errors->first('status_text') }}</p> @endif
  </div>

  <div>
    <label for="{{ $form_id }}memo">memo</label>
    <textarea id="{{ $form_id }}_memo" name="memo">{{ isset($emotion) ? $emotion->memo : old('memo') }}</textarea>
    @if($errors->has('memo')) <p>{{ $errors->first('memo') }}</p> @endif
  </div>

  <button type="submit">submit</button>
</form>
