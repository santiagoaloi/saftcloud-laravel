<template>
  <baseDialog
    v-model="dialogComponent"
    title="Add new component"
    persistent
    max-width="900"
    icon="mdi-plus"
    :loading="loading"
    @save="validateComponentForm()"
    @close="dialogComponent = !dialogComponent"
  >
    <ValidationObserver ref="createComponentForm" slim>
      <v-row>
        <v-col cols="12" lg="6">
          <baseFieldLabel required label="Group" />
          <validation-provider v-slot="{ errors, reset }" name="component group" rules="required">
            <v-autocomplete
              v-model="componentSettings.component_group_id"
              spellcheck="false"
              prepend-inner-icon="mdi-folder-outline"
              :items="allGroups"
              :maxlength="20"
              item-value="id"
              item-text="name"
              hide-selected
              hide-no-data
              solo
              :color="isDark ? '#208ad6' : 'grey'"
              :background-color="isDark ? '#28292b' : 'white'"
              :error-messages="errors[0]"
              :error="errors.length > 0"
              :menu-props="{
                transition: 'slide-y-transition',
                closeOnContentClick: true,
              }"
              :outlined="isDark"
              @focus="reset"
              @input="reset"
              @blur="reset"
            >
              <template #item="{ item, on }">
                <v-list-item :ripple="false" v-on="on">
                  <v-list-item-avatar>
                    <v-icon>mdi-folder-outline</v-icon>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-title> {{ item.name }} </v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </template>
            </v-autocomplete>
          </validation-provider>
        </v-col>

        <v-col cols="12" lg="6">
          <baseFieldLabel required label="Component title" />
          <validation-provider v-slot="{ errors, reset }" name="component title" rules="required">
            <v-text-field
              v-model="componentSettings.title"
              spellcheck="false"
              solo
              :outlined="isDark"
              prepend-inner-icon="mdi-comment"
              counter
              maxlength="20"
              :color="isDark ? '#208ad6' : 'grey'"
              :background-color="isDark ? '#28292b' : 'white'"
              :error="errors.length > 0"
              :error-messages="errors[0]"
              @focus="reset"
              @input="reset"
              @blur="reset"
            />
          </validation-provider>
        </v-col>

        <v-col cols="12" lg="6">
          <baseFieldLabel required label="Component name" />
          <validation-provider
            v-slot="{ errors, reset }"
            name="component name"
            rules="alpha|required"
          >
            <v-text-field
              v-model="componentSettings.name"
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
              @focus="reset"
              @input="reset"
              @blur="reset"
            />
          </validation-provider>
        </v-col>

        <v-col cols="12" lg="6">
          <baseFieldLabel required label="Database table" />
          <validation-provider v-slot="{ errors, reset }" name="component table" rules="required">
            <v-autocomplete
              v-model="componentSettings.table"
              :outlined="isDark"
              spellcheck="false"
              :menu-props="{
                transition: 'slide-y-transition',
              }"
              solo
              prepend-inner-icon="mdi-table"
              :items="dbTables"
              :item-color="isDark ? 'indigo lighten-3' : 'primary'"
              :color="isDark ? '#208ad6' : 'grey'"
              :background-color="isDark ? '#28292b' : 'white'"
              :error-messages="errors[0]"
              :error="errors.length > 0"
              @focus="reset"
              @input="reset"
              @blur="reset"
            >
              <template #item="data">
                <v-list-item-avatar>
                  <v-icon small> mdi-table </v-icon>
                </v-list-item-avatar>
                <v-list-item-content>
                  <v-list-item-title v-html="data.item" />
                </v-list-item-content>
              </template>
            </v-autocomplete>
          </validation-provider>
        </v-col>
        <v-col cols="12" lg="12">
          <baseFieldLabel label="Component description / notes" />
          <v-textarea
            v-model="componentSettings.note"
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
  import { sync, call } from 'vuex-pathify';

  export default {
    name: 'DialogComponent',

    data() {
      return {
        loading: false,
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('componentManagement', [
        'allGroups',
        'dialogComponent',
        'componentSettings',
        'dbTables',
        'groupName',
      ]),
    },

    created() {
      this.getDbTables();
    },

    methods: {
      ...call('componentManagement/*'),
      ...call('snackbar/*'),

      async validateComponentForm() {
        try {
          this.loading = true;
          const validated = await this.$refs.createComponentForm.validate();

          if (validated) {
            const created = await this.createComponent();
            if (created) {
              this.loading = false;
              window.eventBus.$emit('BUS_BUILD_ROUTES');
            }
          } else {
            this.loading = false;
          }
        } catch (error) {
          this.loading = false;
          this.snackbarError('There was an error saving');
        }
      },
    },
  };
</script>
