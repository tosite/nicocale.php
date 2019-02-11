<form action="{{ route('emotions.store', ['team_id' => $team->id]) }}" method="POST">
  {{ csrf_field() }}
  <div>
    <label for="{{ $form_id }}_emoji">emoji</label>
    <input type="text" id="{{ $form_id }}_emoji" name="emoji" max="1">
    @if($errors->has('emoji')) <p>{{ $errors->first('emoji') }}</p> @endif
  </div>

  <div>
    <label for="{{ $form_id }}_entered_on">entered_on</label>
    <input type="date" id="{{ $form_id }}_entered_on" name="entered_on" value="{{ $entered_on }}">
    @if($errors->has('entered_on')) <p>{{ $errors->first('entered_on') }}</p> @endif
  </div>

  <div>
    <label for="{{ $form_id }}_status_text">status_text</label>
    <input type="text" id="{{ $form_id }}_status_text" name="status_text" max="100">
    @if($errors->has('status_text')) <p>{{ $errors->first('status_text') }}</p> @endif
  </div>

  <div>
    <label for="{{ $form_id }}memo">memo</label>
    <textarea id="{{ $form_id }}_memo" name="memo"></textarea>
    @if($errors->has('memo')) <p>{{ $errors->first('memo') }}</p> @endif
  </div>

  <button type="submit">submit</button>
</form>