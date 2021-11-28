<template>
  <v-card flat width="100%" class="mx-auto h-full">
    <ValidationObserver ref="componentsEditQuery" slim>
      <validation-provider name="component query" rules="required">
        <base-editor :key="editorKey" v-model="selectedComponent.config.general_config.sql_query" mode="sql" />
      </validation-provider>
    </ValidationObserver>
  </v-card>
</template>

<script>
  import { sync, call, get } from 'vuex-pathify';

  export default {
    name: 'ComponentsEditQuery',
    components: {},
    data: () => ({
      editorKey: 800,
    }),

    computed: {
      ...sync('theme', ['isDark']),
      ...get('componentManagement', ['selectedComponent']),
    },

    watch: {
      isDark(oldValue, newValue) {
        if (oldValue !== newValue) {
          this.editorKey += 1;
        }
      },
    },

    methods: {
      ...call('componentManagement/*'),
    },
  };
</script>

<style scoped>
  .queryHeight {
    height: calc(100vh - 103px);
    overflow-y: auto;
  }
</style>
