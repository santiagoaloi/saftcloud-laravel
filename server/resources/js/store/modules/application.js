import { make } from 'vuex-pathify';

const state = {
  search: '',
  isBooted: false,
  isContentLoaded: false,
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
