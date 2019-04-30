@extends('layouts.app')

@section('content')
  <h1>Team user emotion calendar</h1>
  <table id="calendar">
    <thead>
    <tr>
      @foreach (['日', '月', '火', '水', '木', '金', '土'] as $dayOfWeek)
        <th>{{ $dayOfWeek }}</th>
      @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($emotions as $e)
        <?php $date = $e['date']; ?>
        @if ($date->dayOfWeek == 0)
          <tr>
            @endif
            <td
              @if ($date->month != $month->format('m'))
              class="grey lighten-4"
              @endif
            >
              {{ $date->day }}
              @if($date->month != $month->format('m'))
              @elseif($isMe)
                <emotion-modal
                  :date="'{{ $date->format('n月j日') }}'"
                  :emotion="{{ json_encode($e['user']) }}"
                ></emotion-modal>
              @else
                <emotion-popper
                  :emotion="{{ json_encode($e['user']) }}"
                ></emotion-popper>
              @endif
            </td>
            @if ($date->dayOfWeek == 6)
          </tr>
        @endif
    @endforeach
    </tbody>
  </table>
@endsection
