<template>
  <div v-if="titleBarSlot" class="d-flex align-center">
    <v-btn icon class="mr-4">
      <v-icon>mdi-chevron-left</v-icon>
    </v-btn>

    <h2>{{ titleBarSlot }}</h2>

    <v-btn icon class="ml-4" @click="increase()">
      <v-icon>mdi-chevron-right</v-icon>
    </v-btn>
  </div>
</template>

<script>
  import { sync, call } from 'vuex-pathify';

  export default {
    name: 'AppBarSlot',

    computed: {
      ...sync('activeView', ['titleBarSlot']),
    },

    methods: {
      increase() {
        this.$broadcast('timeShiftsPlanningCalNext');
      },
    },
  };
</script>
