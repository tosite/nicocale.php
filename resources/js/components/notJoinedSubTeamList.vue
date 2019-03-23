<template>
  <v-card>
    <v-list two-line subheader>

      <div
        v-for="subTeam in notJoinedSubTeams"
      >
        <v-list-tile :key="subTeam.id" avatar>
          <v-list-tile-avatar>
            <img :src="subTeam.avatar">
          </v-list-tile-avatar>

          <v-list-tile-content>
            <v-list-tile-title>{{ subTeam.name }}</v-list-tile-title>
            <v-list-tile-sub-title>{{ subTeam.bio }}</v-list-tile-sub-title>
          </v-list-tile-content>

          <v-list-tile-action>
            <v-btn icon ripple @click.stop="">
              <v-icon color="grey lighten-1">add_circle_outline</v-icon>
            </v-btn>
          </v-list-tile-action>
        </v-list-tile>
        <v-divider></v-divider>
      </div>
    </v-list>
  </v-card>
</template>

<script>
  export default {
    props: ['notJoinedSubTeams'],
  }
</script>

<style scoped>

</style>