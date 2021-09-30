<template>
  <v-navigation-drawer
    v-model="componentEditSheet"
    color="#2f3136"
    mobile-breakpoint="0"
    hide-overlay
    width="250"
  >
    <drawer-menu />
  </v-navigation-drawer>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'BaseViewDrawer',
    components: {
      DrawerMenu: () => import('./BaseViewDrawerMenu'),
    },
    computed: {
      ...sync('componentManagement', ['componentEditSheet']),
      ...get('componentManagement', ['hasValidationErrors']),
    },
  };
</script>
