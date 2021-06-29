<template>
 <v-fade-transition hide-on-leave>
  <component :is="layout"> </component>
 </v-fade-transition>
</template>

<script>
import config from "./configs";
import { sync } from "vuex-pathify";

export default {
 name: "AppVue",

 computed: {
  ...sync("theme", ["isDark"]),

  layout() {
   return this.$route.meta.layout;
  }
 },

 watch: {
  isDark: {
   immediate: true,
   handler(val) {
    this.$vuetify.theme.dark = val;
   }
  }
 },

 head: {
  link: [...config.icons.map(href => ({ rel: "stylesheet", href }))]
 }
};
</script>
