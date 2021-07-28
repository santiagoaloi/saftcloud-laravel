<template>
 <v-fade-transition hide-on-leave>
  <component :is="layout"> </component>
 </v-fade-transition>
</template>

<script>
import config from "./configs";
import { sync } from "vuex-pathify";
import axios from "axios";

export default {
 name: "AppVue",
 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("authentication", ["session"]),

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

 created() {
  window.eventBus = this;
  window.eventBus.$on("BUS_BUILD_ROUTES", () => {
   this.buildRoutes();
  });
 },

 mounted() {
  this.buildRoutes();
 },

 methods: {
  buildRoutes() {
   if (this.session.token) {
    axios.get("/api/getComponentNames/").then(response => {
     if (response.status === 200) {
      const components = response.data.components;

      // Dummy component to avoid webpack error about not finding the path.
      if (!components.length) {
       components.push("Blank");
      }
      for (const component of components) {
       this.$router.addRoute({
        path: `/${component}`,
        name: component,
        meta: { layout: "secure_layout", title: "Hello" },
        component: () => import(`./views/Protected/${component}/${component}.vue`)
       });
      }
     }
    });
   }
  }
 }
};
</script>
