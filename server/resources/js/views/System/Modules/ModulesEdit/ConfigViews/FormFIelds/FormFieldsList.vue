<template>
  <fragment>
    <v-text-field
      v-model="searchFields"
      hide-details
      label="Search"
      prepend-inner-icon="mdi-magnify"
      autocomplete="off"
      autocorrect="off"
      autocapitalize="off"
      spellcheck="false"
      solo
      class="mb-2"
      :color="isDark ? '#208ad6' : 'grey'"
      :background-color="isDark ? '#28292b' : 'white'"
      :outlined="isDark"
    />
    <v-list-item-group v-model="selectedFieldItemGroup" mandatory>
      <v-list dense class="fieldListHeight">
        <draggable
          v-model="selectedModule.config.form_fields"
          :delay="100"
          :delay-on-touch-only="true"
          :options="{ animation: 500 }"
          ghost-class="ghost"
          handle=".my-handle"
        >
          <transition-group appear name="slide-y-transition">
            <v-list-item
              v-for="(item, i) in displayEnabledFormFieldsOnly ? filteredSelectedFields : filteredFormFields"
              :key="i + i"
              :disabled="hasValidationErrors"
              dense
              two-line
              :ripple="false"
              active-class="primary--text text--lighten-2"
              @click="setActiveField(item.field)"
            >
              <v-list-item-action v-if="!displayEnabledFormFieldsOnly">
                <v-switch v-model="item.displayField" :ripple="false" color="accent lighten-1" />
              </v-list-item-action>

              <v-list-item-content>
                <v-list-item-title> {{ item.label }}</v-list-item-title>

                <v-list-item-subtitle class="mt-2">
                  {{ item.field }}
                </v-list-item-subtitle>
              </v-list-item-content>

              <v-list-item-action>
                <v-chip dark label small>
                  {{ item.fieldType }}
                </v-chip>
              </v-list-item-action>

              <v-icon v-if="!displayEnabledFormFieldsOnly" class="drag my-handle"> mdi-drag-vertical </v-icon>
            </v-list-item>
          </transition-group>
        </draggable>
      </v-list>
    </v-list-item-group>
  </fragment>
</template>

<script>
  import draggable from 'vuedraggable';
  import { sync, get, call } from 'vuex-pathify';

  export default {
    name: 'ModulesEditViewsFormFieldsList',
    components: {
      draggable,
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('modulesManagement', ['searchFields', 'displayEnabledFormFieldsOnly', 'selectedFieldItemGroup']),
      ...get('modulesManagement', ['selectedModule', 'filteredFormFields', 'filteredSelectedFields', 'hasValidationErrors']),
    },

    mounted() {
      this.setActiveField(this.filteredFormFields[0].field);
    },

    methods: {
      ...call('modulesManagement/*'),
    },
  };
</script>
<style scoped>
  .fieldListHeight {
    height: calc(100vh - 260px);
    overflow-y: auto;
  }
</style>
