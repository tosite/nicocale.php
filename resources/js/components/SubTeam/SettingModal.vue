<template>
  <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
    <template v-slot:activator="{ on }">
      <v-btn flat icon color="accent" v-on="on">
        <v-icon>info</v-icon>
      </v-btn>
    </template>

    <v-card>
      <div>
        <v-toolbar
          color="primary"
          dark
          tabs
        >
          <v-btn icon dark @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>

          <v-toolbar-title>Settings</v-toolbar-title>

          <template v-slot:extension>
            <v-tabs
              v-model="tab"
              color="primary"
              slider-color="accent"
            >
              <v-tab :key="0" href="#tab-0">Joined User</v-tab>
              <v-tab :key="1" href="#tab-1">Not Joined User</v-tab>
              <v-tab :key="2" href="#tab-2">Settings</v-tab>
            </v-tabs>
          </template>

        </v-toolbar>

        <v-tabs-items v-model="tab">
          <v-tab-item :key="0" value="tab-0">
            <sub-team-info-modal-joined-user-tab
              :users="joinedUsers"
            ></sub-team-info-modal-joined-user-tab>
          </v-tab-item>

          <v-tab-item :key="1" value="tab-1">
            <v-card flat>
              <sub-team-info-modal-not-joined-user-tab
                :users="notJoinedUsers"
              ></sub-team-info-modal-not-joined-user-tab>
            </v-card>
          </v-tab-item>

          <v-tab-item :key="2" value="tab-2">
            <v-card flat>
              <sub-team-info-modal-setting-tab
                :sub-team="subTeam"
              ></sub-team-info-modal-setting-tab>
            </v-card>
          </v-tab-item>

        </v-tabs-items>
      </div>

    </v-card>

  </v-dialog>
</template>

<script>
  export default {
    props: ['subTeamId'],
    data() {
      return {
        dialog: false,
        panel: [true, false],
        tab: 'tab-0',
        joinedUsers: null,
        notJoinedUsers: null,
        subTeam: null,
      }
    },
    methods: {
      fetchParams: function () {
        axios.get(`/api/v1/sub-teams/${this.subTeamId}/info-modals`).then(res => {
          this.joinedUsers = res.data.joinedUsers;
          this.notJoinedUsers = res.data.notJoinedUsers;
          this.subTeam = res.data.subTeam;
        }).catch(e => {
        });
      }
    },
    mounted() {
      this.fetchParams();
    }
  }
</script>