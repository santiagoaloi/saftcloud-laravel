<template>
 <v-app>
  <auth-bar />
  <auth-drawer />
  <auth-cdrawer />
  <auth-view />
  <snackbar />
 </v-app>
</template>

<script>
export default {
 name: "Securelayout",
 components: {
  AuthBar: () => import(/* webpackChunkName: 'secure-appbar' */ "./AppBar"),
  AuthDrawer: () => import(/* webpackChunkName: 'secure-drawer' */ "./Drawer"),
  AuthCdrawer: () => import(/* webpackChunkName: 'secure-component-drawer' */ "./ComponentDrawer"),
  AuthView: () => import(/* webpackChunkName: 'secure-view' */ "./View"),
  Snackbar: () =>
   import(
    /* webpackChunkName: 'public-snackbar' */
    "@/components/base/Snackbar"
   )
 }
};
</script>
