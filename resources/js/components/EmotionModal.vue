<template>
  <div class="text-xs-center">
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <v-btn
        slot="activator"
        color="red lighten-2"
        dark
      >
        {{ e.entered_on }}
      </v-btn>

      <v-card>
        <v-card-title
          class="headline grey lighten-2"
          primary-title
        >
        </v-card-title>

        <v-card-text>

          <v-text-field
            v-model="e.emoji"
            :counter="100"
            label="Status"
          ></v-text-field>

          <v-text-field
            v-model="e.status_text"
            :counter="100"
            label="Status"
          ></v-text-field>

        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            flat
            @click="dialog = false"
          >
            I accept
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>


<script>
  export default {
    props: ['emotion'],
    data() {
      return {
        dialog: false,
        e: null,
      }
    },
    created () {
      if (this.emotion) {
        this.e = JSON.parse(this.emotion);
        console.log(this.e);
      }
    },
  }
</script>
