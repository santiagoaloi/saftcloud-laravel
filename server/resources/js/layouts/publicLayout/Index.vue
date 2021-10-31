<template>
  <v-app>
    <public-bar />
    <public-view />
    <public-footer v-if="!$route.name.startsWith('Login')" />
    <snackbar />
  </v-app>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'PublicLayout',
    components: {
      PublicView: () => import(/* webpackChunkName: 'public-view-bundle' */ './View'),
      PublicBar: () => import(/* webpackChunkName: 'public-view-bundle' */ './AppBar'),
      PublicFooter: () => import(/* webpackChunkName: 'public-footer' */ './Footer'),
      Snackbar: () =>
        import(
          /* webpackChunkName: 'public-snackbar' */
          '@/components/Base/Snackbar'
        ),
    },
    computed: {
      ...sync('theme', ['isDark']),
      opacityLight() {
        if (['Homepage', 'Login', 'initial'].includes(this.$route.name)) {
          return 'rgba(100, 100 , 100 , 0.6) 25%,rgba(43, 43 , 43, 1)';
        }
        return 'rgba(212, 219 , 224, 1) 25%,rgba(212, 219 , 224, 1)';
      },

      opacityDark() {
        if (['Homepage', 'Login', 'initial'].includes(this.$route.name)) {
          return 'rgba(44, 47 , 51, 0.7 ) 25%,rgba(43, 43 , 43, 1)';
        }
        return 'rgba(44, 47 , 51, 1) 65%,rgba(44, 47 , 51,0.9)';
      },

      bg() {
        return this.isDark ? this.bgDark : this.bgLight;
      },

      bgLight() {
        return {
          'background-size': 'cover',
          'background-attachment': 'fixed',
          'background-repeat': 'no-repeat',
          'background-image': `linear-gradient(${this.opacityLight}), url(storage/backgrounds/main4.jpg)`,
        };
      },

      bgDark() {
        return {
          'background-size': 'cover',
          'background-attachment': 'fixed',
          'background-repeat': 'no-repeat',
          'background-image': `linear-gradient(${this.opacityDark}), url(storage/backgrounds/main4.jpg)`,
        };
      },
    },
  };
</script>
