<template>
  <v-navigation-drawer
    v-model="componentEditSheet"
    src="storage/appbar/prism2.jpg"
    color="#2f3136"
    mobile-breakpoint="0"
    hide-overlay
    width="250"
  >
    <components-edit-sheet-menu />
  </v-navigation-drawer>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'ComponentsEditSheetDrawer',
    components: {
      ComponentsEditSheetMenu: () => import('./ComponentsEditSheetMenu'),
    },
    computed: {
      ...sync('componentManagement', ['componentEditSheet']),
      ...get('componentManagement', ['hasValidationErrors']),
    },
  };
</script>
