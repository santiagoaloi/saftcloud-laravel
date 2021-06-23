// Utilities
import { make } from "vuex-pathify";

const state = {
 isDark: false
};

const mutations = make.mutations(state);

const actions = {
 ...make.actions(state)
};

export default {
 namespaced: true,
 state,
 mutations,
 actions
};