<template>
  <v-card flat>
    <v-card-text class="pt-0">

      <div class="mt-4 headline">Not Joined User</div>
      <v-flex xs12 sm6>
        <v-text-field
          label="User Name"
          prepend-inner-icon="search"
          v-model="search"
          clearable
        ></v-text-field>
      </v-flex>

      <v-list two-line>
        <template v-for="user in filteredUsers">
          <v-list-tile avatar>
            <v-list-tile-avatar>
              <img :src="user.avatar">
            </v-list-tile-avatar>

            <v-list-tile-content>
              <v-list-tile-title>{{ user.name }}</v-list-tile-title>
              <v-list-tile-sub-title>{{ user.bio }}</v-list-tile-sub-title>
            </v-list-tile-content>

            <v-list-tile-action>
              <v-btn icon ripple>
                <v-icon color="grey lighten-1">add</v-icon>
              </v-btn>
            </v-list-tile-action>

          </v-list-tile>
          <v-divider class="ma-0"></v-divider>

        </template>

      </v-list>
    </v-card-text>
  </v-card>
</template>

<script>
  export default {
    props: ['users'],
    data() {
      return {
        search: '',
      }
    },
    computed: {
      filteredUsers: function () {
        if (this.users == null)
        {
          return null;
        }
        return this.users.filter((user) => {
          return (user.name.indexOf(this.search) !== -1);
        })
      }
    },
  }
</script>