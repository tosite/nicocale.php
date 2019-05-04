<template>
  <v-fade-transition mode="out-in">
    <loading v-if="loading"></loading>
    <div v-else>
      <h1>
        <v-btn flat icon color="secondary"
               :href="`/sub-teams/${subTeamId}/calendars/${months.prev.year}/${months.prev.month}`">
          <v-icon>keyboard_arrow_left</v-icon>
        </v-btn>
        {{ months.current.display }}
        <v-btn flat icon color="secondary"
               :href="`/sub-teams/${subTeamId}/calendars/${months.next.year}/${months.next.month}`">
          <v-icon>keyboard_arrow_right</v-icon>
        </v-btn>
        <sub-team-info-modal :sub-team-id="subTeamId"></sub-team-info-modal>
      </h1>
      <table class="table">
        <thead>
        <tr>
          <th>name</th>
          <template v-for="date in calendar">
            <th>{{ date.date | day }}</th>
          </template>
        </tr>
        </thead>
        <tbody>
        <tr>
          <th>
            <a :href="`/team-users/${me.user.team_user_id}/calendars/${months.current.year}/${months.current.month}`">
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
              <a
                :href="`/team-users/${user.user.team_user_id}/calendars/${months.current.year}/${months.current.month}`">
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
    props: ['subTeamId', 'year', 'month'],
    data() {
      return {
        months: null,
        calendar: null,
        me: null,
        members: null,
        loading: true,
        dialog: false,
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
        axios.get(`/api/v1/sub-teams/${this.subTeamId}/calendars/${this.year}/${this.month}`).then(res => {
          this.calendar = res.data.calendar;
          this.me = res.data.me;
          this.members = res.data.members;
          this.months = res.data.months;
        }).catch(e => {
          // TODO: @tosite error handling
        }).finally(() => {
          this.loading = false;
        });
      },
      updateEmotion: function (emotionId, params) {
        axios.put(`/api/v1/emotions/${emotionId}`, params).then(res => {
          this.snackbar = { open: true, type: 'success', text: '更新しました。' }
        }).catch(e => {
          this.snackbar = { open: true, type: 'error', text: '更新に失敗しました。' }
        }).finally(() => {
          this.dialog = false;
          this.fetchEmotion();
        });
      },
      createEmotion: function (params) {
        axios.post('/api/v1/emotions', params).then(res => {
          this.snackbar = { open: true, type: 'success', text: '作成しました。' }
        }).catch(e => {
          this.snackbar = { open: true, type: 'error', text: '作成に失敗しました。' }
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