import axios from 'axios';
import { make } from 'vuex-pathify';
import { store } from '@/store';

const state = {
  records: [],
  recordItem: {},
  recordItemInitial: {},
  columns: [],
  formFields: {},
  visibleColumns: [],
  dialogCrud: false,
  dialogCustomize: false,
};

const mutations = make.mutations(state);
const getters = {};

const actions = {
  ...make.actions(state),

  // Loads all the neccesary data to hydrate the active view.
  loadView({ dispatch }, id) {
    axios.get(`api/componentConstructor/${id}`).then((response) => {
      if (response.status === 200) {
        store.set('activeView/records', response.data.component.records);
        store.set('activeView/recordItem', response.data.component.recordItem);
        store.set('activeView/columns', response.data.component.columns);
        store.set('activeView/formFields', response.data.component.formFields);
        dispatch('pushAllColumnNames');
      }
    });
  },

  pushAllColumnNames({ state }) {
    state.visibleColumns = [];
    for (const column of state.columns) {
      state.visibleColumns.push(column.value);
    }
  },

  addRecord({ state }) {
    state.records.push(state.recordItem);
    store.set('activeView/recordItem', {});
    store.set('activeView/dialogCrud', false);
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
