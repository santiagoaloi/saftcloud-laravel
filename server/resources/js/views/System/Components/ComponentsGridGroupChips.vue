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
          <template v-if="mapComponentGroup(component).component_group_id">
            {{ mapGroupParent(component) }}
            <v-icon small> mdi-menu-right </v-icon>
          </template>
          {{ mapComponentGroup(component).name }}
        </div>
      </v-chip>
    </h5>
  </div>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'ComponentsGridGroupChips',

    props: {
      component: {
        type: [Object],
        default: () => {},
      },
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...get('componentManagement', ['mapComponentGroup', 'mapGroupParent']),
    },
  };
</script>
