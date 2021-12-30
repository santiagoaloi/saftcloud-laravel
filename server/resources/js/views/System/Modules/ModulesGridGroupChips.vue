<template>
  <div class="gallery-card-subtitle-wrapper">
    <h5 class="gallery-card-subtitle">
      <v-chip
        :color="isDark ? '#4c536c' : 'white'"
        :text-color="isDark ? 'grey lighten-1' : 'indigo darken-4'"
        class="col-12 pointer-events-none"
        small
      >
        <v-icon x-small> mdi-folder-outline </v-icon>
        <div class="col-12 text-truncate">
          <template v-if="mapModulesGroup(module).module_group_id">
            {{ mapGroupParent(module) }}
            <v-icon small> mdi-menu-right </v-icon>
          </template>
          {{ mapModulesGroup(module).name }}
        </div>
      </v-chip>
    </h5>
  </div>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'ModulesGridGroupChips',

    props: {
      module: {
        type: [Object],
        default: () => {},
      },
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...get('modulesManagement', ['mapModulesGroup', 'mapGroupParent']),
    },
  };
</script>
