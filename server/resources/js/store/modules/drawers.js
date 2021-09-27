// Utilities
import { make } from 'vuex-pathify';

const state = {
  secureDefaultDrawer: true,
  secureComponentDrawer: false,
  secureAccountsDrawer: false,
};

const mutations = make.mutations(state);

export default {
  namespaced: true,
  state,
  mutations,
};
