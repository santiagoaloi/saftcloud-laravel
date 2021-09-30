<template>
  <v-container fluid>
    <v-sheet color="transparent" height="50vh" class="d-flex pa-2 justify-center align-center">
      <div class="flex-grow-1 align-center justify-center d-flex flex-column">
        <v-img :aspect-ratio="1" width="250" contain src="storage/systemImages/noContent.svg" />
        No roles found. Choose a different filter or
        <span
          :class="isDark ? 'secundary--text' : 'primary--text'"
          class="cursor-pointer"
          @click="dialogEntity = true"
          ><b> create a new role</b></span
        >
      </div>
    </v-sheet>
  </v-container>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'AccountsNoData',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('accountsManagement', ['dialogEntity']),
    },
  };
</script>
