<template>
  <div>
    <div class="d-flex justify-end">
      <v-chip v-if="!selectedComponentGroups.length" :ripple="false" class="mr-n3 mt-3 pointer-events-none" label>
        You haven't chosen any groups yet...
      </v-chip>

      <v-chip-group class="mt-1 ml-4" show-arrows>
        <v-chip
          v-for="(item, index) in selectedComponentGroups"
          :key="`${index}`"
          :ripple="false"
          close
          @click:close="unselectGroup(item.id)"
        >
          <v-avatar left>
            <v-btn class="pointer-events-none" :color="isDark ? 'grey darken-3' : 'white'">
              {{ countComponentsInGroup(item.id) }}
            </v-btn>
          </v-avatar>
          {{ item.name }}
        </v-chip>
      </v-chip-group>
    </div>
  </div>
</template>

<script>
  import { sync, get, call } from 'vuex-pathify';

  export default {
    name: 'ComponentsGroups',

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['selectedComponentGroups']),
      ...get('componentManagement', ['countComponentsInGroup']),
    },
    methods: {
      ...call('componentManagement/*'),
    },
  };
</script>
<style>
  .fade-leave {
    transition: opacity 0s;
  }
</style>
