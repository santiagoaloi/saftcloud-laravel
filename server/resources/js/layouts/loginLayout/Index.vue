<template>
  <v-app>
    <log-view />
  </v-app>
</template>

<script>
export default {
  name: "Loginlayout",
  components: {
    LogView: () => import(/* webpackChunkName: 'login-view' */ "./View")
  }
};
</script>
