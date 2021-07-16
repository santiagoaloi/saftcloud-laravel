// Vue
import Vue from "vue";
import Vuex from "vuex";
import pathify from "@/plugins/vuex-pathify";

import createPersistedState from "vuex-persistedstate";
import SecureLS from "secure-ls";
let ls = new SecureLS({ isCompression: false });

// Modules
import * as modules from "./modules";

Vue.use(Vuex);

export const store = new Vuex.Store({
 plugins: [
  //   createMultiTabState(),
  createPersistedState({
   storage: {
    getItem: key => ls.get(key),
    setItem: (key, value) => ls.set(key, value),
    removeItem: key => ls.remove(key)
   },
   // Persist the following vuex modules.
   // If left empty, all modules are persisted.
   paths: ["authentication", "theme.isDark", "signup", "componentManagement", "drawers"]
  }),
  pathify.plugin
 ],
 modules
});
