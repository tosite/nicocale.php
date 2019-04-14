<template>
  <div>
    <v-progress-linear :indeterminate="true" v-if="loading"></v-progress-linear>
    <div v-else>
      <h1>
        calendar
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
        <tbody v-if="me === null">

        </tbody>
        <tbody v-else>
        <tr>
          <th>{{ me.user.name }}</th>
          <template v-for="emotion in me.emotions">
            <td>
              <emotion-modal
                :date="emotion.entered_on"
                :emotion="emotion"
              ></emotion-modal>
            </td>
          </template>
        </tr>
        <template v-for="user in members">
          <tr>
            <th>{{ user.user.user.name }}</th>
            <template v-for="emotion in user.emotions">
              <td>
                <emotion-popper :emotion="emotion"></emotion-popper>
              </td>
            </template>
          </tr>
        </template>
        </tbody>
      </table>

    </div>
  </div>
</template>

<script>
  export default {
    props: ['subTeamId'],
    data() {
      return {
        calendar: null,
        month: null,
        calendar: null,
        me: null,
        members: null,
        loading: true,
      }
    },
    methods: {
      formatDate: function (date) {
        let d = new Date(Date.parse(date));
        return d.getDate();
      },
      fetchParams: function () {
        axios.get(`/api/v1/sub-teams/${this.subTeamId}/calendars/2019/3`).then(res => {
          console.log(res.data);
          this.calendar = res.data.calendar;
          this.me = res.data.me;
          this.members = res.data.teamUsers;
          this.loading = false;
        }).catch(e => {
        });
      }
    },
    mounted() {
      this.fetchParams();
    }
  }
</script>