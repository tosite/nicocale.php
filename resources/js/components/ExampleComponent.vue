<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header">Example Component</div>

          <div class="card-body">
            <v-btn @click="test()">I'm an Vuetify component.</v-btn>
            <p>I'm an example component.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    mounted() {
      console.log('Component mounted.')
    },
    methods: {
      test () {
        alert('hoge');
      },
    },
  }
</script>
