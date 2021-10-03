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
