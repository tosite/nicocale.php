<template>
  <h2>{{ message }}</h2>
</template>

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
