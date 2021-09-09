<template>
 <v-app :style="bg">
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
 },
 computed: {
  bg() {
   return {
    "background-image": `linear-gradient(rgba(100, 100, 100, 0.5),rgba(0, 0, 0, 0.8)), url(storage/11.png)`,
    "background-repeat": "no-repeat",
    "background-size": "cover",
    "background-attachment": "fixed"
   };
  }
 }
};
</script>
