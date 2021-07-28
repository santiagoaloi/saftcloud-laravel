// Vue
import Vue from "vue";
import Vuex from "vuex";
import pathify from "@/plugins/vuex-pathify";
import VuexPersist from "vuex-persist";
import localforage from "localforage";

// Modules
import * as modules from "./modules";

Vue.use(Vuex);

const vuexLocal = new VuexPersist({
 key: "vuex-store",
 storage: localforage,
 asyncStorage: true
});

export const store = new Vuex.Store({
 modules,
 plugins: [pathify.plugin, vuexLocal.plugin]
});
