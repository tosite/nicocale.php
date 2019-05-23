@extends('layouts.lp')

@section('content')
  <v-card flat>
    <v-img src="{{ secure_asset('img/how-to-use/01.png') }}"></v-img>
    <v-card-text>
      <p>初回のみ、画面右上から<code>Add to Slack</code>をクリックします。</p>
    </v-card-text>
  </v-card>

  <v-divider></v-divider>

  <v-card flat>
    <v-img src="{{ secure_asset('img/how-to-use/02.png') }}"></v-img>
    <v-card-text>
      <p>上記画面、右上のセレクトボックスから追加したいワークスペースを選択します。</p>
      <p>許可するをクリックします。</p>
    </v-card-text>
  </v-card>

  <v-divider></v-divider>

  <v-card flat>
    <v-img src="{{ secure_asset('img/how-to-use/03.png') }}"></v-img>
    <v-card-text>
      <p>ログイン画面から、<code>Sign in with Slack</code>をクリックします。</p>
    </v-card-text>
  </v-card>

  <v-divider></v-divider>

  <v-card flat>
    <v-img src="{{ secure_asset('img/how-to-use/04.png') }}"></v-img>
    <v-card-text>
      <p>続行するをクリックします。</p>
    </v-card-text>
  </v-card>
@endsection
