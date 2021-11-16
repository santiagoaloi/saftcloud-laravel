<template>
  <v-snackbar
    v-model="snackbar.data.value"
    :timeout="6000"
    :color="snackbar.data.color"
    transition="slide-y-reverse-transition"
    multi-line
    centered
  >
    <v-icon class="mr-4 mt-n1"> {{ snackbar.data.icon }}</v-icon>
    {{ snackbar.data.text }}
    <template #action="{ attrs }">
      <v-btn dark text fab x-small v-bind="attrs" @click="snackbar.data.value = false">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </template>
  </v-snackbar>
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
