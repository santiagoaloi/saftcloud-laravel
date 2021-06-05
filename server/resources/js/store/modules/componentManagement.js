// Utilities
import { make } from "vuex-pathify";
import axios from "axios";
import isEqual from "lodash/isEqual";
import isEmpty from "lodash/isEmpty";

const state = {
 allGroups: [],
 allComponents: [],
 unsavedChanges: false,
 activeStatusTab: 0,
 componentCardGroup: 0,
 dialogComponent: false,
 selectedComponent: {},
 selectedComponentGroups: [],
 numberOfFilteredComponents: 0,
 componentStatusTabs: [
  { name: "All", value: "all", icon: "mdi-all-inclusive", color: "" },
  { name: "Starred", value: "starred", icon: "mdi-star", color: "" },
  { name: "Active", value: "active", icon: "mdi-lightbulb-on", color: "blue darken-4" },
  { name: "Inactive", value: "inactive", icon: "mdi-lightbulb-on-outline", color: "black" },
  { name: "Modular", value: "modular", icon: "mdi-view-module", color: "" }
 ]
};

const mutations = make.mutations(state);

const getters = {
 hasUnsavedChanges: state => {
  if (!isEmpty(state.selectedComponent)) {
   const { origin, ...current } = state.selectedComponent;

   return !isEqual(origin, current);
  }
 }
};

const actions = {
 ...make.actions(state),

 getComponents({ commit }) {
  axios.get("api/showAllComponents").then(response => {
   if (response.data.status) {
    commit("allComponents", response.data.components);
   }
  });
 },

 getGroups({ commit }) {
  axios.get("api/showAllGroups").then(response => {
   if (response.data.status) {
    commit("allGroups", response.data.groups);
   }
  });
 }
};

export default {
 namespaced: true,
 state,
 mutations,
 actions,
 getters
};
