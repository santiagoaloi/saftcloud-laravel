<template>
  <div class="d-flex justify-space-between">
    <template v-if="appBarSlot">
      <component :is="appBarSlot" />
    </template>
  </div>
</template>

<script>
  // Utilities
  import { sync } from 'vuex-pathify';

  export default {
    name: 'BaseAppBarTitle',

    computed: {
      ...sync('activeView', ['titleBarSlot']),

      appBarSlot() {
        return this.$route.meta.appBarSlot;
      },
    },
  };
</script>
