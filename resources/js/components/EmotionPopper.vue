<template>
  <div class="text-xs-center">
    <v-tooltip top v-if="e.status_text.length!==0">
      <emoji :emoji="e.emoji" :size="32" slot="activator"></emoji>
      <span>{{ e.status_text }}</span>
    </v-tooltip>
    <span v-else>
      <emoji :emoji="e.emoji" :size="32"></emoji>
    </span>
  </div>
</template>

<script>

  export default {
    props: ['emotion',],
    data() {
      return {
        e: null,
        defaultEmotion: {
          emoji: ":bust_in_silhouette:",
          status_text: '',
          memo: ''
        },
      }
    },
    created() {
      this.e = (!this.emotion) ? this.defaultEmotion : this.emotion;
    },
  }
</script>
