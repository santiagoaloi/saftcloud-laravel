<template>
  <div>
    <public-bar />
    <public-view />
    <public-footer v-if="!$route.name.startsWith('Login')" />
    <snackbar />
  </div>
</template>

<script>
  export default {
    name: 'PublicWrapper',
    components: {
      PublicView: () => import(/* webpackChunkName: 'public-bundle' */ './View'),
      PublicBar: () => import(/* webpackChunkName: 'public-bundle' */ './AppBar'),
      PublicFooter: () => import(/* webpackChunkName: 'public-bundle' */ './Footer'),
      Snackbar: () =>
        import(
          /* webpackChunkName: 'public-snackbar' */
          '@/components/Base/Snackbar'
        ),
    },
  };
</script>
