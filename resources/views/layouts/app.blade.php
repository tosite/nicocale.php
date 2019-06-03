<!DOCTYPE html>
<html lang="ja">
<head>
  @include('layouts.header')
  <style>
    [v-cloak] {
      display: none;
    }
    .primary {
      background: #00796B;
      background: -webkit-linear-gradient(to right, #00796B, #00838F);
      background: linear-gradient(to right, #00796B, #00838F);
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
