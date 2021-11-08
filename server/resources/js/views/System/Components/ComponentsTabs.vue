<template>
  <div class="d-flex justify-space-between align-center">
    <v-tabs
      v-once
      v-model="activeStatusTab"
      color="primary"
      show-arrows
      class="col-10 mt-n3"
      background-color="transparent"
      slider-size="2"
    >
      <v-tab
        v-for="({ icon, name }, i) in componentStatusTabs"
        :key="i"
        :active-class="isDark ? 'white--text' : ''"
        :disabled="isComponentsEmpty"
        :ripple="false"
      >
        <v-icon v-once small left>
          {{ icon }}
        </v-icon>
        {{ name }}
      </v-tab>
    </v-tabs>

    <div class="mr-4">
      <v-btn plain :disabled="isAllFilteredComponentsEmpty" @click="isTableLayout = !isTableLayout">
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
      ...get('componentManagement', ['isComponentsEmpty', 'isAllFilteredComponentsEmpty']),
    },
  };
</script>
