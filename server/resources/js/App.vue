<template>
  <v-app>
    <v-fade-transition appear hide-on-leave mode="out-in" :duration="100">
      <component :is="layout" />
    </v-fade-transition>
  </v-app>
</template>

<script>
  import { call } from 'vuex-pathify';
  import config from './configs';
  import auth from '@/util/auth';

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
