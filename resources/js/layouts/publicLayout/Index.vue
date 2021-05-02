<template>
 <v-app>
  <pub-bar />
  <pub-view />
  <!-- <snackbar /> -->
  <!-- <BaseBackToTop v-show="scrollButton" v-scroll="onScroll" /> -->
  <pub-footer />
 </v-app>
</template>

<script>
export default {
 name: "Publiclayout",
 components: {
  PubBar: () =>
   import(
    /* webpackChunkName: 'public-appbar-view-footer-combined' */ "./AppBar"
   ),
  PubView: () =>
   import(
    /* webpackChunkName: 'public-appbar-view-footer-combined' */ "./View"
   ),
  PubFooter: () =>
   import(
    /* webpackChunkName: 'public-appbar-view-footer-combined' */ "./Footer"
   )
  // Snackbar: () =>
  //   import(
  //     /* webpackChunkName: 'public-snackbar' */
  //     "@/components/base/Snackbar"
  //   ),
 }
};
</script>
