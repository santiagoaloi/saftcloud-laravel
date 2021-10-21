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
          v-for="(tab, i) in componentStatusTabs"
          :key="i"
          :active-class="isDark ? 'white--text' : ''"
          :disabled="isComponentsEmpty"
          :ripple="false"
        >
          <v-icon small left>
            {{ tab.icon }}
          </v-icon>
          {{ tab.name }}
        </v-tab>
      </v-tabs>

      <div class="d-flex">
        <!-- <v-switch v-model="multipleSelect" label="Multiple selection" class="mt-1 mx-4"> </v-switch> -->
        <v-btn
          class="mt-n3"
          plain
          :disabled="isAllFilteredComponentsEmpty"
          @click="isTableLayout = !isTableLayout"
        >
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
    name: 'ComponentsTabs',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['activeStatusTab', 'componentStatusTabs', 'isTableLayout']),
      ...get('componentManagement', ['isComponentsEmpty', 'isAllFilteredComponentsEmpty']),
    },
  };
</script>
