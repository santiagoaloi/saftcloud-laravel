<template>
  <v-sheet v-once color="transparent" height="100%" class="d-flex justify-center align-center">
    <div class="flex-grow-1 align-center justify-center d-flex flex-column">
      <v-img :aspect-ratio="1" width="250" contain src="storage/systemImages/noContent.svg" />
      No components found. Select one or more groups or try a different search criteria
      <span
        :class="isDark ? 'secundary--text' : 'primary--text'"
        class="cursor-pointer"
        @click="dialogComponent = true"
        ><b> create a new component</b></span
      >
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
