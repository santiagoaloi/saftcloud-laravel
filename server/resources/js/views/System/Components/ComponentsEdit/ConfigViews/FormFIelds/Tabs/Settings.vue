<template>
 <div>
  <ValidationObserver ref="componentsEditFormFieldsSettingsTab" slim>
   <v-row>
    <v-col cols="12">
     <baseFieldLabel required label="Tooltip" />
     <validation-provider v-slot="{ errors }" name="tooltip text">
      <v-text-field
       :outlined="isDark"
       :solo="!isDark"
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? '#28292b' : 'white'"
       v-model="selectedComponentFormField.options.tooltip"
       :error-messages="errors[0]"
       :error="errors.length > 0"
       v-lazy-input:debounce="300"
      >
      </v-text-field>
     </validation-provider>
    </v-col>
   </v-row>
  </ValidationObserver>
 </div>
</template>

<script>
import { store } from "@/store";
import { sync, get } from "vuex-pathify";
export default {
 name: "ComponentsEditViewsFormFieldsTabsSettings",
 computed: {
  ...sync("theme", ["isDark"]),
  ...get("componentManagement", ["selectedComponentFormField"])
 },
 methods: {
  setInvalid(invalid, field) {
   store.set(`validationStates/componentsEditFormFieldsSettingsTab@${field}`, invalid);
  }
 }
};
</script>
