<template>
  <div>
    <v-card-text>
      <ValidationObserver ref="step0" slim>
        <v-row>
          <v-col sm="6">
            <baseFieldLabel label="Name" />
            <validation-provider v-slot="{ errors, reset }" name="first name" rules="required">
              <v-text-field
                v-model="signupForm.name"
                counter
                maxlength="30"
                autofocus
                solo
                prepend-inner-icon="mdi-account"
                :outlined="isDark"
                :color="isDark ? '#208ad6' : 'grey'"
                :error="errors.length > 0"
                height="55"
                @keydown.enter.prevent="validateAndProceed()"
                @focus="reset"
                @input="reset"
                @blur="reset"
              />
            </validation-provider>
          </v-col>
          <v-col sm="6">
            <baseFieldLabel label="Last name" />
            <validation-provider v-slot="{ errors, reset }" name="last name" rules="required">
              <v-text-field
                v-model="signupForm.lastname"
                height="55"
                counter
                maxlength="30"
                solo
                prepend-inner-icon="mdi-account"
                :outlined="isDark"
                :color="isDark ? '#208ad6' : 'grey'"
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
    <v-btn large color="primary" @click="validateAndProceed()"> Continue </v-btn>
  </div>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'SignupStep0',
    computed: {
      ...sync('theme', ['isDark']),
      ...sync('signup', ['signupForm', 'step']),
    },

    methods: {
      validateAndProceed() {
        this.$refs.step0.validate().then((success) => {
          if (success) {
            this.step += 1;
          }
        });
      },
    },
  };
</script>
