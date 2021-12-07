<template>
  <div class="pa-4">
    <v-item-group
      v-model="componentCardGroup"
      class="pa-1"
      :active-class="isDark ? 'gridCardDark' : 'gridcardLight'"
      style="width: 100%"
    >
      <components-grid-content />
    </v-item-group>
  </div>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'ComponentsGridView',

    components: {
      ComponentsGridContent: () => import('./ComponentsGridContent'),
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['componentCardGroup']),
    },
  };
</script>
