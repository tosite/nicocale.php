<?php $entered_on = date('Y-m-d') ?>
@include('emotions._emotion_form', ['team' => $team, 'entered_on' => $entered_on, 'form_id' => $team->id."_".$entered_on])
