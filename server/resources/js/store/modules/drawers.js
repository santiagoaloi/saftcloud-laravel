// Utilities
import { make } from 'vuex-pathify';

const state = {
  secureDefaultDrawer: true,
  secureEntitiesDrawer: false,
  secureComponentDrawer: false,
  secureComponentDrawerBranch: false,
};

const mutations = make.mutations(state);

export default {
  namespaced: true,
  state,
  mutations,
};
