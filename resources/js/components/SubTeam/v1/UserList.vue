<template>
  <v-list-tile avatar>
    <v-list-tile-avatar>
      <img :src="avatar">
    </v-list-tile-avatar>
    <v-list-tile-title>{{ name }}</v-list-tile-title>
  </v-list-tile>
</template>

<script>
  export default {
    props: ['avatar', 'name'],
  }
</script>