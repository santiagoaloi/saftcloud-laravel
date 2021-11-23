<template>
  <v-app>
    <v-fade-transition mode="out-in" leave-active-class="leaveTransition">
      <keep-alive v-if="$route.meta.keepAlive">
        <component :is="layout" />
      </keep-alive>
      <component :is="layout" v-else />
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
      layout() {
        return this.$route.meta.layout;
      },
    },

    async created() {
      if (auth.loggedIn()) {
        try {
          const built = await this.buildRoutes();

          // if (built) {
          //   return SecureLayout;
          // }
        } catch (error) {
          console.log(error);
        }
      }

      // ** Define event bus
      window.eventBus = this;

      // ** Build routes on request.
      window.eventBus.$on('BUS_BUILD_ROUTES', () => {
        this.buildRoutes();
      });
    },

    methods: {
      ...call('authentication/*'),
    },
  };
</script>
