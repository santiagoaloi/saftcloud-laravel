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
    if (response.data.status) {
     axios.defaults.headers.common["authorization"] = `Bearer ${response.data.data.token}`;
     commit("session", response.data.data);
     router.push("/desktop");
     return true;
    } else {
     return false;
    }
   })
   .catch(error => {
    // console.log({ ...error });
    return false;
   });
 },

 logout({ commit }, data) {
  return axios
   .post("api/logout", data)
   .then(response => {
    if (response.data.status) {
     commit("session", {});
     router.push("/login");
     axios.defaults.headers.common["authorization"] = "";
     return true;
    } else {
     return false;
    }
   })
   .catch(error => {
    // console.log({ ...error });
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
