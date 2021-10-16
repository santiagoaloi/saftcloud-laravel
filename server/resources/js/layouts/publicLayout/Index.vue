<template>
  <v-app :style="bg">
    <public-bar />
    <public-view />
    <public-footer v-if="!$route.name.startsWith('Login')" />
    <snackbar />
  </v-app>
</template>

<script>
  export default {
    name: 'PublicLayout',
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
      opacity() {
        if (['Homepage', 'Login'].includes(this.$route.name)) {
          return 0.9;
        }
        return 1;
      },

      bg() {
        return {
          'background-size': 'cover',
          'background-attachment': 'fixed',
          'background-repeat': 'no-repeat',
          'background-image': `linear-gradient(rgba(44, 47,51, ${this.opacity}) 65%,rgba(44,47,51, 0.9) ), url(storage/backgrounds/main4.jpg)`,
        };
      },
    },
  };
</script>
