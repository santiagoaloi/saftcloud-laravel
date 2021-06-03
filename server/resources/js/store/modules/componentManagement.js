// Utilities
import { make } from "vuex-pathify";

const state = {
 activeStatusTab: 0,
 componentCardGroup: 0,
 allComponents: [],
 selectedComponent: [],
 allGroups: [],
 selectedComponentGroups: [],
 unsavedChanges: false
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
