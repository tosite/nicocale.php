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
        v-if="loading"
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
      <v-tabs v-model="active" color="primary" dark slider-color="accent">
        <v-tab ripple key="1">チームに参加する</v-tab>
        <v-tab ripple key="2">チームを作成する</v-tab>
        <v-tab-item key="1">
          <v-card>
            <v-card-text>
              <v-text-field
                label="チーム名"
                v-model="newSubTeam.name"
              ></v-text-field>

              <v-textarea label="概要" v-model="newSubTeam.bio"></v-textarea>

            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="disabled" flat @click="cancel">閉じる</v-btn>
              <v-btn color="primary" flat @click="createSubTeam">作成する</v-btn>
            </v-card-actions>
          </v-card>

        </v-tab-item>
        <v-tab-item key="2">
        </v-tab-item>
      </v-tabs>
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
        active: null,
        drawer: null,
        mini: true,
        right: null,
        teams: [],
        subTeams: [],
        currentTeam: {},
        user: {},
        loading: true,
        newSubTeam: {
          name: '',
          bio: '',
        },
      }
    },
    created() {
      this.fetchSideNav();
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
      fetchSideNav: function () {
        axios.get('/api/v1/side-navigations').then((res) => {
          this.user = res.data.user;
          this.teams = res.data.teams;
          this.subTeams = res.data.subTeams;
          this.currentTeam = res.data.currentTeam;
          this.newSubTeam.team_id = this.currentTeam.id;
        }).catch((e) => {
          console.log(e.data)
        }).finally(() => {
          this.loading = false;
        });
      },
      createSubTeam: function () {
        axios.post(`/api/v1/sub-teams`, this.newSubTeam)
          .catch(res => {
            console.log(res);
            // TODO: @tosite add sub-team-user
          })
          .then(e => {
            console.log(e.response);
          })
          .finally(() => {
            this.dialog = false;
          });
      },
      createSubTeamUser: function () {
        // axios.post(`/api/v1/sub-team-users`, {sub_team_id: subTeamId, user_id: this.user.id}).then(res => {
        //   this.snackbar = {open: true, type: 'success', text: 'チームに参加しました。'}
        // }).catch(e => {
        //   this.snackbar = {open: true, type: 'error', text: '処理に失敗しました。'}
        // });
      },
      cancel: function () {
        this.newSubTeam.name = '';
        this.newSubTeam.bio = '';
        this.dialog = false;
      },
    },
  }
</script>