<template>
  <base-dialog
    v-model="dialogTImeoutWarning"
    title="Your session has expired"
    no-maximize
    dense
    width="600"
    no-actions
  >
    <v-card
      class="mx-auto"
      width="300"
    >
      hello
    </v-card>
  </base-dialog>
</template>
<script>
import { sync, get } from 'vuex-pathify';
import { store } from '@/store';

export default {
  name: 'DialogSessionTimeoutWarning',

  computed: {
    ...sync('theme', ['isDark']),
    ...sync('authentication', ['dialogTImeoutWarning']),
  },
};
</script>
