<template>
  <div>
    <v-sheet class="rightPanelHeight transparent">
      <v-card flat :disabled="hasValidationErrors">
        <v-tabs
          v-model="activeFormFieldTab"
          color="accent"
          show-arrows
          class="col-12 mt-n3 px-0"
          background-color="transparent"
          slider-size="1"
        >
          <v-tab v-for="(tab, i) in formFieldTabs" :key="i" :active-class="isDark ? 'white--text' : ''" :ripple="false">
            <v-icon :color="tab.color" small left>
              {{ tab.icon }}
            </v-icon>
            {{ tab.name }}
          </v-tab>
        </v-tabs>
      </v-card>

      <!-- Active tab Modules -->
      <component :is="activeTabmodulesName" />
    </v-sheet>
  </div>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'ModulesEditViewsFormFieldsRightPanel',
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
      ...get('modulesManagement', ['selectedModuleFormField', 'hasValidationErrors']),
      ...sync('modulesManagement', ['activeFormFieldTab']),

      activeTabmodulesName() {
        return this.formFieldTabs[this.activeFormFieldTab].name;
      },

      fieldIcon() {
        if (!this.selectedModuleFormField) return;
        return this.selectedModuleFormField.icon;
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
