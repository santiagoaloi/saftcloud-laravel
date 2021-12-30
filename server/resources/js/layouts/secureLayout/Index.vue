<template>
  <div class="select-none h-full">
    <secure-bar />
    <secure-drawer />
    <secure-view />

    <secure-modules-drawer v-if="$route.name.startsWith('Modules')" />
    <secure-ent-drawer v-if="$route.name.startsWith('Entities')" />

    <snackbar />
    <!-- <session-timeout /> -->
  </div>
</template>

<script>
  export default {
    name: 'SecureLayout',
    components: {
      // SessionTimeout: () =>
      //   import(/* webpackChunkName: 'secure-session-timeout' */ './SessionTimeout/SessionTimeout'),
      SecureBar: () => import(/* webpackChunkName: 'secure-bundle' */ './AppBar'),
      SecureDrawer: () => import(/* webpackChunkName: 'secure-bundle' */ './Drawer'),
      SecureModulesDrawer: () => import(/* webpackChunkName: 'secure-modules-drawer' */ './ModulesDrawer'),
      SecureEntDrawer: () => import(/* webpackChunkName: 'secure-entities-drawer' */ './EntitiesDrawer'),
      SecureView: () => import(/* webpackChunkName: 'secure-bundle' */ './View'),
    },
  };
</script>
