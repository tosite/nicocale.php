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
          <v-dialog
            v-model="dialog"
            width="500"
          >
            <v-card>
              <v-card-title class="headline primary white--text" primary-title color="primary">
                {{ modalDate }}
              </v-card-title>

              <v-card-text>
                <p class="display-4 text-xs-center ma-0">
                  <emoji :emoji="modalEmotion.emoji" :size="64"></emoji>
                </p>

                <div class="text-xs-center">
                  <template v-for="emoji in oftenUseEmoji">

                    <v-btn flat @click="selectEmoji(emoji)" style="height: 54px; min-width: 0;">
                      <emoji :emoji="emoji" :size="32"></emoji>
                    </v-btn>
                  </template>
                  <v-btn flat icon @click="picker = !picker">
                    <v-icon>more_vert</v-icon>
                  </v-btn>

                  <v-fade-transition>
                    <emoji-picker
                      v-show="picker"
                      :i18n="pickerI18n"
                      :showSkinTones="false"
                      title="NicoCale"
                      @select="selectEmoji"
                    ></emoji-picker>
                  </v-fade-transition>

                  <v-text-field
                    v-model="modalEmotion.status_text"
                    :counter="100"
                    label="ひとこと"
                  ></v-text-field>

                  <v-expansion-panel class="elevation-0">
                    <v-expansion-panel-content>
                      <div slot="header">メモを追加する</div>
                      <v-card>
                        <v-card-text class="text-xs-center pa-0">
                          <v-textarea
                            v-model="modalEmotion.memo"
                            :counter="100"
                            label="メモ"
                          ></v-textarea>
                        </v-card-text>
                      </v-card>
                    </v-expansion-panel-content>
                  </v-expansion-panel>

                </div>

              </v-card-text>

              <v-divider></v-divider>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="disabled" flat @click="dialog = false">Cancel</v-btn>
                <v-btn color="primary" @click="save">Submit</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </div>
      </template>

    </div>
  </v-fade-transition>
</template>

<style scoped>
  .emoji-mart {
    width: 100% !important;
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
        pickerI18n: {
          search: '検索',
          notfound: '絵文字が見つかりませんでした',
          categories: {
            search: '検索結果',
            recent: 'よく使う絵文字',
            people: '人',
            nature: '自然',
            foods: 'フード＆ドリンク',
            activity: 'アクティビティ',
            places: 'トラベル＆場所',
            objects: 'オブジェクト',
            symbols: '記号',
            flags: '旗',
            custom: 'カスタム',
          }
        },
        oftenUseEmoji: [
          {
            colons: ":grin:",
            emoticons: [],
            id: "grin",
            name: "Grinning Face with Smiling Eyes",
            native: "😁",
            skin: null,
            unified: "1f601",
          },
          {
            colons: ":slightly_smiling_face:",
            emoticons: [
              ":)",
              "(:",
              ":-)",
            ],
            id: "slightly_smiling_face",
            name: "Slightly Smiling Face",
            native: "🙂",
            skin: null,
            unified: "1f642",
          },
          {
            colons: ":disappointed_relieved:",
            emoticons: [],
            id: "disappointed_relieved",
            name: "Disappointed but Relieved Face",
            native: "😥",
            skin: null,
            unified: "1f625",
          },
        ],
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
      selectEmoji: function (emoji) {
        this.modalEmotion.emoji = emoji.colons;
      },
    },
    mounted() {
      this.fetchParams();
    }
  }
</script>