// Vue
import Vue from "vue";
import Vuex from "vuex";
import VuexPersist from "vuex-persist";
import pathify from "@/plugins/vuex-pathify";
import localforage from "localforage";

// All Vuex Modules
import * as modules from "./modules";

Vue.use(Vuex);
const vuexLocal = new VuexPersist({
 key: "vuex-store",
 storage: localforage,
 asyncStorage: true,
 reducer: state => ({
  theme: {
   isDark: state.theme.isDark
  },
  authentication: {
   ...state.authentication
  },
  componentManagement: {
   ...state.componentManagement
  }
 })
});

export const store = new Vuex.Store({
 modules,
 plugins: [pathify.plugin, vuexLocal.plugin]
});
