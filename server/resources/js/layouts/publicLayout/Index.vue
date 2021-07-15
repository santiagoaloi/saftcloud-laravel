<template>
 <v-app>
  <public-bar />
  <public-view />
  <snackbar />
  <public-footer />
 </v-app>
</template>

<script>
export default {
 name: "Publiclayout",
 components: {
  PublicBar: () => import(/* webpackChunkName: 'public-appbar' */ "./AppBar"),
  PublicView: () => import(/* webpackChunkName: 'public-view' */ "./View"),
  PublicFooter: () => import(/* webpackChunkName: 'public-footer' */ "./Footer"),
  Snackbar: () =>
   import(
    /* webpackChunkName: 'public-snackbar' */
    "@/components/base/Snackbar"
   )
 }
};
</script>
