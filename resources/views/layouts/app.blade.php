<!DOCTYPE html>
<html lang="ja">
<head>
  @include('layouts.header')
  <style>
    [v-cloak] {
      display: none;
    }
  </style>
</head>
<body class="ma-0">
<div id="app" v-cloak>
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
