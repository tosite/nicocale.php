<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <script src="{{ secure_asset('js/app.js') }}" defer></script>
  <script>window.Laravel = {csrfToken: "{{ csrf_token() }}"};</script>
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
</head>
<body>
<div id="app">
  <v-app>
    <v-toolbar dark color="primary">
      <v-toolbar-title class="white--text">NicoCale</v-toolbar-title>
      <v-spacer></v-spacer>
    </v-toolbar>

    <v-content>
      <v-container fluid style="overflow-x: scroll;">
        <v-layout row wrap>
          <v-flex xs12 sm10 offset-sm1 md8 offset-md2 lg6 offset-lg3>
            @yield('content')
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</div>
</body>
</html>
