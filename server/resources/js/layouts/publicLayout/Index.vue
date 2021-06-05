<template>
 <v-app>
  <pub-bar />
  <pub-view />
  <snackbar />
  <pub-footer />
 </v-app>
</template>

<script>
export default {
 name: "Publiclayout",
 components: {
  PubBar: () => import(/* webpackChunkName: 'public-appbar' */ "./AppBar"),
  PubView: () => import(/* webpackChunkName: 'public-view' */ "./View"),
  PubFooter: () => import(/* webpackChunkName: 'public-footer' */ "./Footer"),
  Snackbar: () =>
   import(
    /* webpackChunkName: 'public-snackbar' */
    "@/components/base/Snackbar"
   )
 }
};
</script>
