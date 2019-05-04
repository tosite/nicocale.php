<template>
  <v-layout row>
    <v-flex xs12 sm8 offset-sm2>
      <v-card>

        <v-toolbar color="primary" dark>
          <v-toolbar-title>未参加のサブチーム</v-toolbar-title>
        </v-toolbar>
        <v-alert
          :value="true"
          color="warning"
          icon="priority_high"
          class="mt-0"
          outline
          v-if="notJoinedSubTeams == false"
        >
          未参加のサブチームはありません。
        </v-alert>

        <v-list two-line subheader class="pb-0" v-else>
          <div v-for="subTeam in notJoinedSubTeams">
            <v-list-tile :key="subTeam.id">
              <v-list-tile-content>
                <v-list-tile-title>{{ subTeam.name }}</v-list-tile-title>
                <v-list-tile-sub-title>{{ subTeam.bio }}</v-list-tile-sub-title>
              </v-list-tile-content>

              <v-list-tile-action>
                <v-btn icon ripple @click.stop="">
                  <v-icon color="grey lighten-1" @click="addSubTeamUser(subTeam.id)">add_circle</v-icon>
                </v-btn>
              </v-list-tile-action>
            </v-list-tile>
            <v-divider class="ma-0"></v-divider>
          </div>
        </v-list>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
  export default {
    props: ['notJoinedSubTeams', 'user'],
    methods: {
      addSubTeamUser: function (subTeamId) {
        axios.post(`/api/v1/sub-team-users`, {sub_team_id: subTeamId, user_id: this.user.id})
          .then(res => {
            console.log(res);
          }).catch(e => {
          console.log(e.response);
        });
      },
    },
  }
</script>
