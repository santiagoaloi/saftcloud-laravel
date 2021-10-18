// Utilities
import axios from 'axios';
import { make } from 'vuex-pathify';
import { cloneDeep } from 'lodash';
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
        if (response.status === 200) {
          const { data } = response;

          // get rid of the status key
          delete data.status;

          // Creates an "origin" of the login response data...
          data.user.origin = cloneDeep(data);
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

const getters = {};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
