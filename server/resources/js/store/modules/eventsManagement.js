import { make } from 'vuex-pathify';

const state = {
  events: [],
};

const mutations = make.mutations(state);

const actions = {
  ...make.actions(state),
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
};
