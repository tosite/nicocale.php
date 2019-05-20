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
    <side-nav></side-nav>
    <v-content>
      <v-container fluid style="overflow-x: scroll;">
        @yield('content')
      </v-container>
    </v-content>
  </v-app>
</div>
</body>
</html>
