// Utilities
import axios from 'axios';
import { make } from 'vuex-pathify';
import { isEmpty } from 'lodash';
import { store } from '@/store';
import router from '@/router';

const axiosDefaults = require('axios/lib/defaults');

const getDefaultState = () => ({
  session: {},
  activeBranch: null,
  dialogTImeoutWarning: false,
  hasSessionExpired: false,
});

const state = getDefaultState();
const mutations = make.mutations(state);

const actions = {
  ...make.actions(state),

  // Reset state to default values.
  resetState({ dispatch }) {
    store.set('authentication/activeBranch', null);
    store.set('authentication/session', getDefaultState());

    dispatch('eventsManagement/initialState', { root: true });
    dispatch('modulesManagement/initialState', { root: true });
    dispatch('entitiesManagement/initialState', { root: true });
  },

  // Sends login form payload to backend.
  login({ commit, state }, data) {
    return axios
      .post('api/login', data)
      .then((response) => {
        if (response.data.status) {
          const { data } = response;

          // get rid of the status key
          delete data.status;

          // Set the default branch workspace
          if (!state.activeBranch && data.user.user_setting !== null) {
            commit('session', data);
            axiosDefaults.headers.common.Authorization = `Bearer ${response.data.token}`;
            store.set('authentication/activeBranch', data.user.user_setting.default_branch);
            return true;
          }

          if (data.user.user_setting === null || !data.user.user_setting.default_branch) {
            store.set('snackbar/data@value', true);
            store.set(
              'snackbar/data@text',
              `This account doesnt have an <b> active branch </b> configured, please contact your administrator before you can access your account.`,
            );
            store.set('snackbar/data@icon', 'mdi-alert-octagon');
            store.set('snackbar/data@color', 'pink darken-1');
            store.set('snackbar/data@permanent', true);

            return false;
          }
        }
        return false;
      })
      .catch(() => false);
  },

  async buildRoutes({ state }) {
    // // * Clear routes and routes matcher.
    // resetRouter();
    // return axios.get('api/getModuleNames/').then((response) => {
    //   if (response) {
    //     const { Modules } = response.data;
    //     // * add new routes
    //     for (const Modules of Modules) {
    //       router.addRoute({
    //         path: `/${Modules.name}`,
    //         name: `${Modules.name}`,
    //         meta: {
    //           layout: 'secure-layout',
    //           title: Modules.title,
    //           id: Modules.id,
    //           icon: Modules.configSettings.icon || null,
    //           appBarSlot: `Slot${Modules.name}`,
    //         },
    //         component: () => import(`@/views/Protected/${Modules.name}/${Modules.name}.vue`),
    //       });
    //       if (Modules[Modules.length - 1] === Modules) {
    //         return true;
    //       }
    //     }
    //   }
    // });
  },

  // Logs out the user.
  async logout({ dispatch }, data) {
    store.set('loaders/logoutLoader', true);
    return axios
      .post('api/logout', data)
      .then(() => {
        axiosDefaults.headers.common.Authorization = undefined;
        dispatch('resetState');
        router.push('/Login');
        return true;
      })
      .catch(() => {
        axiosDefaults.headers.common.Authorization = undefined;
        dispatch('resetState');
        router.push('/Login');
        return false;
      });
  },
};

const getters = {
  branches(state) {
    if (getters.isLoggedIn) {
      return state.session.user.branch;
    }
  },

  defaultBranch(state) {
    if (getters.isLoggedIn) {
      return state.session.user.user_setting.default_branch;
    }
  },

  isRoot: (state, getters) => {
    if (getters.isLoggedIn) {
      return state.session.user.role.some((r) => r.name === 'Root');
    }
  },

  isAdmin: (state, getters) => {
    if (getters.isLoggedIn) {
      return state.session.user.role.some((r) => r.name === 'Admin');
    }
  },

  roles: (state) => {
    if (state.session.user) {
      return state.session.user.role.map((r) => r.name);
    }
    return [];
  },

  isLoggedIn: (state) => !isEmpty(state.session),
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
