<template>
  <v-toolbar color="transparent" flat dense>
    <v-toolbar-title class="mr-5"> {{ availableFields }} fields </v-toolbar-title>

    <v-menu transition="fade-transition" offset-y nudge-top="-11">
      <template #activator="{ on, attrs }">
        <v-btn small depressed color="primary" dark v-bind="attrs" v-on="on">
          <v-icon left class="mr-2" small> mdi-tune </v-icon> Options
        </v-btn>
      </template>

      <v-list>
        <v-list-item dense @click="formFIeldsSwitch(true)">
          <v-list-item-action>
            <v-icon>mdi-expand-all-outline</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title> Select All</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-item dense @click="formFIeldsSwitch(false)">
          <v-list-item-action>
            <v-icon>mdi-collapse-all-outline</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title> Unselect All</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-divider />

        <v-list-item dense>
          <v-list-item-action>
            <v-icon>mdi-selection-search</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Show enabled ones only </v-list-item-title>
          </v-list-item-content>
          <v-list-item-action>
            <v-switch
              v-model="displayEnabledFormFieldsOnly"
              :color="isDark ? 'indigo lighten-3' : 'primary accent-1'"
              :ripple="false"
              @click.stop
            />
          </v-list-item-action>
        </v-list-item>
      </v-list>
    </v-menu>
  </v-toolbar>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'ModulesEditViewsFormFieldsToolbar',
    data: () => ({
      selectedFieldItem: 0,
    }),

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('modulesManagement', ['modulesEditSheet', 'displayEnabledFormFieldsOnly']),
      ...get('modulesManagement', ['selectedModule']),

      availableFields() {
        return this.selectedModule.config.form_fields.length;
      },
    },

    methods: {
      formFIeldsSwitch(value) {
        const fields = this.selectedModule.config.form_fields;
        for (const field of fields) field.displayField = value;
      },
    },
  };
</script>
