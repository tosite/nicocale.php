<template>
  <div>
    <v-navigation-drawer
      v-model="drawer"
      class="pb-0 elevation-2"
      floating
      hide-overlay
      stateless
      width="300"
      app
    >
      <v-progress-linear :indeterminate="true" v-if="!loaded" class="mt-1"></v-progress-linear>
      <v-layout fill-height v-else>
        <v-navigation-drawer
          dark
          mini-variant
          stateless
          value="true"
        >
          <v-toolbar flat class="transparent">
          <v-list class="pa-0">
          <v-list-tile avatar>
          <v-list-tile-avatar>
          <img :src="user.avatar">
          </v-list-tile-avatar>

          <v-list-tile-content>
          <v-list-tile-title>{{ user.name }}</v-list-tile-title>
          </v-list-tile-content>

          <v-list-tile-action>
          <v-btn
          icon
          @click.native.stop="mini = !mini"
          >
          <v-icon>chevron_left</v-icon>
          </v-btn>
          </v-list-tile-action>
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
                <v-icon color="grey lighten-1">add</v-icon>
              </v-btn>
            </v-list-tile-action>
          </v-list-tile>

          <v-list-tile
            v-for="subTeam in subTeams"
            :key="subTeam.id"
            @click="locationSubTeamCalendar(subTeam.id)"
          >
            <v-list-tile-title v-text="subTeam.name"></v-list-tile-title>
          </v-list-tile>

          <v-list-tile @click.stop="locateSubTeamNotJoined(currentTeam.id)">
            <v-list-tile-content>
              <v-list-tile-title>サブチームを追加する</v-list-tile-title>
            </v-list-tile-content>

            <v-list-tile-action>
              <v-icon color="grey lighten-1">add</v-icon>
            </v-list-tile-action>
          </v-list-tile>

        </v-list>
      </v-layout>
    </v-navigation-drawer>
  </div>
</template>

<style scoped>
  .v-list__tile__title {
    font-size: 80%;
  }

  #team-name {
    font-size: 100%;
  }
</style>

<script>
  export default {
    data() {
      return {
        dialog: false,
        drawer: true,
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
      locationSubTeamCalendar: function (subTeamId) {
        window.location = `/calendars/2019/3/sub-teams/${subTeamId}`;
      },
    },
  }
</script>