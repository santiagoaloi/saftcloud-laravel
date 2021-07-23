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
 },

 mounted() {
  this.buildRoutes();
 },

 methods: {
  buildRoutes() {
   let post = { entity_id: 1, role_id: 1, email: "facu.ft@gmail.com" };
   axios.post("/api/testFunction/", post).then(response => {
    if (response.status === 200) {
     const components = response.data.components;
     for (const component of components) {
      this.$router.addRoute({
       path: `/${component}`,
       name: component,
       meta: { layout: "secure_layout" },
       component: () => import(`./views/Protected/${component}/${component}.vue`)
      });
     }
    }
   });
  }
 }
};
</script>
