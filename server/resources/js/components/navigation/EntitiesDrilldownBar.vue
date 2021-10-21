<template>
  <div v-if="selectedEntity" class="mt-3">
    <v-app-bar color="transparent" flat dense>
      <v-tooltip transition="false" color="black" bottom>
        <template #activator="{ on }">
          <v-btn
            :disabled="previousEntityDisabled"
            class="ml-n2 mr-2 mt-n2"
            fab
            text
            x-small
            v-on="on"
            @click="previousEntity()"
          >
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
        </template>
        <span>Previous entity</span>
      </v-tooltip>
      <v-tooltip transition="false" color="black" bottom>
        <template #activator="{ on }">
          <v-btn
            :disabled="nextEntityDisabled"
            class="mt-n2"
            fab
            text
            x-small
            v-on="on"
            @click="nextEntity()"
          >
            <v-icon>mdi-chevron-right</v-icon>
          </v-btn>
        </template>
        <span>Next entity</span>
      </v-tooltip>

      <v-spacer />

      <v-tooltip transition="false" color="black" bottom>
        <template #activator="{ on }">
          <v-btn
            class="mt-n2 mr-n1"
            fab
            text
            x-small
            v-on="on"
            @click.stop="secureEntitiesDrawer = false"
          >
            <v-icon>mdi-menu</v-icon>
          </v-btn>
        </template>
        <span>Hide</span>
      </v-tooltip>
    </v-app-bar>
    <v-divider />
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';

  export default {
    name: 'EntitiesDrilldown',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('drawers', ['secureEntitiesDrawer']),
      ...get('entitiesManagement', [
        'previousEntityDisabled',
        'nextEntityDisabled',
        'selectedEntity',
      ]),
    },

    methods: {
      ...call('entitiesManagement/*'),
    },
  };
</script>
