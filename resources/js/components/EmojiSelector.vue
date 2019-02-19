<template>
  <div class="text-xs-center">
    <span v-for="e in normalEmojis">
      <v-btn flat @click="selectEmoji(e)" style="height: 54px; min-width: 0px;">
        <span class="display-2">{{ e }}</span>
      </v-btn>
    </span>

    <v-expansion-panel class="elevation-0">
      <v-expansion-panel-content>
        <div slot="header">show more</div>
        <v-card>
          <v-card-text class="text-xs-center pa-0">
            <span v-for="e in allEmojis">
              <v-btn flat @click="selectEmoji(e)" style="height: 40px; min-width: 0px;">
                <span class="display-1">{{ e }}</span>
              </v-btn>
            </span>
          </v-card-text>
        </v-card>
      </v-expansion-panel-content>
    </v-expansion-panel>
  </div>
</template>


<script>
  export default {
    data: function () {
      return {
        selectedEmoji: '',
        dialog: false,
        normalEmojis: ['😃', '😐', '😥'],
        allEmojis: ['☺️', '😊', '😇', '🧐', '😖'],
      };
    },
    methods: {
      selectEmoji: function (emoji) {
        this.$emit('selectEmoji', emoji);
        this.dialog = false;
      },
    },
  }
</script>
