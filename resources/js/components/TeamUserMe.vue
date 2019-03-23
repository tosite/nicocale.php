<template>
  <v-layout>
    <v-flex xs12 sm8 offset-sm2>
      <v-card class="text-xs-center pt-3">
        <v-avatar size="128">
          <img :src="teamUser.user.avatar" alt="avatar">
        </v-avatar>

        <v-card-title primary-title class="text-xs-center pb-1">
          <div>
            <h3 class="headline mb-0">{{ teamUser.user.name }}</h3>
          </div>
        </v-card-title>
        <v-card-text>
          <div>
            <div v-if="teamUser.slack_access === 0">
              <p>
                お使いのアカウントはまだSlackと連携されていないようです。<br>
                連携することでステータスアイコンの変更・ステータスメッセージの変更・チャンネル通知などがご利用いただけます。<br>
                <a href="/auth/slack/access">連携を有効にしますか？（連携グループ：{{ teamUser.team.name }}）</a>
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
              :value="teamUser.user.bio"
            ></v-textarea>
            <v-btn>更新する</v-btn>
          </div>
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
  export default {
    props: ['teamUser',],
  }
</script>
