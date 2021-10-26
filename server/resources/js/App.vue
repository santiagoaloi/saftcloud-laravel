<template>
  <div>
    <v-fade-transition hide-on-leave>
      <keep-alive exclude="PublicLayout">
        <component :is="layout" />
      </keep-alive>
    </v-fade-transition>
  </div>
</template>

<script>
  import Vue from 'vue';
  import axios from 'axios';
  import { sync } from 'vuex-pathify';
  import config from './configs';
  import auth from '@/util/auth';
  import { resetRouter } from '@/router';

  Vue.component('SecureLayout', () =>
    import(/* webpackChunkName: 'secure-Layout' */ '@/layouts/secureLayout/Index.vue'),
  );
  Vue.component('PublicLayout', () =>
    import(/* webpackChunkName: 'public-Layout' */ '@/layouts/publicLayout/Index'),
  );

  export default {
    name: 'AppVue',

    head: {
      link: [...config.icons.map((href) => ({ rel: 'stylesheet', href }))],
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('authentication', ['session']),

      layout() {
        return this.$route.meta.layout;
      },

      // vuetfiy() {
      //   return this.$vuetify;
      // },
    },

    watch: {
      isDark: {
        immediate: true,
        handler(val) {
          this.$vuetify.theme.dark = val;
        },
      },
    },

    created() {
      // ** Define event bus
      window.eventBus = this;

      // ** Build routes on request.
      window.eventBus.$on('BUS_BUILD_ROUTES', () => {
        this.buildRoutes();
      });
    },

    mounted() {
      // * Waits for auth to be ready.
      setTimeout(() => {
        if (auth.loggedIn() && this.$route.meta.layout !== 'public-layout') {
          this.buildRoutes();
        }
      }, 500);
    },

    methods: {
      buildRoutes() {
        // * Clear routes and routes matcher.
        resetRouter();

        // * Waits for indexeddb to be ready.
        setTimeout(() => {
          axios.get('/api/getComponentNames/').then((response) => {
            const { components } = response.data;
            Object.freeze(components);

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
                component: () =>
                  import(`./views/Protected/${component.name}/${component.name}.vue`),
              });
            }
          });
        }, 500);
      },
    },
  };
</script>
