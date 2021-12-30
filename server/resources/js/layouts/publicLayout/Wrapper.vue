<template>
  <div class="select-none h-full" :class="{ 'd-flex': $route.name.startsWith('Login') }">
    <public-bar />
    <public-view />
    <public-footer />
    <snackbar />
  </div>
</template>

<script>
  export default {
    name: 'PublicWrapper',
    components: {
      PublicFooter: () => import(/* webpackChunkName: 'public-bundle' */ './Footer'),
      PublicView: () => import(/* webpackChunkName: 'public-bundle' */ './View'),
      PublicBar: () => import(/* webpackChunkName: 'public-bundle' */ './AppBar'),
    },
  };
</script>
