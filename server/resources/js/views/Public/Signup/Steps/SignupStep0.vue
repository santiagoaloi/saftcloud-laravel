<template>
 <div>
  <v-card-text>
   <h2 class="text--primary mb-5">Hi {{ signupForm.name }}, nice to meet you!</h2>
   <ValidationObserver ref="step0" slim>
    <v-row>
     <v-col sm="6">
      <baseFieldLabel label="Name" />
      <validation-provider v-slot="{ errors }" name="First name" rules="required">
       <v-text-field
        autofocus
        v-model="signupForm.name"
        solo
        hide-details
        @keydown.enter.prevent="validateAndProceed()"
        prepend-inner-icon="mdi-account"
        :outlined="isDark"
        :color="isDark ? '#208ad6' : 'grey'"
        :background-color="isDark ? '#28292b' : 'grey lighten-4'"
        :error="errors.length > 0"
       ></v-text-field>
      </validation-provider>
     </v-col>
     <v-col sm="6">
      <baseFieldLabel label="Last name" />
      <validation-provider v-slot="{ errors }" name="Last name" rules="required">
       <v-text-field
        v-model="signupForm.lastname"
        solo
        hide-details
        @keydown.enter.prevent="validateAndProceed()"
        prepend-inner-icon="mdi-account"
        :outlined="isDark"
        :color="isDark ? '#208ad6' : 'grey'"
        :background-color="isDark ? '#28292b' : 'grey lighten-4'"
        :error="errors.length > 0"
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
   this.$refs.step0.validate().then(success => {
    if (success) {
     this.step++;
    }
   });
  }
 }
};
</script>
