<template>
  <div class="text-xs-center">
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <span slot="activator">
        <span>New SubTeams</span>
      </span>

      <v-card>
        <v-card-title
          class="headline grey lighten-2"
          primary-title
        >
          <span>New SubTeams</span>
        </v-card-title>

        <v-card-text>
          <v-text-field
            v-model="n"
            :counter="100"
            label="Name"
          ></v-text-field>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            flat
            @click="cancel"
          >Cancel
          </v-btn>

          <v-btn
            color="primary"
            flat
            @click="post"
          >Submit
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  export default {
    props: ['teamUserId', 'subTeamName'],
    data() {
      return {
        dialog: false,
        n: '',
      }
    },
    created () {
      this.n = this.subTeamName;
    },
    methods: {
      cancel: function () {
        this.n      = this.subTeamName;
        this.dialog = false;
      },
      post: function () {
        const params = {};
        params['name']         = this.n;
        params["team_user_id"] = this.teamUserId;
        console.log(params);
        axios.post('/api/v1/sub_teams', params)
          .then((r) => {
            console.log(r)
          })
          .catch((e) => {
            console.log(e.response)
          })
        ;
        this.dialog = false;
      },
    },
  }
</script>
