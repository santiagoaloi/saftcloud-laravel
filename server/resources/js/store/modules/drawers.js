// Utilities
import { make } from "vuex-pathify";

const state = {
  secureDefaultDrawer: true,
  secureComponentDrawer: false
};

const mutations = make.mutations(state);
const actions = {};
const getters = {};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
};
