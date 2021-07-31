<template>
 <div>
  <v-container :style="'min-height:' + (screenHeight - $vuetify.application.top) + 'px;'" class="fill-height">
   <v-row
    data-aos="fade"
    data-aos-anchor-placement="center-bottom"
    data-aos-delay="300"
    data-aos-once="true"
    data-aos-easing="linear"
    data-aos-duration="400"
   >
    <v-col cols="12" lg="6">
     <v-sheet color="white" class="text-center" height="400px">
      <v-scroll-x-transition hide-on-leave>
       <div v-if="step === 0">
        <v-card-text>
         <p class="display-1 text--primary">Verify your new account</p>
         <div class="text-h6 text-lg-h5 mt-5 mb-5">
          We've sent you a verification code to abc123@gmail.com
         </div>
         <ValidationObserver ref="step0" slim>
          <v-row justify="center">
           <v-col sm="6">
            <span>Account</span>
            <v-text-field disabled v-model="account" solo hide-details></v-text-field>
           </v-col>
           <v-col sm="6">
            <span>Verification Code</span>
            <validation-provider v-slot="{ errors }" name="token" rules="required">
             <v-text-field
              v-model="token"
              solo
              hide-details
              @keydown.enter.prevent="nextStep(1)"
              :background-color="errors.length ? '#faebeb' : ''"
             ></v-text-field>
            </validation-provider>
           </v-col>
          </v-row>
         </ValidationObserver>
        </v-card-text>
        <v-btn class="mx-1" @click="nextStep(1)" large color="grey lighten-2">Send verification code again</v-btn>
        <v-btn class="mx-1" @click="nextStep(1)" large color="primary">Verify my account</v-btn>
       </div>
      </v-scroll-x-transition>

      <!-- STEP 1 -->
      <v-scroll-x-transition hide-on-leave>
       <div v-if="step === 1">
        <v-card-text>
         <p class="display-1 text--primary">Create a password</p>
         <div class="text-h6 text-lg-h5 mt-5 mb-5">
          You're almost there! - Once you create a password for your account, you will be re-directed to your brand new application admin dashboard.
         </div>
         <ValidationObserver ref="step0" slim>
          <v-row justify="center">
           <v-col sm="12">
            <span>Account email</span>
            <v-text-field disabled v-model="accountEmail" solo hide-details></v-text-field>
           </v-col>
           <v-col sm="6">
            <span>Password</span>
            <validation-provider v-slot="{ errors }" name="account password" rules="required">
             <v-text-field
              type="password"
              solo
              hide-details
              @keydown.enter.prevent="nextStep(1)"
              :background-color="errors.length ? '#faebeb' : ''"
             ></v-text-field>
            </validation-provider> </v-col
           ><v-col sm="6">
            <span>Repeat password</span>
            <validation-provider v-slot="{ errors }" name="account password repeat" rules="required">
             <v-text-field
              type="password"
              solo
              hide-details
              @keydown.enter.prevent="nextStep(1)"
              :background-color="errors.length ? '#faebeb' : ''"
             ></v-text-field>
            </validation-provider>
           </v-col>
          </v-row>
         </ValidationObserver>
        </v-card-text>

        <v-btn class="mx-1" @click="nextStep(1)" large color="primary">Login</v-btn>
       </div>
      </v-scroll-x-transition>
     </v-sheet>
    </v-col>
    <!-- 
        <v-col cols="12" lg="6">
          <v-img
            :src="require('@/assets/images/verify.svg')"
            max-height="480"
          ></v-img>
        </v-col> -->
   </v-row>
  </v-container>
 </div>
</template>

<script>
import globalMixin from "@/mixins/globalMixin";
import filterFunctionsMixin from "@/mixins/filterFunctions";

import axios from "axios";
export default {
 name: "VerifyAccount",
 mixins: [globalMixin, filterFunctionsMixin],

 props: {
  value: {
   type: [Boolean],
   default: false
  }
 },
 data() {
  return {
   account: this.$route.query.account,
   token: this.$route.query.token,
   table: this.$route.query.table,
   controller: "Signup",
   step: 0,
   accountEmail: "facu.ft@gmail.com"
  };
 },

 mounted() {
  this.getCountryPhoneCodes();
 },

 methods: {
  nextStep(nextStep) {
   //Fist step
   if (this.step == 0) {
    this.$refs.step0.validate().then(success => {
     if (success) {
      this.step = nextStep;
     }
    });
   }
  },

  getCountryPhoneCodes() {
   axios.get(`${this.controller}/getCountryPhoneCodes`).then(response => {
    if (response.status === 200) {
     this.countryCodes = response.data.data;
    }
   });
  },

  accountCreation() {
   let post = {
    newAccount: this.signupForm
   };
   axios.post(`${this.controller}/accountCreation`, post).then(response => {
    if (response.status === 200) {
     this.$router.push("/login");
    }
   });
  }
 }
};
</script>
