<template>
  <baseDialog
    v-model="dialogEditor"
    transition="fade-transition"
    width="70vw"
    no-gutters
    absolute-toolbar
    title="Modules config structure"
    filled
    fluid
    icon="mdi-code-json"
    no-container
    @save="saveModuleConfigStructure()"
    @close="dialogEditor = false"
  >
    <v-card flat width="100%">
      <base-editor v-model="moduleConfigStructure" mode="json" />
    </v-card>
  </baseDialog>
</template>
<script>
  import { sync, call } from 'vuex-pathify';

  export default {
    name: 'DialogConfigEditor',

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('modulesManagement', ['dialogEditor', 'moduleConfigStructure']),
    },

    mounted() {
      this.getModuleConfigStructure();
    },

    methods: {
      ...call('modulesManagement/*'),
    },
  };
</script>
<style>
  .dialogHeight {
    height: calc(100vh - 300px);
    overflow-y: auto;
  }
</style>
