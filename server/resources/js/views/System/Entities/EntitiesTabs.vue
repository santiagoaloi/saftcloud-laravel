<template>
  <div>
    <div class="d-flex justify-space-between align-center">
      <v-tabs
        v-model="activeStatusTab"
        color="accent"
        show-arrows
        class="col-10 mt-n3"
        background-color="transparent"
        slider-size="1"
      >
        <v-tab
          v-for="(tab, i) in entityStatusTabs"
          :key="i"
          :active-class="isDark ? 'white--text' : ''"
          :ripple="false"
        >
          <v-icon small left>
            {{ tab.icon }}
          </v-icon>
          {{ tab.name }}
        </v-tab>
      </v-tabs>

      <div class="d-flex">
        <v-btn class="mt-n3" plain @click="isTableLayout = !isTableLayout">
          <v-icon left>
            {{ isTableLayout ? ' mdi-view-grid-outline' : ' mdi-format-list-bulleted-square' }}
          </v-icon>
          {{ isTableLayout ? 'Grid' : 'List' }}
        </v-btn>
      </div>
    </div>
    <v-divider />
  </div>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'EntitiesTabs',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('entitiesManagement', ['activeStatusTab', 'entityStatusTabs', 'isTableLayout']),
      ...get('entitiesManagement', ['isEmpty', 'isAllFilteredEntititesEmpty']),
    },
  };
</script>
