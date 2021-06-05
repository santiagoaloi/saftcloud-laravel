<template>
 <v-app>
  <auth-drawer />
  <auth-cdrawer />
  <!-- <auth-element-drawer v-if="$route.name == 'Formbuilder'" /> -->
  <auth-bar />
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
  AuthCdrawer: () => import(/* webpackChunkName: 'secure-cdrawer' */ "./ComponentDrawer"),
  // AuthElementDrawer: () => import(/* webpackChunkName: 'secure-element-drawer' */ "./elementDrawer"),
  AuthView: () => import(/* webpackChunkName: 'secure-view' */ "./View"),
  Snackbar: () =>
   import(
    /* webpackChunkName: 'public-snackbar' */
    "@/components/base/Snackbar"
   )
 }
};
</script>
