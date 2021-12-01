<template>
  <div class="pt-3">
    <v-app-bar color="transparent" flat dense>
      <v-tooltip transition="false" color="black" bottom>
        <template #activator="{ on }">
          <v-btn
            :disabled="previousComponentDisabled"
            class="ml-1 mr-2 mt-n2"
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
      <v-tooltip transition="false" color="black" bottom>
        <template #activator="{ on }">
          <v-btn :disabled="nextComponentDisabled" class="mt-n2" fab text x-small v-on="on" @click="nextComponent()">
            <v-icon>mdi-chevron-right</v-icon>
          </v-btn>
        </template>
        <span>Next component</span>
      </v-tooltip>

      <v-spacer />
    </v-app-bar>
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';

  export default {
    name: 'ComponentDrilldownBar',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['componentCardGroup']),
      ...get('componentManagement', ['previousComponentDisabled', 'nextComponentDisabled']),
    },

    methods: {
      ...call('componentManagement', ['previousComponent', 'nextComponent']),
    },
  };
</script>
