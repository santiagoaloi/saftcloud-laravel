<template>
  <v-text-field
    v-if="!['Timeshiftsplanning'].includes($route.name)"
    v-model="search"
    v-lazy-input:debounce="500"
    spellcheck="false"
    outlined
    :color="isDark ? '#208ad6' : 'grey'"
    dense
    flat
    :class="expand ? 'expanded' : 'shrinked'"
    solo
    hide-details
    :placeholder="'Search ' + ($route.meta.search || '...')"
    prepend-inner-icon="mdi-magnify"
    class="mx-11 pr-12"
    rounded
    @focus="expand = true"
    @blur="expand = false"
  >
    <template #append>
      <v-btn class="mr-n4" x-small fab text @click.stop="search = ''"> <v-icon> mdi-close </v-icon> </v-btn>
    </template>
  </v-text-field>
</template>

<script>
  // Utilities
  import { sync } from 'vuex-pathify';

  export default {
    name: 'SearchField',
    data() {
      return {
        expand: false,
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('application', ['search']),
    },
  };
</script>
