// Vue
import Vue from 'vue';
import Vuex from 'vuex';

// libraries
import VuexPersist from 'vuex-persist';
import localforage from 'localforage';
import pathify from '@/plugins/vuex-pathify';
import {  cloneDeep , omit } from 'lodash';

// All Vuex Modules definned in ./modules/index.js
import * as modules from './modules';

  // Blacklist module keys

let componentManagementFiltered = () => {
  
const blackList = ['componentEditSheet']; 
const module = modules.componentManagement.state
return omit(module , blackList);

  }




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

      ...componentManagementFiltered(state)

      
     },
  }),
});

export const store = new Vuex.Store({
  modules,
  plugins: [pathify.plugin, vuexLocal.plugin],
});
