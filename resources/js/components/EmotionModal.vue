<template>
  <div class="text-xs-center">
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <span slot="activator">
        <span class="display-2">{{ e.emoji }}</span>
      </span>

      <v-card>
        <v-card-title
          class="headline grey lighten-2"
          primary-title
        >
          {{ date }}
        </v-card-title>

        <v-card-text>

          <p class="display-4 text-xs-center ma-0">{{ e.emoji }}</p>

          <emoji-selector @selectEmoji="selectEmoji"></emoji-selector>

          <v-text-field
            v-model="e.status_text"
            :counter="100"
            label="Status"
          ></v-text-field>

          <v-expansion-panel class="elevation-0">
            <v-expansion-panel-content>
              <div slot="header">add memo</div>
              <v-card>
                <v-card-text class="text-xs-center pa-0">
                  <v-textarea
                    v-model="e.memo"
                    :counter="100"
                    label="Memo"
                  ></v-textarea>
                </v-card-text>
              </v-card>
            </v-expansion-panel-content>
          </v-expansion-panel>

        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            flat
            @click="cancel"
          >Cancel
          </v-btn>

          <v-btn
            color="primary"
            flat
            @click="post"
          >
            Submit
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  import EmojiSelector from "./EmojiSelector";

  export default {
    components: {EmojiSelector},
    props: ['emotion', 'date'],
    data() {
      return {
        dialog: false,
        e: null,
        defaultEmotion: {emoji: '👤', status_text: '', memo: ''},
      }
    },
    created() {
      this.e = (!this.emotion) ? this.defaultEmotion : this.emotion;
    },
    methods: {
      selectEmoji: function (emoji) {
        this.e.emoji = emoji;
      },
      cancel: function () {
        this.e = (!this.emotion) ? this.defaultEmotion : this.emotion;
        this.dialog = false;
      },
      post: function () {
        // const params = this.e;
        // params["entered_on"] = this.enteredOn;
        // params["team_user_id"] = this.teamUserId;
        // console.log(params);
        // axios.post('/api/v1/emotions', params)
        //   .then((r) => {
        //     console.log(r)
        //   })
        //   .catch((e) => {
        //     console.log(e.response)
        //   })
        // ;
        this.dialog = false;
      },
    },
  }
</script>
