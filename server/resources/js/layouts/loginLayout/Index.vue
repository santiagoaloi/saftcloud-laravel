<template>
 <v-app>
  <login-bar />
  <login-view />
  <snackbar />
 </v-app>
</template>

<script>
export default {
 name: "Loginlayout",
 components: {
  LoginView: () => import(/* webpackChunkName: 'login-view' */ "./View"),
  LoginBar: () => import(/* webpackChunkName: 'public-appbar-view-footer-combined' */ "./AppBar"),
  Snackbar: () =>
   import(
    /* webpackChunkName: 'public-snackbar' */
    "@/components/base/Snackbar"
   )
 },

 computed: {}
};
</script>
