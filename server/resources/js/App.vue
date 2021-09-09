<template>
 <keep-alive>
  <component :is="layout" />
 </keep-alive>
</template>

<script>
import axios from "axios";
import config from "./configs";
import { store } from "@/store";
import { sync } from "vuex-pathify";
import { router, resetRouter } from "@/router";
import auth from "@/util/auth";

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
  // ** Define event bus
  window.eventBus = this;

  // ** Build routes on request.
  window.eventBus.$on("BUS_BUILD_ROUTES", () => {
   this.buildRoutes();
  });
 },

 mounted() {
  // * Waits for auth util to be ready.
  setTimeout(() => {
   if (auth.loggedIn()) {
    this.buildRoutes();
   }
  }, 500);
 },

 methods: {
  buildRoutes() {
   // * Clear routes and routes matcher.
   resetRouter();

   // * Waits for indexeddb to be ready.
   setTimeout(() => {
    axios.get("/api/getComponentNames/").then(response => {
     if (response.status === 200) {
      const components = response.data.components;

      // * Dummy component to avoid webpack error about not finding the path.
      if (!components.length) {
       components.push("Blank");
      }

      // * Add new routes
      for (const component of components) {
       this.$router.addRoute({
        path: `/${component.name}`,
        name: `/${component.name}`,
        meta: { layout: "secure_layout", title: component.title },
        component: () => import(`./views/Protected/${component.name}/${component.name}.vue`)
       });
      }
     }
    });
   }, 500);
  }
 }
};
</script>
