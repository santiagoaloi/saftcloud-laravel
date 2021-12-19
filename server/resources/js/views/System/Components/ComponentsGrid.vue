<template>
  <div class="pa-4">
    <components-grid-content />
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
    },
  };
</script>
