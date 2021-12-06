<template>
  <v-sheet v-once color="transparent" height="100%" class="d-flex justify-center align-center select-none">
    <div class="flex-grow-1 align-center justify-center d-flex flex-column">
      <v-img class="bw-image" :aspect-ratio="1" width="350" contain src="storage/systemImages/noContent.svg" />
      No components found.
    </div>
  </v-sheet>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'ComponentNoData',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['dialogComponent']),
    },
  };
</script>
00000988
