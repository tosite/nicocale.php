<template>
  <v-card>
    <v-list three-line>
      <template v-for="(user, index) in users">
        <v-divider :key="index" class="ma-0"></v-divider>

        <v-list-tile
          :key="user.id"
          avatar
          @click.stop="locationTeamUserCalendar(user.team_user_id)"
        >
          <v-list-tile-avatar>
            <img :src="user.user.avatar">
          </v-list-tile-avatar>

          <v-list-tile-content>
            <v-list-tile-title v-html="user.user.name"></v-list-tile-title>
            <v-list-tile-sub-title v-html="user.user.bio"></v-list-tile-sub-title>
          </v-list-tile-content>
          <v-list-tile-action
            v-if="user.user_id === me.user_id"
            @click.stop="locationSetting(me.id)"
          >
            <v-btn icon ripple>
              <v-icon color="grey lighten-1">settings</v-icon>
            </v-btn>
          </v-list-tile-action>

        </v-list-tile>
      </template>
    </v-list>
  </v-card>
</template>

<script>
  export default {
    props: ['users', 'me'],
    methods: {
      locationSetting: function(subTeamUserId) {
        window.location = `/sub-team-users/${subTeamUserId}/me`;
      },
      locationTeamUserCalendar: function(teamUserId) {
        window.location = `/team-users/${teamUserId}/calendars/2019/3`;
      },
    },
  }
</script>

<style scoped>
</style>