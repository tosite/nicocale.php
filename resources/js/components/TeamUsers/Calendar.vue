<template>
  <v-layout wrap>
    <v-flex xs12 v-if="today != null">
      <h1>{{ today | month }}</h1>
      <v-date-picker v-model="currentMonth" type="month" color="primary" locale="jp-ja"></v-date-picker>
      <v-sheet height="600">
        <v-calendar :now="today" :value="today" color="primary" locale="jp-ja">
          <template v-slot:day="{ present, past, date }">
            <template v-if="emotions[date] != null && emotions[date].user != null">
              <p class="text-xs-center mb-0 mt-2">
                <emotion-popper :emotion="emotions[date].user" :size="48"></emotion-popper>
              </p>
            </template>
          </template>
        </v-calendar>
      </v-sheet>
    </v-flex>
  </v-layout>
</template>


<script>
  export default {
    props: ['emotions'],
    data: () => ({
      today: null,
      currentMonth: null,
    }),
    created() {
      this.today = dayjs().format('YYYY-MM-DD');
      this.currentMonth = dayjs().format('YYYY-MM');
    },
    filters: {
      month: function (date) {
        return dayjs(date).format('YYYY年M月');
      },
    },
  }
</script>

<style scoped>
  .v-calendar { border: 1px solid #ddd !important; }
</style>