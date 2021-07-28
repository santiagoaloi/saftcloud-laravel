<template>
 <v-scroll-x-transition hide-on-leave>
  <component :is="`step${step}`" />
 </v-scroll-x-transition>
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
 computed: {
  ...sync("signup", ["step"])
 }
};
</script>
