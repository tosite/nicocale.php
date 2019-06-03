<template>
  <v-layout align-center justify-center row fill-height>
    <v-flex class="text-xs-center mt-4">
      <h2 class="word">{{ message }}</h2>
    </v-flex>
  </v-layout>
</template>

<style scoped>
  .word {
    color: #ACB6E5;
    background: -webkit-linear-gradient(0deg, #00F260, #0575E6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
</style>
<script>
  export default {
    data() {
      return {
        messages: [
          'あらゆる偉業の出発点は、目的を明確にすることから。',
          '想像力さえあれば、無限の力を発揮できる。',
        ],
      }
    },
    computed: {
      message: function ()
      {
        let min = 0;
        let max = this.messages.length;
        let num = Math.floor(Math.random() * (max - min)) + min;
        return this.messages[num];
      }
    },
  }
</script>
