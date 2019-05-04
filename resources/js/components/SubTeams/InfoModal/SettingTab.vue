<template>
  <div v-if="subTeam != null">
    <v-card flat>

      <v-card-text>
        <v-text-field
          label="チーム名"
          v-model="subTeam.name"
        ></v-text-field>

        <v-textarea label="概要" v-model="subTeam.bio"></v-textarea>

      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="primary" flat @click="$emit('updateSubTeam')">更新する</v-btn>
      </v-card-actions>
    </v-card>

    <v-card flat>
      <v-card-text>
        <v-divider></v-divider>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="error" flat @click="$emit('deleteSubTeamUser')">チームから退出する</v-btn>
      </v-card-actions>
    </v-card>
  </div>

</template>

<script>
  export default {
    props: ['subTeam', 'subTeamUser'],
    data() {
      return {}
    },
  }
</script>