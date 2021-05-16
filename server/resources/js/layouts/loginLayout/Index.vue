<template>
  <v-app>
    <log-bar />
    <login-view />
  </v-app>
</template>

<script>
export default {
  name: "Loginlayout",
  components: {
    LoginView: () => import(/* webpackChunkName: 'login-view' */ "./View"),
    LogBar: () =>
      import(
        /* webpackChunkName: 'public-appbar-view-footer-combined' */ "./AppBar"
      )
  }
};
</script>
