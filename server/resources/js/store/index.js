// Vue
import Vue from "vue";
import Vuex from "vuex";
import pathify from "vuex-pathify";

// options
pathify.options.mapping = "simple";
pathify.options.strict = true;

// Modules
import * as modules from "./modules";

Vue.use(Vuex);
export const store = new Vuex.Store({
  plugins: [pathify.plugin],
  modules
});
