// Utilities
import axios from "axios";
import router from "@/router";
import { make } from "vuex-pathify";

const state = {
  session: {}
};

const mutations = make.mutations(state);

const actions = {
  ...make.actions(state),

  login({ commit }, data) {
    axios.post("api/login", data).then(response => {
      commit("session", response.data);
      router.push("/desktop");
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