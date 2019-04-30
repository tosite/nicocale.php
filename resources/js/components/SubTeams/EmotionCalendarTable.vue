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
            <th>{{ formatDate(date.date) }}</th>
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
          <template v-for="(emotion, day) in me.emotions">
            <td>
              <span @click="openModal(emotion, day)">
                <emoji :emoji="emoji(emotion)" :size="48"></emoji>
              </span>
            </td>
          </template>
        </tr>
        <template v-for="user in members">
          <tr>
            <th>
              <a :href="`/team-users/${user.user.team_user_id}/calendars/${months.current.year}/${months.current.month}`">
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
              :sub-team-id="subTeamId"
              :emotion="modalEmotion"
              :date="modalDate"
            ></emotion-modal>
          </v-dialog>
        </div>
      </template>

    </div>
  </v-fade-transition>
</template>

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
        picker: false,
        beforeEmotion: null,
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
      }
    },
    methods: {
      formatDate: function (date) {
        let d = new Date(Date.parse(date));
        return d.getDate();
      },
      emoji: function (emotion) {
        return (emotion == null) ? this.defaultEmotion.emoji : emotion.emoji;
      },
      fetchParams: function () {
        axios.get(`/api/v1/sub-teams/${this.subTeamId}/calendars/${this.year}/${this.month}`).then(res => {
          this.calendar = res.data.calendar;
          this.me = res.data.me;
          this.members = res.data.members;
          this.months = res.data.months;
          this.loading = false;
        }).catch(e => {
        });
      },
      save: function () {
        this.dialog = false;
      },
      openModal: function (emotion, day) {
        this.modalDate = day;
        this.modalEmotion = (emotion == null) ? Object.assign({}, this.defaultEmotion) : Object.assign({}, emotion);
        this.dialog = true;
      },
    },
    mounted() {
      this.fetchParams();
    }
  }
</script>