@extends('layouts.lp')

@section('content')
  <v-layout row>
    <v-flex xs12 sm10 offset-sm1 md8 offset-md2>
      <v-card>
        <v-card-title class="white--text headline primary">Slackアカウントでログインする</v-card-title>
        <v-card-text>
          <div class="text-xs-center" >
            <a href="/auth/slack">
              <img
                alt="Sign in with Slack"
                height="40" width="172"
                src="https://platform.slack-edge.com/img/sign_in_with_slack.png"
                srcset="https://platform.slack-edge.com/img/sign_in_with_slack.png 1x, https://platform.slack-edge.com/img/sign_in_with_slack@2x.png 2x"
              >
            </a>
          </div>
          <p>Slackアカウントを利用してログインできます。</p>
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
@endsection
