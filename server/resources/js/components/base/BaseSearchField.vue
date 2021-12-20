<template>
  <v-text-field
    v-if="!['Timeshiftsplanning'].includes($route.name)"
    v-model="searchInput"
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
    @keyup.enter="triggerSearch()"
  >
    <template #append>
      <v-btn x-small fab text @click.stop="triggerSearch()"> <v-icon> mdi-magnify </v-icon> </v-btn>
      <v-btn class="mr-n4" x-small fab text @click.stop="clearSearch()"> <v-icon> mdi-close </v-icon> </v-btn>
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
        searchInput: '',
        expand: false,
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('application', ['search']),
    },

    watch: {
      searchInput(newValue) {
        if (!newValue) {
          this.clearSearch();
        }
      },
    },
    methods: {
      clearSearch() {
        this.searchInput = '';
        this.search = '';
      },
      triggerSearch() {
        this.search = this.searchInput;
      },
    },
  };
</script>
