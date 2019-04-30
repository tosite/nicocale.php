<template>
  <v-layout wrap>
    <v-flex xs12 v-if="today != null">
      <v-layout row>
        <v-dialog v-model="pickerModal" max-width="290px">
          <template v-slot:activator="{ on }">
            <h1>{{ currentMonth | month }}</h1>
            <v-btn color="accent" dark v-on="on" icon flat>
              <v-icon>more_vert</v-icon>
            </v-btn>
          </template>
          <v-date-picker v-model="currentMonth" type="month" color="primary" locale="jp-ja"></v-date-picker>
        </v-dialog>
      </v-layout>
      <v-sheet height="600">
        <v-calendar :now="today" :value="today" color="primary" locale="jp-ja">
          <template v-slot:day="{ present, past, date }">
            <template v-if="emotions[date] != null && emotions[date].user != null">
              <p class="text-xs-center mb-0 mt-2">
                <template v-if="me">
                  <span @click="openModal(emotions[date].user, date)">
                    <emotion-popper :emotion="emotions[date].user" :size="48"></emotion-popper>
                  </span>
                </template>
                <template v-else>
                  <emotion-popper :emotion="emotions[date].user" :size="48"></emotion-popper>
                </template>
              </p>
            </template>
          </template>
        </v-calendar>
      </v-sheet>

      <template v-if="me">
        <div class="text-xs-center">
          <v-dialog v-model="emotionModal" width="500">
            <emotion-modal
              :team-id="teamId"
              :emotion="modalEmotion"
              :date="modalDate"
              @closeModal="closeModal()"
            ></emotion-modal>
          </v-dialog>
        </div>
      </template>


    </v-flex>
  </v-layout>
</template>


<script>
  export default {
    props: ['emotions', 'month', 'me', 'teamId'],
    data: () => ({
      today: null,
      currentMonth: null,
      pickerModal: false,
      emotionModal: false,
      modalDate: null,
      modalEmotion: {
        emoji: ":bust_in_silhouette:",
        status_text: '',
        memo: ''
      },
      defaultEmotion: {
        emoji: ":bust_in_silhouette:",
        status_text: '',
        memo: ''
      },
    }),
    created() {
      console.log(this.me);
      this.today = dayjs(this.month.date).format('YYYY-MM-DD');
      this.currentMonth = dayjs(this.today).format('YYYY-MM');
    },
    filters: {
      month: function (date) {
        return dayjs(date).format('YYYY年M月');
      },
    },
    methods: {
      openModal: function (emotion, day) {
        this.modalDate = day;
        this.modalEmotion = (emotion == null) ? Object.assign({}, this.defaultEmotion) : Object.assign({}, emotion);
        this.emotionModal = true;
      },
      closeModal: function () {
        this.emotionModal = false;
      },
    },
  }
</script>

<style scoped>
  .v-calendar {
    border: 1px solid #ddd !important;
  }
</style>