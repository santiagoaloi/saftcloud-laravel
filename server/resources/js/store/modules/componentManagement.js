// Utilities
import { make } from "vuex-pathify";

const state = {
  componentCardGroup: 0,
  allComponents: [],
  allGroups: []
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
