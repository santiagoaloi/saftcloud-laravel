// Vue
import Vue from 'vue';
import Vuex from 'vuex';

// libraries
import VuexPersist from 'vuex-persist';
import localforage from 'localforage';
import { omit, pick } from 'lodash';
import pathify from '@/plugins/vuex-pathify';

// All Vuex Modules definned in ./modules/index.js
import * as modules from './modules';

// Blacklist module keys
const componentManagementFiltered = (module) => {
  const blackList = ['selectedComponentGroupsMenuTrigger'];
  return omit(module, blackList);
};

// Whitelist module keys
// const componentManagementFiltered = (module) => {
//   const whitelist = ['componentEditSheet'];
//   return pick(module, whitelist);
// };

Vue.use(Vuex);

const vuexLocal = new VuexPersist({
  key: 'vuex-store',
  storage: localforage,
  asyncStorage: true,

  // Specifies which modules or module variables should be persisted.
  reducer: (state) => ({
    theme: {
      isDark: state.theme.isDark,
      // overlay: state.theme.overlay,
    },

    authentication: {
      session: state.authentication.session,
      activeBranch: state.authentication.activeBranch,
    },
    componentManagement: {
      ...componentManagementFiltered(state.componentManagement),
    },

    // componentManagement: {
    //   ...state.componentManagement,
    // },

    entitiesManagement: {
      ...state.entitiesManagement,
    },

    eventsManagement: {
      ...state.eventsManagement,
    },
  }),
});

export const store = new Vuex.Store({
  modules,
  // plugins: [pathify.plugin, vuexLocal.plugin],
  plugins: [pathify.plugin, vuexLocal.plugin],
});
