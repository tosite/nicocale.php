<template>
  <v-snackbar
    v-model="snackbar.open"
    :bottom="true"
    :multi-line="true"
    :right="true"
  >
    <v-icon :color="snackbar.type">info</v-icon>{{ snackbar.text }}
    <v-btn color="disabled" flat @click="$emit('closeSnackbar')">閉じる</v-btn>
  </v-snackbar>
</template>

<script>
  export default {
    props: ['snackbar'],
    data() {
      return {
      }
    },
  }
</script>