<template>
  <div class="d-flex justify-space-between align-center">
    <v-tabs
      v-model="activeStatusTab"
      class="noHover ml-5"
      color="primary"
      show-arrows
      background-color="transparent"
      slider-size="2"
    >
      <v-tab
        v-for="({ icon, name }, i) in modulesStatusTabs"
        :key="i"
        :active-class="isDark ? 'white--text' : ''"
        :ripple="false"
      >
        <v-icon small left>
          {{ icon }}
        </v-icon>
        {{ name }}
      </v-tab>
    </v-tabs>
  </div>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'ModulesDrawerTabs',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('modulesManagement', ['activeStatusTab', 'modulesStatusTabs']),
    },
  };
</script>
