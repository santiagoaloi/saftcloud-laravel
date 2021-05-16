// Utilities
import { make } from "vuex-pathify";
import axios from "axios";

const state = {};
const mutations = make.mutations(state);

const actions = {
  ...make.actions(state),

  login({ state }, data) {
    axios.post("api/login", data).then(response => {
      console.log(response);
    });
  }
};
const getters = {};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
};
