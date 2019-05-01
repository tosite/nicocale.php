<template>
  <v-layout>
    <v-flex xs12 sm6 offset-sm3>
      <v-card class="text-xs-center pt-3">
        <v-avatar size="128">
          <img :src="teamUser.user.avatar" alt="avatar">
        </v-avatar>

        <v-card-title primary-title class="text-xs-center pb-1">
          <div>
            <h3 class="headline mb-0 text-xs-center">{{ teamUser.user.name }}</h3>
          </div>
        </v-card-title>
        <v-card-text>
          <div>
            <div v-if="teamUser.slack_access === 0">
              <p>
                お使いのアカウントはまだSlackと連携されていないようです。<br>
                連携することでステータスアイコンの変更・ステータスメッセージの変更・チャンネル通知などがご利用いただけます。<br>
                <a href="/auth/slack/access">連携を有効にする（連携グループ：{{ teamUser.team.name }}）</a>
              </p>
            </div>
            <div v-else>
              <p>
                お使いのアカウントはSlackと連携されています。<br>
                <a href="">連携を解除しますか？</a>
              </p>
              <p>-- ここに通知先チャンネルを出す --</p>
            </div>
          </div>
          <v-divider></v-divider>
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

            <v-btn color="primary" @click="save">更新する</v-btn>
          </div>
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
  export default {
    props: ['teamUser',],
    data() {
      return {
        radio: 'apple',
        emojiSet: ['apple', 'google', 'twitter', 'emojione', 'messenger', 'facebook'],
      }
    },
    created: function () {
      this.radio = this.teamUser.user.emoji_set;
    },
    methods: {
      save: function () {
        let params = { bio: this.teamUser.user.bio, emoji_set: this.radio };
        axios.put(`/api/v1/users/${this.teamUser.user.id}`, params)
          .then(res => {
            console.log(res);
          })
          .catch(e => {
            // TODO: @tosite error handling
            console.log(e.response.data);
          })
      }
    },
  }
</script>
