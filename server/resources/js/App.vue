<template>
  <v-app>
    <v-fade-transition mode="out-in" :duration="520" hide-on-leave>
      <!-- <keep-alive exclude="PublicLayout"> -->
      <component :is="layout" />
      <!-- </keep-alive> -->
    </v-fade-transition>
  </v-app>
</template>

<script>
  import Vue from 'vue';
  import axios from 'axios';
  import config from './configs';
  import auth from '@/util/auth';
  import { resetRouter } from '@/router';

  Vue.component('SecureLayout', () => import(/* webpackChunkName: 'secure-Layout' */ '@/layouts/secureLayout'));
  Vue.component('PublicLayout', () => import(/* webpackChunkName: 'public-Layout' */ '@/layouts/publicLayout'));

  export default {
    name: 'App',
    data() {
      return {
        isMounted: false,
      };
    },
    head: {
      link: [...config.icons.map((href) => ({ rel: 'stylesheet', href }))],
    },

    computed: {
      layout() {
        return this.$route.meta.layout;
      },

      vuetfiy() {
        return this.$vuetify;
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
        if (auth.loggedIn() && this.$route.meta.layout !== 'public-layout') {
          this.buildRoutes();
        }
      }, 700);
    },

    mounted() {
      this.isMounted = true;
    },

    methods: {
      buildRoutes() {
        // * Clear routes and routes matcher.
        if (this.isMounted) {
          resetRouter();
        }

        // * Waits for indexeddb to be ready.
        setTimeout(() => {
          axios.get('/api/getComponentNames/').then((response) => {
            const { components } = response.data;

            // * add new routes
            //   if(components[0] != 'Blank'){
            for (const component of components) {
              this.$router.addRoute({
                path: `/${component.name}`,
                name: `${component.name}`,
                meta: {
                  layout: 'secure-layout',
                  title: component.title,
                  id: component.id,
                  icon: component.configSettings.icon || null,
                },
                component: () => import(`./views/Protected/${component.name}/${component.name}.vue`),
              });
            }
          });
        }, 500);
      },
    },
  };
</script>
