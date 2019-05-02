<template>
  <v-layout row wrap>
    <v-flex xs12 sm8 offset-sm2 class="pt-4">
      <v-card v-if="subTeam != null">

        <v-card-text>
          <v-text-field
            label="チーム名"
            v-model="subTeam.name"
          ></v-text-field>

          <v-textarea label="概要" v-model="subTeam.bio"></v-textarea>

        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" flat @click="save">更新する</v-btn>
        </v-card-actions>
      </v-card>
    </v-flex>
  </v-layout>
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