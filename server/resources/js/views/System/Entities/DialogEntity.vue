<template>
  <baseDialog
    v-model="dialogEntity"
    :title="`Add new ${identityTypeButton}`"
    persistent
    max-width="900"
    icon="mdi-plus"
    :loading="loading"
    @save="validateEntity()"
    @close="dialogEntity = !dialogEntity"
  >
    <ValidationObserver ref="createEntityForm" slim>
      <v-row>
        <v-col v-for="(ent, key) in entity" :key="key" cols="12" lg="6">
          <baseFieldLabel required :label="key" />
          <validation-provider v-slot="{ errors, reset }" :name="key" rules="required">
            <v-text-field
              v-model="entity[key]"
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
      </v-row>
    </ValidationObserver>
  </baseDialog>
</template>
<script>
  import { sync, call } from 'vuex-pathify';
  import { store } from '@/store';

  export default {
    name: 'DialogEntity',

    data() {
      return {
        loading: false,
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('entitiesManagement', ['dialogEntity', 'user', 'role', 'identityTypeButton']),

      entity() {
        return this.identityTypeButton === 'User' ? this.user : this.role;
      },
    },

    methods: {
      ...call('entitiesManagement/*'),

      validateEntity() {
        this.loading = true;
        const identityMethodCreate =
          this.identityTypeButton === 'User' ? 'createUser' : 'createRole';
        const identityMethodGet = this.identityTypeButton === 'User' ? 'getUsers' : 'getRoles';
        this.$refs.createEntityForm.validate().then((validated) => {
          if (validated) {
            this[identityMethodCreate]()
              .then((created) => {
                if (created) {
                  this[identityMethodGet]();
                  this.loading = false;
                  this.dialogEntity = false;
                } else {
                  this.loading = false;
                }
              })
              .catch(() => {
                store.set('snackbar/value', true);
                store.set('snackbar/text', 'There was an error saving...');
                store.set('snackbar/color', 'pink darken-1');
                this.loading = false;
              });
          } else {
            this.loading = false;
          }
        });
      },
    },
  };
</script>
