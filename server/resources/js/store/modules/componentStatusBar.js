import { make } from "vuex-pathify";
import { ACTIVE, ALL, INACTIVE, MODULAR, STARRED, NAVIGATION } from "../constants/statusBarConstants";

const state = {
 statusMessages: {
  all: ALL,
  active: ACTIVE,
  starred: STARRED,
  modular: MODULAR,
  inactive: INACTIVE,
  navigation: NAVIGATION
 }
};
const mutations = make.mutations(state);

const getters = {
 // * returns the status bar message based on the active status tab selected.
 statusBarValue: (state, __, ___, rootGetters) => {
  const activeTabName = rootGetters["componentManagement/activeComponentTabName"];
  return state.statusMessages[activeTabName];
 }
};

const actions = {
 ...make.actions(state)
};

export default {
 namespaced: true,
 state,
 mutations,
 actions,
 getters
};
