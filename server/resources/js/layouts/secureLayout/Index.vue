<template>
  <fragment>
    <secure-bar />
    <secure-drawer />
    <secure-view />
    <secure-comp-drawer v-if="$route.name.startsWith('Components')" />
    <secure-ent-drawer v-if="$route.name.startsWith('Entities')" />
    <snackbar />
    <!-- <session-timeout /> -->
  </fragment>
</template>

<script>
  export default {
    name: 'SecureLayout',
    components: {
      // SessionTimeout: () =>
      //   import(/* webpackChunkName: 'secure-session-timeout' */ './SessionTimeout/SessionTimeout'),
      SecureBar: () => import(/* webpackChunkName: 'secure-bundle' */ './AppBar'),
      SecureDrawer: () => import(/* webpackChunkName: 'secure-bundle' */ './Drawer'),
      SecureCompDrawer: () => import(/* webpackChunkName: 'secure-component-drawer' */ './ComponentDrawer'),
      SecureEntDrawer: () => import(/* webpackChunkName: 'secure-entities-drawer' */ './EntitiesDrawer'),
      SecureView: () => import(/* webpackChunkName: 'secure-bundle' */ './View'),
      Snackbar: () =>
        import(
          /* webpackChunkName: 'secure-snackbar' */
          '@/components/Base/Snackbar'
        ),
    },
  };
</script>
