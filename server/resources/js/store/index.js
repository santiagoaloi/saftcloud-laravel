// Vue
import Vue from "vue";
import Vuex from "vuex";
import pathify from "@/plugins/vuex-pathify";
import createMultiTabState from "vuex-multi-tab-state";

// pathify options
pathify.options.mapping = "simple";
pathify.options.strict = true;

import createPersistedState from "vuex-persistedstate";
// import SecureLS from "secure-ls";
// var ls = new SecureLS({ isCompression: false });

// Modules
import * as modules from "./modules";

Vue.use(Vuex);

export const store = new Vuex.Store({
 plugins: [
  createMultiTabState(),
  createPersistedState({
   //    storage: {
   //     getItem: key => ls.get(key),
   //     setItem: (key, value) => ls.set(key, value),
   //     removeItem: key => ls.remove(key)
   //    },
   // Persist the following vuex variables.
   paths: ["authentication", "theme.isDark", "signup", "componentManagement", "drawers"]
  }),
  pathify.plugin
 ],
 modules
});
