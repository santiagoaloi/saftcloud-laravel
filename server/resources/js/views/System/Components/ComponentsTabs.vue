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
        v-for="({ icon, name }, i) in componentStatusTabs"
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

    <div class="mr-3">
      <v-btn :disabled="isAllFilteredComponentsEmpty" plain @click="isTableLayout = !isTableLayout">
        <v-icon left>
          {{ isTableLayout ? ' mdi-view-grid-outline' : ' mdi-format-list-bulleted-square' }}
        </v-icon>
        {{ isTableLayout ? 'Grid' : 'List' }}
      </v-btn>
    </div>
  </div>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'ComponentsTabs',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['activeStatusTab', 'componentStatusTabs', 'isTableLayout']),
      ...get('componentManagement', ['isAllFilteredComponentsEmpty']),
    },
  };
</script>
