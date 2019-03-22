<template>
  <div class="text-xs-center">
    <v-tooltip top v-if="e.status_text.length!==0">
      <span slot="activator" dark color="primary">
        <span class="display-2">{{ e.emoji }}</span>
      </span>
      <span>{{ e.status_text }}</span>
    </v-tooltip>
    <span v-else>
        <span class="display-2">{{ e.emoji }}</span>
    </span>
  </div>
</template>

<script>
  import EmojiSelector from "./EmojiSelector";

  export default {
    components: {EmojiSelector},
    props: ['emotion',],
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
        console.log(this.emotion);
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
