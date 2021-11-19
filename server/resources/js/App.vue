<template>
  <v-app>
    <v-fade-transition mode="out-in" :duration="520" hide-on-leave>
      <component :is="layout" />
    </v-fade-transition>
  </v-app>
</template>

<script>
  import Vue from 'vue';
  import { call } from 'vuex-pathify';
  import config from './configs';
  import auth from '@/util/auth';

  Vue.component('SecureLayout', () => import(/* webpackChunkName: 'secure-Layout' */ '@/layouts/secureLayout'));
  Vue.component('PublicLayout', () => import(/* webpackChunkName: 'public-Layout' */ '@/layouts/publicLayout'));

  export default {
    name: 'App',

    head: {
      link: [...config.icons.map((href) => ({ rel: 'stylesheet', href }))],
    },

    computed: {
      ...call('authentication', ['buildRoutes']),

      layout() {
        return this.$route.meta.layout;
      },
    },

    created() {
      // ** Define event bus
      window.eventBus = this;

      // ** Build routes on request.
      window.eventBus.$on('BUS_BUILD_ROUTES', () => {
        this.buildRoutes();
      });

      // * Waits for auth to be ready.
      setTimeout(() => {
        if (auth.loggedIn()) {
          this.buildRoutes();
        }
      }, 700);
    },
  };
</script>
