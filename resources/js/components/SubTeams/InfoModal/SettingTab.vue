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
        <v-btn color="primary" flat @click="save">更新する</v-btn>
      </v-card-actions>
    </v-card>

    <v-card flat>
      <v-card-text>
        <v-divider></v-divider>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="error" flat @click="deleteSubTeamUser">チームから退出する</v-btn>
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
    methods: {
      save: function () {
        axios.put(`/api/v1/sub-teams/${this.subTeam.id}`, this.subTeam)
          .then(res => {
            console.log(res);
          })
          .catch(e => {
            console.log(e.response);
          });
      },
      deleteSubTeamUser: function () {
        axios.delete(`/api/v1/sub-team-users/${this.subTeamUser.id}`)
          .then(res => {
            console.log(res);
            window.location.href = '/teams';
          })
          .catch(e => {
            console.log(e.response);
          })
      },
    },
  }
</script>