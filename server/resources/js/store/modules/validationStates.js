// Utilities
import { make } from "vuex-pathify";
const state = {
 componentsEditBasic: {
  componentName: false
 },
 componentsEditFormFieldsBasicTab: {
  label: false
 },
 componentsEditFormFieldsSettingsTab: {
  tooltip: false,
  color: false
 }
};

const mutations = make.mutations(state);
const getters = {};

const actions = {
 ...make.actions(state)
};

export default {
 namespaced: true,
 state,
 mutations,
 actions,
 getters
};
