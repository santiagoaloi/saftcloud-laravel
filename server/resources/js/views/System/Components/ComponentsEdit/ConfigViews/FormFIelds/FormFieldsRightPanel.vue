<template>
  <div>
    <v-sheet class="rightPanelHeight transparent">
      <v-card flat :disabled="hasValidationErrors">
        <v-tabs
          v-model="activeFormFieldTab"
          color="accent"
          showArrows
          class="col-12 mt-n3 px-0"
          background-color="transparent"
          sliderSize="1"
        >
          <v-tab
            :activeClass="isDark ? 'white--text' : ''"
            :key="i"
            v-for="(tab, i) in formFieldTabs"
            :ripple="false"
          >
            <v-icon :color="tab.color" small left>
              {{ tab.icon }}
            </v-icon>
            {{ tab.name }}
          </v-tab>
        </v-tabs>
      </v-card>

      <!-- Active tab component -->
      <component :is="activeTabComponentName" />
    </v-sheet>
  </div>
</template>

<script>
  import { sync, get } from 'vuex-pathify';
  export default {
    name: 'ComponentsEditViewsFormFieldsRightPanel',
    components: {
      Basic: () => import(/* webpackChunkName: 'form-fields-tabs-basic' */ './Tabs/Basic'),
      Settings: () => import(/* webpackChunkName: 'form-fields-tabs-settings' */ './Tabs/Settings'),
    },
    data: () => ({
      dialogIcon: false,
      formFieldTabs: [
        { name: 'Basic', icon: 'mdi-note-outline' },
        { name: 'Settings', icon: 'mdi-note-outline' },
      ],
    }),

    computed: {
      ...sync('theme', ['isDark']),
      ...get('componentManagement', ['selectedComponentFormField', 'hasValidationErrors']),
      ...sync('componentManagement', ['activeFormFieldTab']),

      activeTabComponentName() {
        return this.formFieldTabs[this.activeFormFieldTab].name;
      },

      fieldIcon() {
        if (!this.selectedComponentFormField) return;
        return this.selectedComponentFormField.icon;
      },
    },
  };
</script>
<style scoped>
  .rightPanelHeight {
    height: calc(100vh - 165px);
    overflow-y: auto;
    overflow-x: hidden;
  }
</style>
