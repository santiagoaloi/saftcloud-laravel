<template>
  <v-container class="white--text">
    <div class="d-flex align-center justify-center">
      <div class="text-center">
        <h1 style="font-size: 800%">404</h1>
        <h1>
          <span class="indigo--text text--lighten-2"> {{ $route.params.catchAll }} </span> isn't a valid route
        </h1>
        <h1>It appears you got a bit lost.</h1>
        <h3 class="mt-2">If you think this is an error, contact support</h3>
        <v-btn rounded color="primary" class="mt-5" x-large @click="backToPreviousPage()"> Back to previous page</v-btn>
      </div>
    </div>
  </v-container>
</template>
<script>
  export default {
    name: 'NotFound',

    data() {
      return {};
    },

    methods: {
      backToPreviousPage() {
        window.history.back();
      },
    },
  };
</script>
