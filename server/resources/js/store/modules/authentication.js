// Utilities
import axios from "axios";
import router from "@/router";
import { make } from "vuex-pathify";
const axiosDefaults = require("axios/lib/defaults");

//Default validation states definitions (they should all have validation errors to false)
const getDefaultState = () => {
 return {
  session: {},
  activeBranch: undefined,
  dialogTImeoutWarning: false,
  hasSessionExpired: false
 };
};

const state = getDefaultState();

const mutations = make.mutations(state);

const actions = {
 ...make.actions(state),

 // Reset state to default values.
 resetState({ state }) {
  Object.assign(state, getDefaultState());
  console.log("authentication state reseted");
 },

 //Sends login form payload to backend.
 async login({ commit }, data) {
  return axios
   .post("api/login", data)
   .then(response => {
    if (response.status === 200) {
     commit("session", response.data.data);
     axiosDefaults.headers.common["Authorization"] = `Bearer ${response.data.data.token}`;
     return true;
    } else {
     return false;
    }
   })
   .catch(_ => {
    return false;
   });
 },

 //Logs out the user.
 logout({ dispatch }, data) {
  return axios
   .post("api/logout", data)
   .then(response => {
    if (response.status === 200) {
     axiosDefaults.headers.common["Authorization"] = undefined;
     dispatch("resetState");
     router.push("/login");
     return true;
    } else {
     dispatch("resetState");
     router.push("/login");
     return false;
    }
   })
   .catch(_ => {
    dispatch("resetState");
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
