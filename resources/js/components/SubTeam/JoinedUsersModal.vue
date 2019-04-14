<template>
  <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
    <template v-slot:activator="{ on }">
      <v-btn flat icon color="primary" v-on="on">
        <v-icon>info</v-icon>
      </v-btn>
    </template>
    <v-card>
      <v-toolbar dark color="primary">
        <v-btn icon dark @click="dialog = false">
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>Settings</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>

      <v-expansion-panel
        v-model="panel"
        expand
        class="mb-0 elevation-0"
      >
        <v-expansion-panel-content :key="0">
          <template v-slot:header>
            <div class="title">Joined Users</div>
          </template>
          <v-card>
            <v-list>
              <template>
                <sub-team-user-list-v1 :name="me.user.name" :avatar="me.user.avatar"></sub-team-user-list-v1>
              </template>

              <template v-for="subTeamUser in subTeamUsers">
                <sub-team-user-list-v1 :name="subTeamUser.user.name" :avatar="subTeamUser.user.avatar"></sub-team-user-list-v1>
              </template>

            </v-list>
          </v-card>
        </v-expansion-panel-content>

        <v-expansion-panel-content :key="1">
          <template v-slot:header>
            <div class="title">Not Joined Users</div>
          </template>
          <v-card>
            <v-list>
              <template v-for="subTeamUser in subTeamUsers">
                <sub-team-user-list-v1 :name="subTeamUser.user.name" :avatar="subTeamUser.user.avatar"></sub-team-user-list-v1>
              </template>
            </v-list>
          </v-card>
        </v-expansion-panel-content>

      </v-expansion-panel>
      <v-divider class="ma-0"></v-divider>


      <v-card class="elevation-0 pt-1 pb-1 pl-4 pr-4">
        <div class="title">Settings</div>
      </v-card>

    </v-card>
  </v-dialog>
</template>

<script>
  export default {
    props: ['subTeamUsers', 'me'],
    data() {
      return {
        dialog: false,
        panel: [true, false],
      }
    }
  }
</script>