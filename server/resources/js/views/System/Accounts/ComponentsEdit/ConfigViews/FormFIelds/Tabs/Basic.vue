<template>
  <div>
    <ValidationObserver
      ref="componentsEditFormFieldsBasicTab"
      slim
    >
      <v-row>
        <v-col cols="6">
          <baseFieldLabel
            required
            label="Label"
          />
          <validation-provider
            v-slot="{ errors, invalid }"
            immediate
            mode="aggressive"
            name="field label"
            rules="required"
          >
            <v-text-field
              v-model="selectedComponentFormField.label"
              :outlined="isDark"
              :solo="!isDark"
              :color="isDark ? '#208ad6' : 'grey'"
              :background-color="isDark ? '#28292b' : 'white'"
              :prepend-inner-icon="selectedComponentFormField.icon.name"
              :error-messages="errors[0]"
              :error="errors.length > 0"
              @click:prepend-inner="dialogIcons = true"
              @change="setInvalid(invalid, 'label')"
            />
          </validation-provider>
        </v-col>
        <v-col cols="6">
          <baseFieldLabel
            required
            label="Input type"
          />
          <validation-provider
            v-slot="{ errors }"
            name="field input type"
            rules="required"
          >
            <v-select
              v-model="selectedComponentFormField.inputType"
              :outlined="isDark"
              :solo="!isDark"
              :item-color="isDark ? 'indigo lighten-3' : 'primary'"
              :color="isDark ? '#208ad6' : 'grey'"
              :background-color="isDark ? '#28292b' : 'white'"
              :menu-props="{ transition: 'slide-y-transition' }"
              :items="inputTypes"
              :error-messages="errors[0]"
              :error="errors.length > 0"
            />
          </validation-provider>
        </v-col>
      </v-row>
    </ValidationObserver>
    <base-dialog-icons
      v-if="dialogIcons"
      v-model="dialogIcons"
      :icon="componentIcon"
    />
  </div>
</template>

<script>
import { sync, get } from 'vuex-pathify';
import { store } from '@/store';

export default {
  name: 'ComponentsEditViewsFormFieldsTabsBasic',
  data() {
    return {
      dialogIcons: false,
      inputTypes: [
        { value: 'text', text: 'Text' },
        { value: 'number', text: 'Number' },
        { value: 'password', text: 'Password' },
        { value: 'range', text: 'Range' },
        { value: 'color', text: 'Color' },
        { value: 'email', text: 'Email' },
        { value: 'phone', text: 'Phone' },
      ],
    };
  },

  computed: {
    ...sync('theme', ['isDark']),
    ...sync('validationStates', ['componentsEditFormFieldsBasicTab']),
    ...get('componentManagement', ['selectedComponentFormField']),

    componentIcon() {
      if (!this.selectedComponentFormField) return;
      return this.selectedComponentFormField.icon;
    },
  },

  methods: {
    setInvalid(invalid, field) {
      store.set(`validationStates/componentsEditFormFieldsBasicTab@${field}`, invalid);
    },
  },
};
</script>
