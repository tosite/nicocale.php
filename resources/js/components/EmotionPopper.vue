<template>
  <div class="text-xs-center">
    <v-tooltip top v-if="e.status_text != null && e.status_text.length != 0">
      <emoji :emoji="e.emoji" :size="localSize" slot="activator"></emoji>
      <span>{{ e.status_text }}</span>
    </v-tooltip>
    <span v-else>
      <emoji :emoji="e.emoji" :size="localSize"></emoji>
    </span>
  </div>
</template>

<script>

  export default {
    props: ['emotion', 'size'],
    data() {
      return {
        e: null,
        localSize: 32,
        defaultEmotion: {
          emoji: ":bust_in_silhouette:",
          status_text: '',
          memo: ''
        },
      }
    },
    created() {
      this.e = (!this.emotion) ? this.defaultEmotion : this.emotion;
      this.localSize = (this.size != null) ? this.size : this.localSize;
    },
  }
</script>
