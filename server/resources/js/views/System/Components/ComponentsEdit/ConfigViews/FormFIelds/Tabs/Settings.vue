<template>
  <div>
    <ValidationObserver ref="componentsEditFormFieldsSettingsTab" slim>
      <v-row>
        <v-col cols="12">
          <baseFieldLabel required label="Tooltip" />
          <validation-provider v-slot="{ errors }" name="tooltip text">
            <v-text-field
              v-model="selectedComponentFormField.options.tooltip"
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
    name: 'ComponentsEditViewsFormFieldsTabsSettings',
    computed: {
      ...sync('theme', ['isDark']),
      ...get('componentManagement', ['selectedComponentFormField']),
    },
    methods: {
      setInvalid(invalid, field) {
        store.set(
          `validationStatesComponents/componentsEditFormFieldsSettingsTab@${field}`,
          invalid,
        );
      },
    },
  };
</script>
