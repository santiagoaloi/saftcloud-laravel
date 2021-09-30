<template>
  <v-app :style="bg">
    <public-bar />

    <div v-show="isBooted">
      <public-view />
      <public-footer v-if="!$route.name.startsWith('login')" />
    </div>
    <snackbar />
  </v-app>
</template>

<script>
  import { sync } from 'vuex-pathify';
  export default {
    name: 'Publiclayout',
    components: {
      PublicView: () => import(/* webpackChunkName: 'public-view' */ './View'),
      PublicBar: () => import(/* webpackChunkName: 'public-appbar' */ './AppBar'),
      PublicFooter: () => import(/* webpackChunkName: 'public-footer' */ './Footer'),
      Snackbar: () =>
        import(
          /* webpackChunkName: 'public-snackbar' */
          '@/components/Base/Snackbar'
        ),
    },
    computed: {
      ...sync('application', ['isBooted']),

      bg() {
        return {
          'background-size': 'cover',
          'background-attachment': 'fixed',
          'background-repeat': 'no-repeat',
          'background-image': `linear-gradient(rgba(84, 120,170, 0.5),rgba(0, 0,0, 1)), url(storage/backgrounds/main4.jpg)`,
        };
      },
    },
  };
</script>
