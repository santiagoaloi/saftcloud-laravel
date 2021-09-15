<template>
 <baseDialog
  v-model="dialogCapability"
  title="Add capability"
  persistent
  max-width="900"
  @save="validateCapabilitiesForm()"
  @close="dialogCapability = false"
  icon="mdi-plus"
 >
  <ValidationObserver ref="createCapabilityForm" slim>
   <v-row>
    <v-col cols="12" lg="6">
     <baseFieldLabel required label="Capability name" />
     <validation-provider v-slot="{ errors, reset }" name="Capability name" rules="alpha|required">
      <v-text-field
       :prefix="`${selectedComponent.name}.`"
       v-model="capability.name"
       spellcheck="false"
       solo
       prepend-inner-icon="mdi-comment"
       counter
       maxlength="20"
       :color="isDark ? '#208ad6' : 'grey'"
       :background-color="isDark ? '#28292b' : 'white'"
       :error="errors.length > 0"
       :outlined="isDark"
       @keydown.enter.prevent="validateComponentForm()"
       :error-messages="errors[0]"
       @focus="reset"
       @input="reset"
       @blur="reset"
      />
     </validation-provider>
    </v-col>

    <v-col cols="12" lg="12">
     <baseFieldLabel label="Capability description" />
     <v-textarea
      v-model="capability.description"
      spellcheck="false"
      prepend-inner-icon="mdi-file"
      label
      solo
      :rows="4"
      :color="isDark ? '#208ad6' : 'grey'"
      :background-color="isDark ? '#28292b' : 'white'"
      :outlined="isDark"
     />
    </v-col>
   </v-row>
  </ValidationObserver>
 </baseDialog>
</template>
<script>
import { sync, call, get } from "vuex-pathify";
export default {
 name: "DialogCapabilities",

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["dialogCapability", "capability", "editingCapability"]),
  ...get("componentManagement", ["selectedComponent"]),

  addPrefixToName() {
   return `Test.${this.capability.name}`;
  }
 },

 methods: {
  ...call("componentManagement/*"),

  validateCapabilitiesForm() {
   this.$refs.createCapabilityForm.validate().then(validated => {
    if (validated) {
     let prefixed = { name: this.addPrefixToName, description: this.capability.description };
     let prefixedWithId = { name: this.addPrefixToName, description: this.capability.description, id: this.capability.id };

     if (this.editingCapability) {
      this.editCapabilitySaveChanges(prefixedWithId).then(edited => {
       if (edited) {
        this.dialogCapability = false;
        this.capability = {};
        this.editingCapability = false;
       }
      });
     } else {
      this.createCapability(prefixed).then(created => {
       if (created) {
        this.selectedComponent.capabilities.push(prefixed);
        this.dialogCapability = false;
        this.capability = {};
       }
      });
     }
    }
   });
  }
 }
};
</script>
