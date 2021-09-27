<template>
  <div
    v-if="selectedComponent"
    class="mt-3"
  >
    <v-app-bar
      color="transparent"
      flat
      dense
    >
      <v-tooltip
        transition="false"
        color="black"
        bottom
      >
        <template #activator="{ on }">
          <v-btn
            :disabled="previousComponentDisabled"
            class="ml-n2 mr-2 mt-n2"
            fab
            text
            x-small
            v-on="on"
            @click="previousComponent()"
          >
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
        </template>
        <span>Previous component</span>
      </v-tooltip>
      <v-tooltip
        transition="false"
        color="black"
        bottom
      >
        <template #activator="{ on }">
          <v-btn
            :disabled="nextComponentDisabled"
            class=" mt-n2"
            fab
            text
            x-small
            v-on="on"
            @click="nextComponent()"
          >
            <v-icon>mdi-chevron-right</v-icon>
          </v-btn>
        </template>
        <span>Next component</span>
      </v-tooltip>

      <v-spacer />

      <v-tooltip
        transition="false"
        color="black"
        bottom
      >
        <template #activator="{ on }">
          <v-btn
            class=" mt-n2 mr-n1"
            fab
            text
            x-small
            v-on="on"
            @click.stop="secureComponentDrawer = false"
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
  name: 'ComponentDrilldown',
  computed: {
    ...sync('theme', ['isDark']),
    ...sync('drawers', ['secureComponentDrawer']),
    ...sync('componentManagement', ['componentCardGroup']),
    ...get('componentManagement', ['previousComponentDisabled', 'nextComponentDisabled', 'selectedComponent']),
  },

  methods: {
    ...call('componentManagement/*'),
  },
};
</script>
