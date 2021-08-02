import { make } from "vuex-pathify";

//Default validation states definitions (they should all have validation errors to false)
const getDefaultState = () => {
 return {
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
};

const state = getDefaultState();
const mutations = make.mutations(state);
const getters = {};

const actions = {
 ...make.actions(state),

 // Reset validations to default values.
 resetValidationStates({ state }) {
  Object.assign(state, getDefaultState());
 }
};

export default {
 namespaced: true,
 state,
 mutations,
 actions,
 getters
};
