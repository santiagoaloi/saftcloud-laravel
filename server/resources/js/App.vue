<template>
  <keep-alive>
    <div v-show="isContentLoaded">
      <public-layout v-if="layout === 'public_layout'" />
      <secure-layout v-if="layout === 'secure_layout'" />
    </div>
  </keep-alive>
</template>

<script>
  import Vue from 'vue';
  import axios from 'axios';
  import { sync } from 'vuex-pathify';
  import config from './configs';
  import auth from '@/util/auth';
  import { resetRouter } from '@/router';

  Vue.component('SecureLayout', () =>
    import(/* webpackChunkName: 'secure-Layout' */ '@/layouts/secureLayout/Index'),
  );
  Vue.component('PublicLayout', () =>
    import(/* webpackChunkName: 'public-Layout' */ '@/layouts/publicLayout/Index'),
  );

  export default {
    name: 'AppVue',
    data() {
      return {
        firstPaint: false,
      };
    },
    head: {
      link: [...config.icons.map((href) => ({ rel: 'stylesheet', href }))],
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('application', ['isBooted', 'isContentLoaded']),
      ...sync('authentication', ['session']),

      layout() {
        return this.$route.meta.layout;
      },

      vuetfiy() {
        return this.$vuetify;
      },
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
        if (auth.loggedIn()) {
          this.buildRoutes();
        }
      }, 500);

      document.onreadystatechange = () => {
        if (document.readyState === 'complete') {
          setTimeout(() => {
            this.firstPaint = true;
            this.isBooted = true;
          }, 500);
        }
      };
    },

    updated() {
      // this.$nextTick(() => {
      if (this.firstPaint) {
        // setTimeout(() => {
        this.isBooted = true;
        // this.isContentLoaded = true;
        // }, 500);
      }
      // });
    },

    methods: {
      buildRoutes() {
        // * Clear routes and routes matcher.
        resetRouter();

        // * Waits for indexeddb to be ready.
        setTimeout(() => {
          axios.get('/api/getComponentNames/').then((response) => {
            if (response.status === 200) {
              const { components } = response.data;

              // * Dummy component to avoid webpack error about not finding the path.
              //   if (!components.length) {
              //    components.push("Blank");
              //   }

              // * add new routes
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
