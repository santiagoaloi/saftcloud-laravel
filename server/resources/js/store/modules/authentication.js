// Utilities
import axios from 'axios';
import { make } from 'vuex-pathify';
import { isEmpty } from 'lodash';
import router from '@/router';
import { store } from '@/store';

const axiosDefaults = require('axios/lib/defaults');

// Default validation states definitions (they should all have validation errors to false)
const getDefaultState = () => ({
  session: {},
  activeBranch: undefined,
  dialogTImeoutWarning: false,
  hasSessionExpired: false,
});

const state = getDefaultState();
const mutations = make.mutations(state);

const actions = {
  ...make.actions(state),

  // Reset state to default values.
  resetState() {
    store.set('authentication/session', {});
  },

  // Sends login form payload to backend.
  async login({ commit }, data) {
    return axios
      .post('api/login', data)
      .then((response) => {
        if (response.status) {
          const { data } = response;

          // get rid of the status key
          delete data.status;

          // Creates an "origin" of the login response data...
          // data.user.origin = cloneDeep(data);
          commit('session', data);
          axiosDefaults.headers.common.Authorization = `Bearer ${response.data.token}`;
          return true;
        }
      })
      .catch(() => false);
  },

  // Logs out the user.
  async logout({ dispatch }, data) {
    return axios
      .post('api/logout', data)
      .then(() => {
        axiosDefaults.headers.common.Authorization = undefined;
        dispatch('resetState');
        router.push('/Login');
        return true;
      })
      .catch(() => {
        dispatch('resetState');
        router.push('/Login');
        return false;
      });
  },
};

const getters = {
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
