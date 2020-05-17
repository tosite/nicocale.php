<template>
  <div>
    <v-layout>
      <v-flex xs12 sm8 offset-sm2>
        <v-card class="text-xs-center pt-3">

          <v-card-title primary-title class="text-xs-center pb-1 pt-1 headline">
            <v-avatar size="128">
              <img :src="teamUser.user.avatar" alt="avatar">
            </v-avatar>
            {{ teamUser.user.name }}
          </v-card-title>

          <v-card-text>
            <p class="headline">Slack連携</p>
            <div>
              <div v-if="!settings.slack_access || settings.slack_access == 0">
                <p>
                  お使いのアカウントはまだSlackと連携されていないようです。<br>
                  連携することでステータスアイコンの変更・ステータスメッセージの変更・チャンネル通知などがご利用いただけます。<br>
                  <a href="/auth/slack/access">連携を有効にする（連携グループ：{{ teamUser.team.name }}）</a>
                </p>
              </div>
              <div v-else>
                <p>お使いのアカウントはSlackと連携されています。</p>
                <v-layout wrap align-center>
                  <v-flex xs12>
                    <v-switch
                      v-model="status"
                      color="primary"
                      label="Slackのステータスを更新する"
                      v-on:change="setStatus"
                      :disabled="btnLoading"
                    ></v-switch>
                  </v-flex>
                  <v-flex xs6 sm8>
                    <v-select
                      v-model="selectChannel"
                      :items="this.channels"
                      item-text="name"
                      item-value="id"
                      label="通知先チャンネル"
                    ></v-select>
                  </v-flex>
                  <v-flex xs6 sm4>
                    <v-btn color="error" flat small @click="unsetChannel" :loading="btnLoading">解除</v-btn>
                    <v-btn color="primary" flat small @click="setChannel" :loading="btnLoading">通知</v-btn>
                  </v-flex>
                </v-layout>

                <v-layout>
                  <v-flex xs3>
                    <v-select
                      v-model="remindHour"
                      :items="['8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21']"
                      item-text="name"
                      item-value="id"
                      label="時"
                    ></v-select>
                  </v-flex>
                  <v-flex xs3>
                    <v-select
                      v-model="remindMin"
                      :items="['00', '15', '30', '45']"
                      item-text="name"
                      item-value="id"
                      label="分"
                    ></v-select>
                  </v-flex>
                  <v-flex sm2></v-flex>
                  <v-flex xs6 sm4>
                    <v-btn color="error" flat small @click="unsetRemind" :loading="btnLoading">解除</v-btn>
                    <v-btn color="primary" flat small @click="setRemind" :loading="btnLoading">設定</v-btn>
                  </v-flex>
                </v-layout>
                <v-layout>
                  <v-flex xs12>
                    <v-switch
                      v-model="skipHoliday"
                      color="primary"
                      label="休日はスキップする"
                      v-on:change="setSkipHoliday"
                      :disabled="btnLoading"
                    ></v-switch>
                  </v-flex>
                </v-layout>
              </div>
            </div>
            <v-divider class="mb-3 mt-2"></v-divider>
            <div class="text-xs-right mb-2">
              <v-textarea
                outline
                name="input-7-4"
                label="自己紹介"
                hint=""
                v-model="teamUser.user.bio"
              ></v-textarea>

              <!--              <v-expansion-panel class="elevation-0">-->
              <!--                <v-expansion-panel-content key="1">-->
              <!--                  <template v-slot:header>-->
              <!--                    <div>Emojiスキンを選択する</div>-->
              <!--                  </template>-->

              <!--                  <v-card>-->
              <!--                    <v-radio-group v-model="radio">-->
              <!--                      <v-radio-->
              <!--                        v-for="set in emojiSet"-->
              <!--                        :key="set"-->
              <!--                        :value="set"-->
              <!--                        color="primary"-->
              <!--                      >-->
              <!--                        <template v-slot:label>-->
              <!--                          <emoji emoji="grin" :set="set" :size="32"></emoji>-->
              <!--                          <emoji emoji="slightly_smiling_face" :set="set" :size="32"></emoji>-->
              <!--                          <emoji emoji="disappointed_relieved" :set="set" :size="32"></emoji>-->
              <!--                        </template>-->
              <!--                      </v-radio>-->
              <!--                    </v-radio-group>-->
              <!--                  </v-card>-->
              <!--                </v-expansion-panel-content>-->
              <!--              </v-expansion-panel>-->

              <v-btn color="primary" @click="updateUser" :loading="btnLoading">更新する</v-btn>
            </div>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>

    <snackbar :snackbar="snackbar" @closeSnackbar="closeSnackbar"></snackbar>

  </div>
</template>

<script>
  export default {
    props: ['teamUser', 'channels', 'settings'],
    data() {
      return {
        radio: 'apple',
        emojiSet: ['apple', 'google', 'twitter', 'emojione', 'messenger', 'facebook'],
        status: false,
        selectChannel: '',
        remindHour: '17',
        remindMin: '00',
        skipHoliday: true,
        btnLoading: false,
        snackbar: {
          open: false,
          type: '',
          text: '',
        },
      }
    },
    created: function () {
      this.radio = this.teamUser.user.emoji_set;
      this.selectChannel = this.settings.notify_channel;
      this.status = (!this.settings.set_status) ? false : true;
      if (this.settings.remind_at) {
        const hms = this.settings.remind_at.split(':');
        this.remindHour = hms[0];
        this.remindMin = hms[1];
      }
      this.skipHoliday = this.settings.skip_holiday;
    },
    methods: {
      closeSnackbar: function () {
        this.snackbar.open = false;
      },
      updateUser: function () {
        this.btnLoading = true;
        let params = {bio: this.teamUser.user.bio, emoji_set: this.radio};
        axios.put(`/api/v1/users/${this.teamUser.user.id}`, params).then(res => {
          this.snackbar = {open: true, type: 'success', text: '更新しました。'};
        }).catch(e => {
          alert('通知に失敗しました。');
        }).finally(() => {
          this.btnLoading = false;
        });
      },
      setChannel: function () {
        this.btnLoading = true;
        let params = {notify_channel: this.selectChannel,};
        axios.put(`/api/v1/team-users/${this.teamUser.id}/channels`, params).then(res => {
          this.snackbar = {
            open: true,
            type: 'success',
            text: (this.selectChannel == '') ? 'チャンネル通知を解除しました。' : 'チャンネルに通知しました。'
          };
        }).catch(e => {
          alert('更新に失敗しました。');
        }).finally(() => {
          this.btnLoading = false;
        });
      },
      unsetChannel: function () {
        this.selectChannel = '';
        this.setChannel();
      },
      setRemind: function () {
        this.btnLoading = true;
        const remind_at = (!this.remindHour && !this.remindMin) ? '' : `${this.remindHour}:${this.remindMin}:00`;
        axios.put(`/api/v1/team-users/${this.teamUser.id}/reminders`, {remind_at: remind_at}).then(res => {
          this.snackbar = {open: true, type: 'success', text: `リマインダー${(!remind_at) ? 'の設定を解除しました' : 'を設定しました'}。`};
        }).catch(e => {
          alert('更新に失敗しました。');
        }).finally(() => {
          this.btnLoading = false;
        });
      },
      unsetRemind: function () {
        this.remindHour = '';
        this.remindMin = '';
        this.setRemind();
      },
      setStatus: function () {
        this.btnLoading = true;
        axios.put(`/api/v1/team-users/${this.teamUser.id}/set-status`, {set_status: this.status}).then(res => {
          this.snackbar = {open: true, type: 'success', text: `Slackのステータスを更新${(this.status) ? 'します' : 'しません'}。`};
        }).catch(e => {
          alert('更新に失敗しました。');
        }).finally(() => {
          this.btnLoading = false;
        });
      },
      setSkipHoliday: function () {
        this.btnLoading = true;
        axios.put(`/api/v1/team-users/${this.teamUser.id}/skip-holiday`, {skip_holiday: this.skipHoliday}).then(res => {
          this.snackbar = {open: true, type: 'success', text: `休日をスキップ${(this.skipHoliday) ? 'します' : 'しません'}。`};
        }).catch(e => {
          alert('更新に失敗しました。');
        }).finally(() => {
          this.btnLoading = false;
        });
      },
    },
  }
</script>
