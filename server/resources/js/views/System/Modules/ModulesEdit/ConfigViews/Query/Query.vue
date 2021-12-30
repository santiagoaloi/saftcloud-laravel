<template>
  <div class="h-full">
    <ValidationObserver ref="ModulesEditQuery" slim>
      <validation-provider name="Modules query" rules="required">
        <base-editor :key="editorKey" v-model="selectedModule.config.general_config.sql_query" mode="sql" />
      </validation-provider>
    </ValidationObserver>
  </div>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';

  export default {
    name: 'ModulesEditQuery',
    components: {},
    data: () => ({
      editorKey: 800,
    }),

    computed: {
      ...sync('theme', ['isDark']),
      ...get('modulesManagement', ['selectedModule']),
    },

    watch: {
      isDark(oldValue, newValue) {
        if (oldValue !== newValue) {
          this.editorKey += 1;
        }
      },
    },

    methods: {
      ...call('modulesManagement/*'),
    },
  };
</script>

<style scoped>
  .queryHeight {
    height: calc(100vh - 103px);
    overflow-y: auto;
  }
</style>
