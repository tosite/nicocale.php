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
      <a
        href="https://slack.com/oauth/authorize?client_id=306106578305.492917770354&scope=emoji:read,users.profile:read,users.profile:write"
      >
        <img alt="Add to Slack"
             height="40"
             width="139"
             src="https://platform.slack-edge.com/img/add_to_slack.png"
             srcset="https://platform.slack-edge.com/img/add_to_slack.png 1x, https://platform.slack-edge.com/img/add_to_slack@2x.png 2x"
        >
      </a>
    </v-toolbar>

    @yield('jumbo-tron')

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
