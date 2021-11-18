import { make } from 'vuex-pathify';

const initialState = () => ({ events: [] });

const state = initialState();
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
