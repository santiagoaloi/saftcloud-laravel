<template>
  <v-idle style="display: none" :loop="false" :duration="9999" @idle="onidle" />
</template>

<script>
  import Vue from 'vue';
  import { sync } from 'vuex-pathify';
  import router from '@/router';
  import { store } from '@/store';

  export default {
    name: 'SessionTimeout',

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('authentication', ['hasSessionExpired']),
    },

    methods: {
      onidle() {
        router.push('/login');
        this.hasSessionExpired = true;
        store.set('authentication/session', {});
      },
    },
  };
</script>
