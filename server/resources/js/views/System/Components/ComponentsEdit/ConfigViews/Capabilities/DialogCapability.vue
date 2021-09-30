<template>
  <baseDialog
    v-model="dialogCapability"
    title="Add capability"
    persistent
    max-width="900"
    icon="mdi-plus"
    @save="validateCapabilitiesForm()"
    @close="close()"
  >
    <ValidationObserver ref="createCapabilityForm" slim>
      <v-row>
        <v-col cols="12" lg="6">
          <baseFieldLabel required label="Capability name" />
          <validation-provider v-slot="{ errors }" name="Capability name" rules="alpha|required">
            <v-text-field
              v-model="capability.name"
              :prefix="`${selectedComponent.name}.`"
              spellcheck="false"
              solo
              prepend-inner-icon="mdi-comment"
              counter
              maxlength="20"
              :color="isDark ? '#208ad6' : 'grey'"
              :background-color="isDark ? '#28292b' : 'white'"
              :error="errors.length > 0"
              :outlined="isDark"
              :error-messages="errors[0]"
            />
          </validation-provider>
        </v-col>

        <v-col cols="12" lg="12">
          <baseFieldLabel label="Capability description" />
          <validation-provider v-slot="{ errors }" name="Capability description" rules="required">
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
              :error="errors.length > 0"
              :error-messages="errors[0]"
            />
          </validation-provider>
        </v-col>
      </v-row>
    </ValidationObserver>
  </baseDialog>
</template>
<script>
  import { sync, call, get } from 'vuex-pathify';

  export default {
    name: 'DialogCapabilities',

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', ['dialogCapability', 'capability', 'editingCapability']),
      ...get('componentManagement', ['selectedComponent']),

      addPrefixToName() {
        return `${this.selectedComponent.name}.${this.capability.name}`;
      },
    },

    methods: {
      ...call('componentManagement/*'),

      close() {
        this.dialogCapability = false;
        this.editingCapability = false;
      },

      validateCapabilitiesForm() {
        this.$refs.createCapabilityForm.validate().then((validated) => {
          if (validated) {
            const newCapabilityPrefixed = {
              name: this.addPrefixToName,
              description: this.capability.description,
              id: this.capability.id,
            };
            const editedCapability = {
              name: this.capability.name,
              description: this.capability.description,
              id: this.capability.id,
            };

            if (this.editingCapability) {
              this.editCapabilitySaveChanges(editedCapability).then((edited) => {
                if (edited) {
                  this.dialogCapability = false;
                  this.capability.name = `${this.selectedComponent.name}.${this.capability.name}`;
                  this.editingCapability = false;
                }
              });
            } else {
              this.createCapability(newCapabilityPrefixed).then((created) => {
                if (created) {
                  this.selectedComponent.capabilities.push(newCapabilityPrefixed);
                  this.dialogCapability = false;
                  this.capability = {};
                }
              });
            }
          }
        });
      },
    },
  };
</script>
