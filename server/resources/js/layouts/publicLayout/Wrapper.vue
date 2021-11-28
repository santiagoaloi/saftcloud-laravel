<template>
  <div>
    <public-bar />
    <public-view />

    <v-lazy
      v-if="!$route.name.startsWith('Login')"
      :options="{
        threshold: 0.8,
      }"
      min-height="200"
      width="100%"
    >
      <public-footer />
    </v-lazy>
    <snackbar />
  </div>
</template>

<script>
  export default {
    name: 'PublicWrapper',
    components: {
      PublicView: () => import(/* webpackChunkName: 'public-bundle' */ './View'),
      PublicBar: () => import(/* webpackChunkName: 'public-bundle' */ './AppBar'),
      PublicFooter: () => import(/* webpackChunkName: 'public-footer' */ './Footer'),
      Snackbar: () => import('@/components/Base/Snackbar'),
    },
  };
</script>
