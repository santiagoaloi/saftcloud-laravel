<template>
 <div>
  <ValidationObserver ref="componentsEditFormFieldsBasicTab" slim>
   <v-row>
    <v-col cols="6">
     <BaseFieldLabel required label="Label" />
     <validation-provider immediate mode="aggressive" v-slot="{ errors, invalid }" name="field label" rules="required">
      <v-text-field
       :outlined="isDark"
       :solo="!isDark"
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? '#28292b' : 'white'"
       v-model="selectedComponentFormField.label"
       :prepend-inner-icon="selectedComponentFormField.icon.name"
       @click:prepend-inner="dialogIcons = true"
       :error-messages="errors[0]"
       :error="errors.length > 0"
       @change="setInvalid(invalid, 'label')"
      >
      </v-text-field>
     </validation-provider>
    </v-col>
    <v-col cols="6">
     <BaseFieldLabel required label="Input type" />
     <validation-provider v-slot="{ errors }" name="field input type" rules="required">
      <v-select
       :outlined="isDark"
       :solo="!isDark"
       v-model="selectedComponentFormField.inputType"
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
  <base-dialog-icons v-if="dialogIcons" :icon="componentIcon" v-model="dialogIcons" />
 </div>
</template>

<script>
import { store } from "@/store";
import { sync, get } from "vuex-pathify";
export default {
 name: "ComponentsEditViewsFormFieldsTabsBasic",
 data() {
  return {
   dialogIcons: false,
   inputTypes: [
    { value: "text", text: "Text" },
    { value: "number", text: "Number" },
    { value: "password", text: "Password" },
    { value: "range", text: "Range" },
    { value: "color", text: "Color" },
    { value: "email", text: "Email" },
    { value: "phone", text: "Phone" }
   ]
  };
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("validationStates", ["componentsEditFormFieldsBasicTab"]),
  ...get("componentManagement", ["selectedComponentFormField"]),

  componentIcon() {
   if (!this.selectedComponentFormField) return;
   return this.selectedComponentFormField.icon;
  }
 },

 methods: {
  setInvalid(invalid, field) {
   store.set(`validationStates/componentsEditFormFieldsBasicTab@${field}`, invalid);
  }
 }
};
</script>
