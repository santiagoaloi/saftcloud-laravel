<template>
  <div>
    <ValidationObserver ref="ModulesEditFormFieldsSettingsTab" slim>
      <v-row>
        <v-col cols="12">
          <baseFieldLabel required label="Tooltip" />
          <validation-provider v-slot="{ errors }" name="tooltip text">
            <v-text-field
              v-model="selectedModuleFormField.options.tooltip"
              v-lazy-input:debounce="300"
              :outlined="isDark"
              :solo="!isDark"
              :color="isDark ? '#208ad6' : 'grey'"
              :background-color="isDark ? '#28292b' : 'white'"
              :error-messages="errors[0]"
              :error="errors.length > 0"
            />
          </validation-provider>
        </v-col>
      </v-row>
    </ValidationObserver>
  </div>
</template>

<script>
  import { sync, get } from 'vuex-pathify';
  import { store } from '@/store';

  export default {
    name: 'ModulesEditViewsFormFieldsTabsSettings',
    computed: {
      ...sync('theme', ['isDark']),
      ...get('modulesManagement', ['selectedModuleFormField']),
    },
    methods: {
      setInvalid(invalid, field) {
        store.set(`validationStatesModules/ModulesEditFormFieldsSettingsTab@${field}`, invalid);
      },
    },
  };
</script>
