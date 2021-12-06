<template>
  <div class="select-none">
    <v-expand-transition>
      <base-unsaved-changes v-if="hasUnsavedChanges(selectedComponent)" @rollBack="rollbackChanges(selectedComponent)" />
    </v-expand-transition>

    <v-card-title> {{ title }} </v-card-title>
    <v-card-subtitle> {{ subTitle }} </v-card-subtitle>

    <component-drilldown-forms />
    <v-divider />
    <component-drilldown-metadata />
  </div>
</template>

<script>
  import Vue from 'vue';
  import { sync, get, call } from 'vuex-pathify';
  import { store } from '@/store';

  Vue.component('ComponentDrilldownMetadata', () =>
    import(
      /* webpackChunkName: 'component-drilldown-meta' */ '@/components/Navigation/ComponentDrilldown/ComponentDrilldownMetadata'
    ),
  );

  Vue.component('ComponentDrilldownForms', () =>
    import(
      /* webpackChunkName: 'component-drilldown-forms' */ '@/components/Navigation/ComponentDrilldown/ComponentDrilldownForms'
    ),
  );

  export default {
    name: 'ComponentDrilldown',

    computed: {
      ...sync('theme', ['isDark']),
      ...get('componentManagement', ['hasUnsavedChanges', 'selectedComponent']),

      title() {
        return 'Edit Component View';
      },

      subTitle() {
        return 'Edit your module quickly, change group, component label, description, enable sidebar visibility and more..';
      },
    },

    methods: {
      ...call('componentManagement', ['rollbackChanges']),

      setInvalid(invalid, field) {
        store.set(`validationStatesComponents/componentsEditBasic@${field}`, invalid);
      },
    },
  };
</script>
