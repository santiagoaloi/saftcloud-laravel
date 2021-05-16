// Utilities
import { make } from "vuex-pathify";

const state = {
  action_text: "Close",
  action: "",
  color: "success",
  text: "",
  value: false
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
