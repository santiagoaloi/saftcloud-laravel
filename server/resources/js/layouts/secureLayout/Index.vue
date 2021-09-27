<template>
 <v-app>
  <secure-bar />
  <secure-drawer />
  <secure-cdrawer v-if="$route.name.startsWith('components')" />
  <secure-accdrawer v-if="$route.name.startsWith('accounts')" />
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
  SecureBar: () => import(/* webpackChunkName: 'secure-appbar' */ "./AppBar"),
  SecureDrawer: () => import(/* webpackChunkName: 'secure-drawer' */ "./Drawer"),
  SecureCdrawer: () => import(/* webpackChunkName: 'secure-component-drawer' */ "./ComponentDrawer"),
  SecureAccdrawer: () => import(/* webpackChunkName: 'secure-accounts-drawer' */ "./AccountsDrawer"),
  SecureView: () => import(/* webpackChunkName: 'secure-view' */ "./View"),
  Snackbar: () =>
   import(
    /* webpackChunkName: 'public-snackbar' */
    "@/components/Base/Snackbar"
   )
 }
};
</script>
