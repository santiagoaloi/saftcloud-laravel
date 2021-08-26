<template>
 <div>
  <v-card-text>
   <h2 class="text--primary mb-5">Hi {{ signupForm.name }}, nice to meet you!</h2>
   <ValidationObserver ref="step0" slim>
    <v-row>
     <v-col sm="6">
      <baseFieldLabel label="Name" />
      <validation-provider v-slot="{ errors, reset }" name="first name" rules="required">
       <v-text-field
        counter
        maxlength="30"
        autofocus
        v-model="signupForm.name"
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
       ></v-text-field>
      </validation-provider>
     </v-col>
     <v-col sm="6">
      <baseFieldLabel label="Last name" />
      <validation-provider v-slot="{ errors, reset }" name="last name" rules="required">
       <v-text-field
        counter
        maxlength="30"
        v-model="signupForm.lastname"
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
       ></v-text-field>
      </validation-provider>
     </v-col>
    </v-row>
   </ValidationObserver>
  </v-card-text>
  <v-btn @click="validateAndProceed()" large color="primary">Continue</v-btn>
 </div>
</template>

<script>
import { sync, get } from "vuex-pathify";
export default {
 name: "SignupStep0",
 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("signup", ["signupForm", "step"])
 },

 methods: {
  validateAndProceed() {
   this.$refs.step0.validate().then(success => {
    if (success) {
     this.step++;
    }
   });
  }
 }
};
</script>
