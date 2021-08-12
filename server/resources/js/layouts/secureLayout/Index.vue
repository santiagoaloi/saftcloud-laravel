<template>
 <v-app>
  <secure-bar />
  <secure-drawer />
  <secure-cdrawer v-if="$route.name.startsWith('/components')" />
  <secure-view />
  <snackbar />
 </v-app>
</template>

<script>
export default {
 name: "Securelayout",
 components: {
  SecureBar: () => import(/* webpackChunkName: 'secure-appbar' */ "./AppBar"),
  SecureDrawer: () => import(/* webpackChunkName: 'secure-drawer' */ "./Drawer"),
  SecureCdrawer: () => import(/* webpackChunkName: 'secure-component-drawer' */ "./ComponentDrawer"),
  SecureView: () => import(/* webpackChunkName: 'secure-view' */ "./View"),
  Snackbar: () =>
   import(
    /* webpackChunkName: 'public-snackbar' */
    "@/components/base/Snackbar"
   )
 }
};
</script>
