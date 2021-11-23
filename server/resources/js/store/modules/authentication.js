// Utilities
import axios from 'axios';
import { make } from 'vuex-pathify';
import { isEmpty } from 'lodash';
import { store } from '@/store';
import router, { resetRouter } from '@/router';

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
    store.set('authentication/session', getDefaultState());
    dispatch('eventsManagement/initialState', { root: true });
    dispatch('componentsManagement/initialState', { root: true });
    dispatch('entitiesManagement/initialState', { root: true });
  },

  // Sends login form payload to backend.
  async login({ commit, state, dispatch }, data) {
    return axios
      .post('api/login', data)
      .then((response) => {
        if (response.status) {
          const { data } = response;

          // get rid of the status key
          delete data.status;

          // Set the default branch workspace
          if (!state.activeBranch) {
            store.set('authentication/activeBranch', data.user.user_setting.default_branch);
          }

          // Creates an "origin" of the login response data...
          // data.user.origin = cloneDeep(data);
          commit('session', data);
          axiosDefaults.headers.common.Authorization = `Bearer ${response.data.token}`;

          dispatch('buildRoutes');

          return true;
        }
      })
      .catch(() => false);
  },

  async buildRoutes({ state }) {
    // * Clear routes and routes matcher.
    resetRouter();

    return axios.get('api/getComponentNames/').then((response) => {
      if (response) {
        const { components } = response.data;

        // * add new routes
        for (const component of components) {
          router.addRoute({
            path: `/${component.name}`,
            name: `${component.name}`,
            meta: {
              layout: 'secure-layout',
              title: component.title,
              id: component.id,
              icon: component.configSettings.icon || null,
              appBarSlot: `Slot${component.name}`,
            },
            component: () => import(`@/views/Protected/${component.name}/${component.name}.vue`),
          });

          if (components[components.length - 1] === component) {
            return true;
          }
        }
      }
    });
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
