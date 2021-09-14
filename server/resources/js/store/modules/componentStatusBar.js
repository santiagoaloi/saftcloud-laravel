import { make } from "vuex-pathify";
import * as status from "../constants/statusBarConstants";

const state = {
 statusMessages: {
  all: status.ALL,
  active: status.ACTIVE,
  starred: status.STARRED,
  modular: status.MODULAR,
  inactive: status.INACTIVE,
  navigation: status.NAVIGATION
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
