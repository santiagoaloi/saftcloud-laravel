<template>
  <v-card color="red" height="100vh">
    <p>Could not display books. Kindly check your internet conection.</p>
  </v-card>
</template>

<script>
  // Utilities
  import { sync } from 'vuex-pathify';

  export default {
    name: 'DefaultSnackbar',
    computed: {
      snackbar: sync('snackbar'),
    },
  };
</script>
