<template>
  <div>
    <v-navigation-drawer
      v-model="drawer"
      class="pb-0 elevation-2"
      floating
      width="300"
      app
    >
      <v-progress-linear
        :indeterminate="true"
        color="secondary"
        v-if="!loaded"
        class="mt-1"
      ></v-progress-linear>
      <v-layout fill-height v-else>
        <v-navigation-drawer
          dark
          mini-variant
          stateless
          value="true"
        >
          <v-toolbar flat class="transparent">
            <v-list class="pa-0">
              <v-list-tile avatar @click.stop="locateMe(currentTeam.id)">
                <v-list-tile-avatar>
                  <img :src="user.avatar" alt="avatar">
                </v-list-tile-avatar>

                <v-list-tile-content>
                  <v-list-tile-title>{{ user.name }}</v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
            </v-list>
          </v-toolbar>

          <v-list class="pt-2" dense>
            <v-divider></v-divider>

            <v-list-tile
              v-for="team in teams"
              :key="team.id"
              @click.stop=""
            >
              <v-list-tile-action>
                <v-avatar size="30px">
                  <img :src="team.avatar">
                </v-avatar>
              </v-list-tile-action>

              <v-list-tile-content>
                <v-list-tile-title>{{ team.name }}</v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>

            <v-list-tile @click.stop="">
              <v-list-tile-action>
                <v-icon>add</v-icon>
              </v-list-tile-action>
            </v-list-tile>
          </v-list>
        </v-navigation-drawer>

        <v-list class="grow">

          <v-list-tile
            @click.stop="locateSubTeamIndex(currentTeam.id)"
          >
            <v-list-tile-content>
              <v-list-tile-title>{{ currentTeam.name }}</v-list-tile-title>
            </v-list-tile-content>

            <v-list-tile-action @click.stop="locateSubTeamNew(currentTeam.id)">
              <v-btn icon ripple>
              </v-btn>
            </v-list-tile-action>
          </v-list-tile>

          <v-list-tile
            v-for="subTeam in subTeams"
            :key="subTeam.id"
            @click="locateSubTeamCalendar(subTeam.id)"
          >
            <v-list-tile-title v-text="subTeam.name"></v-list-tile-title>
          </v-list-tile>

          <v-list-tile @click.stop="locateSubTeamNotJoined(currentTeam.id)">
            <v-list-tile-content>
              <v-list-tile-title>チームを追加する</v-list-tile-title>
            </v-list-tile-content>

            <v-list-tile-action>
              <v-icon color="grey lighten-1" @click.stop="dialog = !dialog">add_circle</v-icon>
            </v-list-tile-action>
          </v-list-tile>

        </v-list>
      </v-layout>
    </v-navigation-drawer>

    <v-toolbar color="primary" dark app>
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
      <v-toolbar-title>NicoCale</v-toolbar-title>

      <v-spacer></v-spacer>

      <v-menu offset-y min-width="200">
        <template v-slot:activator="{ on }">
          <v-btn
            dark
            flat
            v-on="on"
          >
            {{ user.name }}
          </v-btn>
        </template>
        <v-list>
          <v-list-tile :href="`/teams/${currentTeam.id}/me`">
            <v-list-tile-title>
              ユーザー設定
            </v-list-tile-title>
          </v-list-tile>
          <v-list-tile href="/auth/slack/logout">
            <v-list-tile-title>
              ログアウト
            </v-list-tile-title>
          </v-list-tile>
        </v-list>
      </v-menu>
    </v-toolbar>

    <v-dialog v-model="dialog" width="500">
      <v-card>
        <v-card-title class="headline primary white--text" primary-title>チームを作成する</v-card-title>

        <v-card-text>
          <v-text-field
            label="チーム名"
          ></v-text-field>

          <v-textarea label="概要"></v-textarea>

        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="disabled" flat @click="dialog = false">閉じる</v-btn>
          <v-btn color="primary" flat @click="dialog = false">作成する</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </div>
</template>

<style scoped>
  .v-list__tile__title {
    font-size: 80%;
  }

  #team-name {
    font-size: 100%;
  }

  .v-navigation-drawer--mini-variant {
    transform: translateX(0px) !important;
  }
</style>

<script>
  export default {
    data() {
      return {
        dialog: false,
        drawer: null,
        mini: true,
        right: null,
        teams: [],
        subTeams: [],
        currentTeam: {},
        user: {},
        loaded: false,
      }
    },
    created() {
      axios.get('/api/v1/side-navigations').then((res) => {
        this.user = res.data.user;
        this.teams = res.data.teams;
        this.subTeams = res.data.subTeams;
        this.currentTeam = res.data.currentTeam;
        this.loaded = true;
      }).catch((e) => {
        console.log(e.data)
      });
    },
    methods: {
      locateSubTeamIndex: function (teamId) {
        window.location = `/teams/${teamId}/sub-teams`
      },
      locateSubTeamNew: function (teamId) {
        window.location = `/teams/${teamId}/new`
      },
      locateSubTeamNotJoined: function (teamId) {
        window.location = `/teams/${teamId}/sub-teams/not-joined`
      },
      locateSubTeamCalendar: function (subTeamId) {
        let month = dayjs().format('YYYY/M');
        window.location = `/sub-teams/${subTeamId}/calendars/${month}`;
      },
      locateMe: function (teamId) {
        window.location = `/teams/${teamId}/me`
      },
    },
  }
</script>