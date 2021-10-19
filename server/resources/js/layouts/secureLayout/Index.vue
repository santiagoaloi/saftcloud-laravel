<template>
  <v-app>
    <secure-bar />
    <secure-drawer />
    <secure-comp-drawer v-if="$route.name.startsWith('Components')" />
    <secure-ent-drawer v-if="$route.name.startsWith('Entities')" />
    <secure-view />
    <snackbar />
    <session-timeout />
  </v-app>
</template>

<script>
  export default {
    name: 'SecureLayout',
    components: {
      SessionTimeout: () =>
        import(/* webpackChunkName: 'secure-session-timeout' */ './SessionTimeout/SessionTimeout'),
      SecureBar: () => import(/* webpackChunkName: 'secure-appbar' */ './AppBar'),
      SecureDrawer: () => import(/* webpackChunkName: 'secure-drawer' */ './Drawer'),
      SecureCompDrawer: () =>
        import(/* webpackChunkName: 'secure-component-drawer' */ './ComponentDrawer'),
      SecureEntDrawer: () =>
        import(/* webpackChunkName: 'secure-entities-drawer' */ './EntitiesDrawer'),
      SecureView: () => import(/* webpackChunkName: 'secure-view' */ './View'),
      Snackbar: () =>
        import(
          /* webpackChunkName: 'public-snackbar' */
          '@/components/Base/Snackbar'
        ),
    },
  };
</script>
