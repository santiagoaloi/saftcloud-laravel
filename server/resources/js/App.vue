<template>
  <v-app>
    <v-fade-transition leave-active-class="leaveTransition" mode="out-in" :duration="520">
      <keep-alive>
        <component :is="layout" />
      </keep-alive>
    </v-fade-transition>
  </v-app>
</template>

<script>
  import Vue from 'vue';
  import { call } from 'vuex-pathify';
  import config from './configs';
  import auth from '@/util/auth';

  Vue.component('SecureLayout', () => import(/* webpackChunkName: 'secure-layout' */ '@/layouts/secureLayout/Index.vue'));
  Vue.component('PublicLayout', () => import(/* webpackChunkName: 'public-layout' */ '@/layouts/publicLayout/Index.vue'));

  export default {
    name: 'MainApp',

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
          await this.buildRoutes();
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
