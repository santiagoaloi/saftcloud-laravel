<template>
 <div>
  <v-scroll-x-transition hide-on-leave>
   <step0 v-if="step === 0" />
  </v-scroll-x-transition>

  <!-- STEP 1 -->
  <v-scroll-x-transition hide-on-leave>
   <step1 v-if="step === 1" />
  </v-scroll-x-transition>

  <!-- STEP 2 -->
  <v-scroll-x-transition hide-on-leave>
   <step2 v-if="step === 2" />
  </v-scroll-x-transition>

  <!-- STEP 3 -->
  <v-scroll-x-transition hide-on-leave>
   <step3 v-if="step === 3" />
  </v-scroll-x-transition>

  <!-- STEP 4 -->
  <v-scroll-x-transition hide-on-leave>
   <step4 v-if="step === 4" />
  </v-scroll-x-transition>
 </div>
</template>

<script>
import { sync, get } from "vuex-pathify";

export default {
 name: "SignupSteps",
 components: {
  step0: () => import(/* webpackChunkName: 'signup-step0' */ "./SignupStep0"),
  step1: () => import(/* webpackChunkName: 'signup-step1' */ "./SignupStep1"),
  step2: () => import(/* webpackChunkName: 'signup-step2' */ "./SignupStep2"),
  step3: () => import(/* webpackChunkName: 'signup-step3' */ "./SignupStep3"),
  step4: () => import(/* webpackChunkName: 'signup-step4' */ "./SignupStep4")
 },
 data() {
  return {};
 },
 computed: {
  ...sync("signup", ["step"])
 },
 mounted() {},

 methods: {}
};
</script>
