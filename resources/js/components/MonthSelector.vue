<template>
  <v-layout wrap align-center>
    <v-flex xs12 sm6 d-flex>
      <v-select
        v-model="selected"
        :items="items"
        item-text="display"
        item-value="value"
        label="Month"
        return-object
        single-line
        solo
      ></v-select>
    </v-flex>
  </v-layout>
</template>


<script>
  export default {
    props: ['months', 'uri'],
    data: function () {
      return {
        items:    [],
        selected: {},
      };
    },
    watch: {
      selected: function () {
        if(this.selected['value'] == JSON.parse(this.months)['selected']['value']) return;
        window.location.href = this.uri + this.selected['value'];
      },
    },
    mounted () {
      const m = JSON.parse(this.months);
      this.selected = m['selected'];
      this.items    = m['items'];
    },
  }
</script>
