// Utilities
import { make } from 'vuex-pathify';
import { store } from '@/store';

const state = {
  data: {
    color: 'success',
    text: '',
    icon: '',
    value: false,
  },
};

const mutations = make.mutations(state);
const actions = {
  ...make.actions(state),

  snackbarSuccess(_, message) {
    const snackbar = { value: true, text: message, color: 'grey', icon: 'mdi-check' };
    store.set('snackbar/data', { ...snackbar });
  },

  snackbarError(_, message) {
    const snackbar = {
      value: true,
      text: message,
      color: 'pink darken-1',
      icon: 'mdi-alert-octagon',
    };
    store.set('snackbar/data', { ...snackbar });
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
