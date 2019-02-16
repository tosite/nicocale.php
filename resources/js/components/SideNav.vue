<template>
  <v-navigation-drawer permanent app>
    <v-toolbar flat>
      <v-list>
        <v-list-tile>
          <v-list-tile-title class="title">
            Application
          </v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-toolbar>

    <v-divider></v-divider>

    <v-list dense class="pt-0">
      <v-list-tile
        v-for="item in items"
        :key="item.id"
        @click="href(item.id)"
      >
        <v-list-tile-avatar>
          <img :src="item.avatar">
        </v-list-tile-avatar>

        <v-list-tile-content>
          <v-list-tile-title>{{ item.name }}</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
  export default {
    props: ['params', 'url'],
    data () {
      return {
        items: [],
        urls: [],
        right: null
      }
    },
    mounted () {
      this.items = JSON.parse(this.params);
      this.urls  = JSON.parse(this.url);
    },
    methods: {
      href (id) {
        window.location.href = `/${this.urls.prefix}/${id}/${this.urls.suffix}`;
      },
    },
  }
</script>
