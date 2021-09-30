<template>
  <div>
    <v-card-text>
      <h2 class="text--primary mb-5">Define your parent account</h2>
      <ValidationObserver ref="step3" slim>
        <v-row justify="center">
          <v-col sm="6">
            <validation-provider v-slot="{ errors, reset }" name="company name" rules="required">
              <baseFieldLabel label="Account" />
              <v-text-field
                v-model="signupForm.companyName"
                counter
                maxlength="25"
                autofocus
                hint="Oficial registed company name"
                solo
                prepend-inner-icon="mdi-account"
                :outlined="isDark"
                :color="isDark ? '#208ad6' : 'grey'"
                :background-color="isDark ? '#28292b' : 'white'"
                :error="errors.length > 0"
                @keydown.enter.prevent="validateAndProceed()"
                @focus="reset"
                @input="reset"
                @blur="reset"
              />
            </validation-provider>
          </v-col>
          <v-col sm="6">
            <baseFieldLabel label="Company Alias" />
            <validation-provider v-slot="{ errors, reset }" name="company alias" rules="required">
              <v-text-field
                v-model="signupForm.companyNameAlias"
                counter
                maxlength="25"
                hint="Public company name alias"
                solo
                prepend-inner-icon="mdi-account"
                :outlined="isDark"
                :color="isDark ? '#208ad6' : 'grey'"
                :background-color="isDark ? '#28292b' : 'white'"
                :error="errors.length > 0"
                @keydown.enter.prevent="validateAndProceed()"
                @focus="reset"
                @input="reset"
                @blur="reset"
              />
            </validation-provider>
          </v-col>
        </v-row>
      </ValidationObserver>
    </v-card-text>
    <v-btn dark class="mx-1" large color="grey darken-2" @click="step--"> Back </v-btn>
    <v-btn large color="primary" @click="validateAndProceed()"> Continue </v-btn>
  </div>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'SignupStep3',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('signup', ['signupForm', 'step']),
    },
    methods: {
      validateAndProceed() {
        this.$refs.step3.validate().then((success) => {
          if (success) {
            this.step++;
          }
        });
      },
    },
  };
</script>
