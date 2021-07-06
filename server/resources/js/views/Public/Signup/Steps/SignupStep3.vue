<template>
 <div>
  <v-card-text>
   <h2 class="text--primary mb-5">
    Define your parent account
   </h2>
   <ValidationObserver ref="step3" slim>
    <v-row justify="center">
     <v-col sm="6">
      <validation-provider v-slot="{ errors }" name="Company name" rules="required">
       <baseFieldLabel label="Account" />
       <v-text-field
        autofocus
        v-model="signupForm.companyName"
        hint="Oficial registed company name"
        solo
        hide-details
        @keydown.enter.prevent="validateAndProceed()"
        prepend-inner-icon="mdi-account"
        :outlined="isDark"
        :color="isDark ? '#208ad6' : 'grey'"
        :background-color="isDark ? 'grey darken-4' : 'grey lighten-4'"
        :error="errors.length"
       ></v-text-field>
      </validation-provider>
     </v-col>
     <v-col sm="6">
      <baseFieldLabel label="Company Alias" />
      <validation-provider v-slot="{ errors }" name="Company name alias" rules="required">
       <v-text-field
        v-model="signupForm.companyNameAlias"
        hint="Public company name alias"
        solo
        hide-details
        @keydown.enter.prevent="validateAndProceed()"
        prepend-inner-icon="mdi-account"
        :outlined="isDark"
        :color="isDark ? '#208ad6' : 'grey'"
        :background-color="isDark ? 'grey darken-4' : 'grey lighten-4'"
        :error="errors.length"
       ></v-text-field>
      </validation-provider>
     </v-col>
    </v-row>
   </ValidationObserver>
  </v-card-text>
  <v-btn dark class="mx-1" @click="step--" large color="grey darken-2">Back</v-btn>
  <v-btn @click="validateAndProceed()" large color="primary">Continue</v-btn>
 </div>
</template>

<script>
import { sync, get } from "vuex-pathify";
import CountryFlag from "vue-country-flag";

export default {
 name: "SignupStep3",
 components: {
  CountryFlag
 },
 data() {
  return {};
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("signup", ["signupForm", "step"])
 },

 mounted() {},

 methods: {
  validateAndProceed() {
   this.$refs.step3.validate().then(success => {
    if (success) {
     this.step++;
    }
   });
  }
 }
};
</script>
