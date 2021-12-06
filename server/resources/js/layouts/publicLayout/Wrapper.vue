<template>
  <fragment>
    <public-bar />
    <public-view />
    <public-footer />
    <snackbar />
  </fragment>
</template>

<script>
  export default {
    name: 'PublicWrapper',
    components: {
      PublicFooter: () => import(/* webpackChunkName: 'public-bundle' */ './Footer'),
      PublicView: () => import(/* webpackChunkName: 'public-bundle' */ './View'),
      PublicBar: () => import(/* webpackChunkName: 'public-bundle' */ './AppBar'),
      Snackbar: () => import('@/components/Base/Snackbar'),
    },
  };
</script>
