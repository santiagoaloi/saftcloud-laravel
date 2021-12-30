<template>
  <div class="pa-4">
    <v-item-group v-model="modulesCardGroup" active-class="gridCardDark">
      <modules-grid-content />
    </v-item-group>
  </div>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'ModulesGridView',

    components: {
      ModulesGridContent: () => import('./ModulesGridContent'),
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('modulesManagement', ['modulesCardGroup']),
    },
  };
</script>
