<template>
 <v-app>
  <secure-bar />
  <secure-drawer />
  <!-- <warning-dialog /> -->
  <secure-cdrawer v-if="$route.name.startsWith('/components')" />
  <secure-view />
  <snackbar />
  <session-timeout />
 </v-app>
</template>

<script>
import SessionTimeout from "./SessionTimeout/SessionTimeout.vue";
import WarningDialog from "./SessionTimeout/warningDialog.vue";
export default {
 name: "Securelayout",
 components: {
  SessionTimeout: () => import(/* webpackChunkName: 'secure-session-timeout' */ "./SessionTimeout/SessionTimeout"),
  // WarningDialog: () => import(/* webpackChunkName: 'secure-session-timeout-warning-dialog' */ "./SessionTimeout/WarningDialog"),
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
