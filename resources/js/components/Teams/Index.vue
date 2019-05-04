<template>
  <v-layout row v-if="emotion != null">
    <v-flex xs12 sm10 offset-sm1 md8 offset-md2 lg6 offset-lg3>
      <emotion-modal
        :team-user="teamUser"
        :emotion="emotion"
        :date="date"
        :closeButton="false"
        @createEmotion="createEmotion"
        @updateEmotion="updateEmotion"
      ></emotion-modal>

      <snackbar :snackbar="snackbar" @closeSnackbar="closeSnackbar"></snackbar>

    </v-flex>
  </v-layout>
</template>

<script>
  export default {
    props: ['teamUser', 'date'],
    data() {
      return {
        snackbar: {
          open: false,
          type: '',
          text: '',
        },
        emotion: null,
      }
    },
    created() {
      this.fetchEmotion();
    },
    methods: {
      closeSnackbar: function () {
        this.snackbar.open = false;
      },
      fetchEmotion: function () {
        axios.get(`/api/v1/team-users/${this.teamUser.id}/emotions`).then(res => {
          this.emotion = res.data;
        }).catch(e => {
          this.snackbar = {open: true, type: 'error', text: 'エラーが発生しました。'}
        });
      },
      updateEmotion: function (emotionId, params) {
        axios.put(`/api/v1/emotions/${emotionId}`, params).then(res => {
          this.snackbar = {open: true, type: 'success', text: '更新しました。'}
        }).catch(e => {
          this.snackbar = {open: true, type: 'error', text: '更新に失敗しました。'}
        }).finally(() => {
          this.emotionModal = false;
          this.fetchEmotion();
        });
      },
      createEmotion: function (params) {
        axios.post('/api/v1/emotions', params).then(res => {
          this.snackbar = {open: true, type: 'success', text: '作成しました。'}
        }).catch(e => {
          this.snackbar = {open: true, type: 'error', text: '作成に失敗しました。'}
        }).finally(() => {
          this.emotionModal = false;
          this.fetchEmotion();
        });
      },
    },
  }
</script>