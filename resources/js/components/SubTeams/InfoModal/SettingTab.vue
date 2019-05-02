<template>
  <v-card v-if="subTeam != null" flat>

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
</template>

<script>
  export default {
    props: ['subTeam'],
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
    },
  }
</script>