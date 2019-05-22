<template>
  <v-fade-transition mode="out-in">
    <loading v-if="loading"></loading>
    <div v-else>
      <v-layout row>
        <v-dialog v-model="pickerModal" max-width="290px">
          <template v-slot:activator="{ on }">
            <h1>{{ subTeam.name }} - <small>{{ currentMonth | month }}</small></h1>
            <v-btn color="primary" dark v-on="on" icon flat>
              <v-icon>calendar_today</v-icon>
            </v-btn>
          </template>
          <v-date-picker v-model="currentMonth" type="month" color="primary" locale="jp-ja"></v-date-picker>
        </v-dialog>
        <sub-team-info-modal :sub-team-id="subTeam.id"></sub-team-info-modal>
      </v-layout>
      <table class="table">
        <thead>
        <tr>
          <th>ユーザー</th>
          <template v-for="date in calendar">
            <th>{{ date.date | day }}</th>
          </template>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th>
            <a :href="`/team-users/${me.user.team_user_id}/calendars/${yearAndMonth}`">
              {{ me.user.user.name }}
            </a>
          </th>
          <td v-for="(emotion, day) in me.emotions" :key="day">
            <span @click="openModal(emotion, day)" class="pointer">
              <emotion-popper :emotion="emotion" :size="48"></emotion-popper>
            </span>
          </td>
        </tr>
        <template v-for="user in members">
          <tr>
            <th>
              <a :href="`/team-users/${user.user.team_user_id}/calendars/${yearAndMonth}`">
                {{ user.user.user.name }}
              </a>
            </th>
            <template v-for="emotion in user.emotions">
              <td>
                <emotion-popper :emotion="emotion"></emotion-popper>
              </td>
            </template>
          </tr>
        </template>
        </tbody>
      </table>

      <template>
        <div class="text-xs-center">
          <v-dialog v-model="dialog" width="500">
            <emotion-modal
              :team-user="me.user"
              :emotion="modalEmotion"
              :date="modalDate"
              @createEmotion="createEmotion"
              @updateEmotion="updateEmotion"
              @closeModal="closeModal"
            ></emotion-modal>
          </v-dialog>
        </div>
      </template>

      <snackbar :snackbar="snackbar" @closeSnackbar="closeSnackbar"></snackbar>

    </div>
  </v-fade-transition>
</template>

<style scoped>
  .pointer {
    cursor: pointer;
  }
</style>

<script>
  export default {
    props: ['subTeam', 'month'],
    data() {
      return {
        calendar: null,
        me: null,
        members: null,
        loading: true,
        dialog: false,
        pickerModal: false,
        currentMonth: null,
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
      }
    },
    filters: {
      day: function (date) {
        return dayjs(date).format('D');
      },
      month: function (date) {
        return dayjs(date).format('YYYY年M月');
      },
    },
    computed: {
      yearAndMonth: function () {
        let d = dayjs(this.currentMonth);
        return `${d.format('YYYY')}/${d.format('M')}`;
      },
    },
    watch: {
      currentMonth: function () {
        if (dayjs(this.month).format('YYYY-MM') == dayjs(this.currentMonth).format('YYYY-MM')) {
          return;
        }
        window.location.href = `/sub-teams/${this.subTeam.id}/calendars/${this.yearAndMonth}`;
      },
    },
    methods: {
      emoji: function (emotion) {
        return (emotion == null) ? this.defaultEmotion.emoji : emotion.emoji;
      },
      openModal: function (emotion, day) {
        this.modalDate = day;
        this.modalEmotion = (emotion == null) ? Object.assign({}, this.defaultEmotion) : Object.assign({}, emotion);
        this.dialog = true;
      },
      closeModal: function () {
        this.fetchEmotion();
        this.dialog = false;
      },
      closeSnackbar: function () {
        this.snackbar.open = false;
      },
      fetchEmotion: function () {
        let d = dayjs(this.month).format('YYYY/MM');
        console.log(`/api/v1/sub-teams/${this.subTeam.id}/calendars/${d}`);
        axios.get(`/api/v1/sub-teams/${this.subTeam.id}/calendars/${d}`).then(res => {
          this.calendar = res.data.calendar;
          this.me = res.data.me;
          this.members = res.data.members;
          this.currentMonth = dayjs(res.data.current.date).format('YYYY-MM');
        }).catch(e => {
          alert('処理に失敗しました。');
        }).finally(() => {
          this.loading = false;
        });
      },
      updateEmotion: function (emotionId, params) {
        axios.put(`/api/v1/emotions/${emotionId}`, params).then(res => {
          this.snackbar = {open: true, type: 'success', text: '更新しました。'}
        }).catch(e => {
          alert('処理に失敗しました。');
        }).finally(() => {
          this.dialog = false;
          this.fetchEmotion();
        });
      },
      createEmotion: function (params) {
        axios.post('/api/v1/emotions', params).then(res => {
          this.snackbar = {open: true, type: 'success', text: '作成しました。'}
        }).catch(e => {
          alert('処理に失敗しました。');
        }).finally(() => {
          this.dialog = false;
          this.fetchEmotion();
        });
      },
    },
    mounted() {
      this.fetchEmotion();
    }
  }
</script>