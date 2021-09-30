<template>
  <keep-alive>
    <component :is="layout" />
  </keep-alive>
</template>

<script>
  import Vue from 'vue';
  import axios from 'axios';
  import config from './configs';
  import auth from '@/util/auth';
  import { store } from '@/store';
  import { sync } from 'vuex-pathify';
  import { router, resetRouter } from '@/router';

  Vue.component('secure_layout', () =>
    import(/* webpackChunkName: 'secure-Layout' */ '@/layouts/secureLayout/Index'),
  );
  Vue.component('public_layout', () =>
    import(/* webpackChunkName: 'public-Layout' */ '@/layouts/publicLayout/Index'),
  );

  export default {
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('application', ['isBooted']),
      ...sync('authentication', ['session']),

      layout() {
        return this.$route.meta.layout;
      },

      vuetfiy() {
        return this.$vuetify;
      },
    },

    name: 'AppVue',

    watch: {
      isDark: {
        immediate: true,
        handler(val) {
          this.$vuetify.theme.dark = val;
        },
      },
    },

    head: {
      link: [...config.icons.map((href) => ({ rel: 'stylesheet', href }))],
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
        if (auth.loggedIn()) {
          this.buildRoutes();
        }
      }, 500);

      document.onreadystatechange = () => {
        if (document.readyState == 'complete') {
          if (!this.isBooted) {
            setTimeout(() => {
              this.isBooted = true;
            }, 300);
          }
        }
      };
    },

    updated() {
      this.$nextTick(function () {
        if (!this.isBooted) {
          setTimeout(() => {
            this.isBooted = true;
          }, 300);
        }
      });
    },

    methods: {
      buildRoutes() {
        // * Clear routes and routes matcher.
        resetRouter();

        // * Waits for indexeddb to be ready.
        setTimeout(() => {
          axios.get('/api/getComponentNames/').then((response) => {
            if (response.status === 200) {
              const components = response.data.components;

              // * Dummy component to avoid webpack error about not finding the path.
              //   if (!components.length) {
              //    components.push("Blank");
              //   }

              // * Add new routes
              //   if(components[0] != 'Blank'){
              for (const component of components) {
                this.$router.addRoute({
                  path: `/${component.name}`,
                  name: `${component.name}`,
                  meta: {
                    layout: 'secure_layout',
                    title: component.title,
                    id: component.id,
                    icon: component.configSettings.icon ? component.configSettings.icon : null,
                  },
                  component: () =>
                    import(`./views/Protected/${component.name}/${component.name}.vue`),
                });
              }
              //   }
            }
          });
        }, 500);
      },
    },
  };
</script>
