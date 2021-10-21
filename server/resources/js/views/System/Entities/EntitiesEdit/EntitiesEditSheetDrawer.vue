<template>
  <v-navigation-drawer
    v-model="entitiesEditSheet"
    src="storage/appbar/prism2.jpg"
    color="#2f3136"
    mobile-breakpoint="0"
    hide-overlay
    width="250"
  >
    <entities-edit-sheet-menu />
  </v-navigation-drawer>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'ComponentsEditSheetDrawer',
    components: {
      EntitiesEditSheetMenu: () => import('./EntitiesEditSheetMenu'),
    },
    computed: {
      ...sync('entitiesManagement', ['entitiesEditSheet']),
      ...get('entitiesManagement', ['hasValidationErrors']),
    },
  };
</script>
