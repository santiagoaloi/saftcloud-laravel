import { make } from 'vuex-pathify';

const state = {
  dialogComponentLoader: false,
  logoutLoader: false,
};

const mutations = make.mutations(state);
const getters = {};

const actions = {
  ...make.actions(state),
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
