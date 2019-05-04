<template>
  <v-layout wrap>
    <v-flex xs12 v-if="localToday != null">
      <v-layout row>
        <v-dialog v-model="pickerModal" max-width="290px">
          <template v-slot:activator="{ on }">
            <h1>{{ currentMonth | month }}</h1>
            <v-btn color="primary" dark v-on="on" icon flat>
              <v-icon>calendar_today</v-icon>
            </v-btn>
          </template>
          <v-date-picker v-model="currentMonth" type="month" color="primary" locale="jp-ja"></v-date-picker>
        </v-dialog>
      </v-layout>
      <v-sheet height="625">
        <v-calendar :now="localToday" :value="calendarFirstDay" color="primary" locale="jp-ja">
          <template v-slot:day="{ present, past, date }">
            <p class="text-xs-center mb-0 mt-2">
              <template v-if="isThisMonth(date)">
                <template v-if="me">
                  <span @click="openModal(emotions[date], date)">
                    <emotion-popper :emotion="emotions[date]" :size="48"></emotion-popper>
                  </span>
                </template>
                <template v-else>
                  <emotion-popper :emotion="emotions[date]" :size="48"></emotion-popper>
                </template>
              </template>
            </p>
          </template>
        </v-calendar>
      </v-sheet>

      <template v-if="me">
        <div class="text-xs-center">
          <v-dialog v-model="emotionModal" width="500">
            <emotion-modal
              :team-user="teamUser"
              :emotion="modalEmotion"
              :date="modalDate"
              @closeModal="closeModal"
              @createEmotion="createEmotion"
              @updateEmotion="updateEmotion"
            ></emotion-modal>
          </v-dialog>
        </div>
      </template>

      <snackbar :snackbar="snackbar" @closeSnackbar="closeSnackbar"></snackbar>

    </v-flex>
  </v-layout>
</template>


<script>
  export default {
    props: ['emotions', 'month', 'today', 'me', 'teamUser'],
    data: () => ({
      localToday: null,
      calendarFirstDay: null,
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
      snackbar: {
        open: false,
        type: '',
        text: '',
      },
    }),
    created() {
      this.localToday = dayjs(this.today.date).format('YYYY-MM-DD');
      this.currentMonth = dayjs(this.month.date).format('YYYY-MM');
      this.calendarFirstDay = dayjs(this.month.date).format('YYYY-MM-DD');
    },
    filters: {
      month: function (date) {
        return dayjs(date).format('YYYY年M月');
      },
    },
    watch: {
      currentMonth: function () {
        let d = dayjs(this.currentMonth);
        if (dayjs(this.month.date).format('YYYY-MM') == d.format('YYYY-MM')) {
          return;
        }
        this.reload();
      },
    },
    methods: {
      reload: function () {
        let d = dayjs(this.currentMonth);
        window.location.href = `/team-users/${this.teamUser.id}/calendars/${d.format('YYYY')}/${d.format('M')}`;
      },
      isThisMonth(date) {
        return dayjs(this.month.date).format('M') == dayjs(date).format('M');
      },
      openModal: function (emotion, day) {
        this.modalDate = day;
        this.modalEmotion = (emotion == null) ? Object.assign({}, this.defaultEmotion) : Object.assign({}, emotion);
        this.emotionModal = true;
      },
      closeModal: function () {
        this.emotionModal = false;
      },
      closeSnackbar: function () {
        this.snackbar.open = false;
      },
      updateEmotion: function (emotionId, params) {
        axios.put(`/api/v1/emotions/${emotionId}`, params).then(res => {
          this.snackbar = {open: true, type: 'success', text: '更新しました。'}
        }).catch(e => {
          this.snackbar = {open: true, type: 'error', text: '更新に失敗しました。'}
        }).finally(() => {
          this.emotionModal = false;
          this.reload();
        });
      },
      createEmotion: function (params) {
        axios.post('/api/v1/emotions', params).then(res => {
          this.snackbar = {open: true, type: 'success', text: '作成しました。'}
        }).catch(e => {
          this.snackbar = {open: true, type: 'error', text: '作成に失敗しました。'}
        }).finally(() => {
          this.emotionModal = false;
          this.reload();
        });
      },
    },
  }
</script>

<style scoped>
  .v-calendar {
    border: 1px solid #ddd !important;
  }
</style>