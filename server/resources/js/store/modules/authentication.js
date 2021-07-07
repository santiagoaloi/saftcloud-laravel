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
  return axios
   .post("api/login", data)
   .then(response => {
    if (response.status === 200) {
     commit("session", response.data.data);
     axios.defaults.headers.common["authorization"] = `Bearer ${response.data.data.token}`;
     router.push("/components");
     return true;
    } else {
     return false;
    }
   })
   .catch(_ => {
    return false;
   });
 },

 logout({ commit }, data) {
  return axios
   .post("api/logout", data)
   .then(response => {
    if (response.status === 200) {
     commit("session", {});
     router.push("/login");
     return true;
    } else {
     commit("session", {});
     router.push("/login");
     return false;
    }
   })
   .catch(_ => {
    commit("session", {});
    router.push("/login");
    return false;
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
