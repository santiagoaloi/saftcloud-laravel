// Utilities
import { make } from "vuex-pathify";

const state = {
 isDark: false,
 icons: []
};

const mutations = make.mutations(state);
const getters = {};

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
