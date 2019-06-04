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
                    <v-select
                      v-model="selectChannel"
                      :items="this.channels"
                      item-text="name"
                      item-value="id"
                      label="通知先チャンネル"
                    ></v-select>
                  </v-flex>
                </v-layout>
                <v-layout>
                  <v-spacer></v-spacer>
                  <v-btn color="error" flat @click="unsetChannel">解除する</v-btn>
                  <v-btn color="primary" flat @click="setChannel">通知する</v-btn>
                </v-layout>

                <!--                <v-layout>-->
                <!--                  <v-flex xs3>-->
                <!--                    <v-select-->
                <!--                      v-model="remindHour"-->
                <!--                      :items="[8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21]"-->
                <!--                      item-text="name"-->
                <!--                      item-value="id"-->
                <!--                      label="時"-->
                <!--                    ></v-select>-->
                <!--                  </v-flex>-->
                <!--                  <v-flex xs3>-->
                <!--                    <v-select-->
                <!--                      v-model="remindMin"-->
                <!--                      :items="['00', 10, 20, 30, 40, 50]"-->
                <!--                      item-text="name"-->
                <!--                      item-value="id"-->
                <!--                      label="分"-->
                <!--                    ></v-select>-->
                <!--                  </v-flex>-->
                <!--                  <v-flex xs6>-->
                <!--                    <v-btn color="error" flat @click="unsetChannel">解除する</v-btn>-->
                <!--                    <v-btn color="primary" flat @click="setRemind">設定する</v-btn>-->
                <!--                  </v-flex>-->
                <!--                </v-layout>-->
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

              <v-expansion-panel class="elevation-0">
                <v-expansion-panel-content key="1">
                  <template v-slot:header>
                    <div>Emojiスキンを選択する</div>
                  </template>

                  <v-card>
                    <v-radio-group v-model="radio">
                      <v-radio
                        v-for="set in emojiSet"
                        :key="set"
                        :value="set"
                        color="primary"
                      >
                        <template v-slot:label>
                          <emoji emoji="grin" :set="set" :size="32"></emoji>
                          <emoji emoji="slightly_smiling_face" :set="set" :size="32"></emoji>
                          <emoji emoji="disappointed_relieved" :set="set" :size="32"></emoji>
                        </template>
                      </v-radio>
                    </v-radio-group>
                  </v-card>
                </v-expansion-panel-content>
              </v-expansion-panel>

              <v-btn color="primary" @click="updateUser">更新する</v-btn>
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
        selectChannel: '',
        remindHour: 8,
        remindMin: '00',
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
    },
    methods: {
      closeSnackbar: function () {
        this.snackbar.open = false;
      },
      updateUser: function () {
        let params = {bio: this.teamUser.user.bio, emoji_set: this.radio};
        axios.put(`/api/v1/users/${this.teamUser.user.id}`, params).then(res => {
          this.snackbar = {open: true, type: 'success', text: '更新しました。'};
        }).catch(e => {
          alert('通知に失敗しました。');
        });
      },
      setChannel: function () {
        let params = {notify_channel: this.selectChannel,};
        axios.put(`/api/v1/team-users/${this.teamUser.id}/channels`, params).then(res => {
          this.snackbar = {open: true, type: 'success', text: 'チャンネルに通知しました。'};
        }).catch(e => {
          alert('更新に失敗しました。');
        });
      },
      unsetChannel: function () {
        this.selectChannel = '';
        this.setChannel();
      },
      setRemind: function () {
        if (this.remindHour === '' || this.remindMin === '') {
          return;
        }
        let params = {remind_at: `${this.remindHour}:${this.remindMin}:00`};
        axios.put(`/api/v1/team-users/${this.teamUser.id}/reminders`, params).then(res => {
          this.snackbar = {open: true, type: 'success', text: 'リマインダーを設定しました。'};
        }).catch(e => {
          alert('更新に失敗しました。');
        });
      },
      unsetRemind: function () {
        this.remindHour = '';
        this.remindMin = '';
        this.setRemind();
      }
    },
  }
</script>
