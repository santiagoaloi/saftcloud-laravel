<template>
  <div class="pt-3">
    <v-app-bar color="transparent" flat dense>
      <!-- <v-tooltip transition="false" color="black" bottom>
        <template #activator="{ on }">
          <v-btn
            :disabled="previousModulesDisabled"
            class="ml-1 mr-2 mt-n2"
            fab
            text
            x-small
            v-on="on"
            @click="previousModules()"
          >
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
        </template>
        <span>Previous Modules</span>
      </v-tooltip>
      <v-tooltip transition="false" color="black" bottom>
        <template #activator="{ on }">
          <v-btn :disabled="nextModulesDisabled" class="mt-n2" fab text x-small v-on="on" @click="nextModules()">
            <v-icon>mdi-chevron-right</v-icon>
          </v-btn>
        </template>
        <span>Next Modules</span>
      </v-tooltip> -->

      <v-spacer />
    </v-app-bar>
  </div>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'ModulesDrilldownBar',
    computed: {
      ...sync('theme', ['isDark']),
    },

    methods: {},
  };
</script>
