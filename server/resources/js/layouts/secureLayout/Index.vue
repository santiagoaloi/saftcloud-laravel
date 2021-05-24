<template>
  <v-app>
    <auth-drawer />
    <!-- <auth-element-drawer v-if="$route.name == 'Formbuilder'" /> -->
    <auth-bar />
    <auth-view />
  </v-app>
</template>

<script>
export default {
  name: "Securelayout",

  components: {
    AuthBar: () => import(/* webpackChunkName: 'secure-appbar' */ "./AppBar"),
    AuthDrawer: () => import(/* webpackChunkName: 'secure-drawer' */ "./Drawer"),
    AuthElementDrawer: () => import(/* webpackChunkName: 'secure-element-drawer' */ "./elementDrawer"),
    AuthView: () => import(/* webpackChunkName: 'secure-view' */ "./View")
  }
};
</script>
