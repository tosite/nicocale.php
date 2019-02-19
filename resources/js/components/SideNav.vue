<template>
  <v-navigation-drawer permanent app>
    <v-toolbar flat>
      <v-list>
        <v-list-tile>
          <v-list-tile-title class="title">
            Application
          </v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-toolbar>

    <v-divider></v-divider>
    <v-list>

      <v-list-group
        prepend-icon="account_circle"
        value="true"
      >
        <v-list-tile slot="activator">
          <v-list-tile-title>Teams</v-list-tile-title>
        </v-list-tile>

        <div v-for="(team, team_id) in items">
          <v-list-group
            no-action
            sub-group
            value="true"
          >
            <v-list-tile slot="activator">
              <v-list-tile-title>{{ team.team.name }}</v-list-tile-title>
            </v-list-tile>

            <sub-team-form-modal></sub-team-form-modal>

            <v-list-tile @click="openTeam(team.team.id)">
              <v-list-tile-title>Open Team</v-list-tile-title>
            </v-list-tile>

            <v-list-tile
              v-for="(sub_team, i) in team.sub_teams"
              :key="i"
              @click="openSubTeam(sub_team.id)"
            >
              <v-list-tile-title v-text="sub_team.name"></v-list-tile-title>
            </v-list-tile>
          </v-list-group>
        </div>
      </v-list-group>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
  export default {
    props: ['teamList', 'yyyymm',],
    data () {
      return {
        items: [],
        right: null
      }
    },
    mounted () {
      this.items = JSON.parse(this.teamList);
    },
    methods: {
      openTeam: function (id) {
        window.location.href = `/teams/${id}`;
      },
      openSubTeam: function (id) {
        window.location.href = `/sub_teams/${id}/${this.yyyymm}`;
      },
    },
  }
</script>
