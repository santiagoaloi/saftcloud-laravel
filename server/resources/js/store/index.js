// Vue
import Vue from 'vue';
import Vuex from 'vuex';

// libraries
import VuexPersist from 'vuex-persist';
import localforage from 'localforage';
import { omit } from 'lodash';
import pathify from '@/plugins/vuex-pathify';

// All Vuex Modules definned in ./modules/index.js
import * as modules from './modules';

// Blacklist module keys
const componentManagementFiltered = (module) => {
  const blackList = ['componentEditSheet'];
  return omit(module, blackList);
};

Vue.use(Vuex);
const vuexLocal = new VuexPersist({
  key: 'vuex-store',
  storage: localforage,
  asyncStorage: true,

  // Specifies which modules or module variables should be persisted.
  reducer: (state) => ({
    theme: {
      isDark: state.theme.isDark,
    },

    authentication: {
      session: state.authentication.session,
      activeBranch: state.authentication.activeBranch,
    },
    componentManagement: {
      ...componentManagementFiltered(state.componentManagement),
    },

    entitiesManagement: {
      ...state.entitiesManagement,
    },
  }),
});

export const store = new Vuex.Store({
  modules,
  plugins: [pathify.plugin, vuexLocal.plugin],
});
