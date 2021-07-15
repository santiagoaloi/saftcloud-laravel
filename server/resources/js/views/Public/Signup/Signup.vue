<template>
 <div>
  <v-container class="fill-height">
   <signup-alert />
   <v-card width="100%">
    <v-row justify="center" class="my-4 mx-1">
     <v-col class="text-center" cols="12" lg="6">
      <steps />
     </v-col>
     <v-col cols="12" lg="6">
      <v-list two-line flat>
       <v-list-item>
        <v-list-item-avatar>
         <v-icon> mdi-check</v-icon>
        </v-list-item-avatar>
        <v-list-item-content>
         <v-list-item-title>Notifications</v-list-item-title>
         <v-list-item-subtitle>Allow notifications</v-list-item-subtitle>
        </v-list-item-content>
       </v-list-item>
      </v-list>
     </v-col>
    </v-row>
   </v-card>
   <Faq />
  </v-container>
  <vue-diagonal :deg="-7" background="linear-gradient(331deg, rgba(101, 235, 235, 1) 0%, rgba(54, 49, 125, 1) 50%)" space-after space-before>
   <Pricing />
  </vue-diagonal>
 </div>
</template>

<script>
import { sync, get } from "vuex-pathify";
import Pricing from "@/components/landing/Pricing.vue";
import Faq from "@/components/landing/Faq.vue";
import axios from "axios";
export default {
 name: "Signup",
 components: {
  steps: () => import(/* webpackChunkName: 'signup-steps' */ "./Steps/Steps"),
  signupAlert: () => import(/* webpackChunkName: 'signup-steps-alert' */ "./Steps/SignupAlert"),

  Pricing,
  Faq
 },
 props: {
  value: {
   type: [Boolean],
   default: false
  }
 },

 data() {
  return {};
 },

 computed: {
  ...sync("theme", ["isDark"])
 },

 mounted() {},

 methods: {}
};
</script>
