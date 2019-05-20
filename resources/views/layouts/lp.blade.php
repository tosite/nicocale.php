<!DOCTYPE html>
<html lang="ja">
<head>
  @include('layouts.header')
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
