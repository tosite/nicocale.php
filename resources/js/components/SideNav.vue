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
      <v-layout fill-height>
        <v-navigation-drawer
          dark
          mini-variant
          stateless
          value="true"
        >
          <!--<v-toolbar flat class="transparent">-->
          <!--<v-list class="pa-0">-->
          <!--<v-list-tile avatar>-->
          <!--<v-list-tile-avatar>-->
          <!--<img src="https://randomuser.me/api/portraits/men/85.jpg">-->
          <!--</v-list-tile-avatar>-->

          <!--<v-list-tile-content>-->
          <!--<v-list-tile-title>John Leider</v-list-tile-title>-->
          <!--</v-list-tile-content>-->

          <!--<v-list-tile-action>-->
          <!--<v-btn-->
          <!--icon-->
          <!--@click.native.stop="mini = !mini"-->
          <!--&gt;-->
          <!--<v-icon>chevron_left</v-icon>-->
          <!--</v-btn>-->
          <!--</v-list-tile-action>-->
          <!--</v-list-tile>-->
          <!--</v-list>-->
          <!--</v-toolbar>-->

          <v-list class="pt-2" dense>
            <v-divider></v-divider>

            <v-list-tile
              v-for="team in teams"
              :key="team.id"
              @click=""
            >
              <v-list-tile-action>
                <v-avatar size="36px">
                  <img :src="team.avatar">
                </v-avatar>
              </v-list-tile-action>

              <v-list-tile-content>
                <v-list-tile-title>{{ team.name }}</v-list-tile-title>
              </v-list-tile-content>
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
            @click=""
          >
            <v-list-tile-title v-text="subTeam.name"></v-list-tile-title>
          </v-list-tile>
        </v-list>
      </v-layout>
    </v-navigation-drawer>
  </div>
</template>

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
      }
    },
    created () {
      axios.get('/api/v1/side-navigations').
      then((res) => {
        console.log(res);
        this.teams = res.data.teams;
        this.subTeams = res.data.subTeams;
        this.currentTeam = res.data.currentTeam;
      }).
      catch((e) => {
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
    },
  }
</script>
