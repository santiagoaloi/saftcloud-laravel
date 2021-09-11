import axios from "axios";
import { store } from "@/store";
import { make } from "vuex-pathify";

const state = {
 records: [],
 recordItem: {},
 recordItemInitial: {},
 columns: [],
 formFields: {},
 dialog: false,
 isBooted: undefined
};

const mutations = make.mutations(state);
const getters = {};

const actions = {
 ...make.actions(state),

 // Loads all the neccesary data to hydrate the active view.
 loadView({}, id) {
  axios.get(`api/componentConstructor/${id}`).then(response => {
   if (response.status === 200) {
    store.set("activeView/records", response.data.component.records);
    store.set("activeView/recordItem", response.data.component.recordItem);
    store.set("activeView/columns", response.data.component.columns);
    store.set("activeView/formFields", response.data.component.formFields);
    store.set("activeView/isBooted", true);
   }
  });
 },

 addRecord({ state }) {
  state.records.push(state.recordItem);
  store.set("activeView/recordItem", {});
  store.set("activeView/dialog", false);
 }
};

export default {
 namespaced: true,
 state,
 mutations,
 actions,
 getters
};
