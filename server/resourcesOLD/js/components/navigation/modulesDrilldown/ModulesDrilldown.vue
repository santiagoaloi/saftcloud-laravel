<template>
  <div class="select-none">
    <v-expand-transition>
      <base-unsaved-changes v-if="hasUnsavedChanges(selectedModule)" @rollBack="rollbackChanges(selectedModule)" />
    </v-expand-transition>

    <v-card-title> Edit Modules View </v-card-title>
    <v-card-subtitle>
      Edit your module quickly, change group, Modules label, description, enable sidebar visibility and more..</v-card-subtitle
    >

    <modules-drilldown-forms />
    <v-divider />
    <modules-drilldown-metadata />
  </div>
</template>

<script>
  import Vue from 'vue';
  import { sync, get, call } from 'vuex-pathify';
  import { store } from '@/store';

  Vue.component('ModulesDrilldownMetadata', () =>
    import(/* webpackChunkName: 'modules-drilldown-meta' */ '@/components/navigation/modulesDrilldown/ModulesDrilldownMetadata'),
  );

  Vue.component('ModulesDrilldownForms', () =>
    import(/* webpackChunkName: 'modules-drilldown-forms' */ '@/components/navigation/modulesDrilldown/ModulesDrilldownForms'),
  );

  export default {
    name: 'ModulesDrilldown',

    computed: {
      ...sync('theme', ['isDark']),
      ...get('modulesManagement', ['hasUnsavedChanges', 'selectedModule']),
    },

    methods: {
      ...call('modulesManagement', ['rollbackChanges']),

      setInvalid(invalid, field) {
        store.set(`validationStatesModules/ModulesEditBasic@${field}`, invalid);
      },
    },
  };
</script>
