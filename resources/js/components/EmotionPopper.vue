<template>
  <div class="text-xs-center">
    <v-tooltip top v-if="e.status_text != null && e.status_text.length != 0">
      <emoji :emoji="e.emoji" :size="localSize" slot="activator" :class="color" class="good emoji-line lighten-2" style="background-color: transparent !important;"></emoji>
      <span>{{ e.status_text }}</span>
    </v-tooltip>
    <span v-else>
      <emoji :emoji="e.emoji" :size="localSize"></emoji>
    </span>
  </div>
</template>

<style scoped>
  .emoji-line {
    border-radius: 50%;
    border: 2px solid;
    background-color: transparent !important;
  }
</style>

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
        score: {
          good: 1,
          soso: 2,
          bad: 3,
        },
      }
    },
    created() {
      this.e = (!this.emotion) ? this.defaultEmotion : this.emotion;
      this.localSize = (this.size != null) ? this.size : this.localSize;
    },
    watch: {
      emotion: function () {
        this.e = (!this.emotion) ? this.defaultEmotion : this.emotion;
      },
    },
    computed: {
      color: function () {
        if (this.e.score == this.score.good) { return 'good'; }
        if (this.e.score == this.score.soso) { return 'soso'; }
        if (this.e.score == this.score.bad) { return 'bad'; }
        return '';
      }
    },
  }
</script>
