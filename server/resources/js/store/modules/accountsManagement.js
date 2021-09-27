import { make } from 'vuex-pathify';
import { isEqual, isEmpty, cloneDeep } from 'lodash';
import axios from 'axios';
import { store } from '@/store';

// When this function is called, the component settings form is back to default values.
const initialUserSettings = () => ({
  name: '',
  lastName: '',
  email: '',
});

const state = {
  groupName: '',
  searchFields: '',
  allUsers: [],
  allRoles: [],
  allCapabilities: [],
  activeStatusTab: 0,
  isTableLayout: false,
  entityCardGroup: 0,
  dialogAccount: false,
  selectedEntityIndex: 0,
  selectedEntityTableRow: [],
  account: initialUserSettings(),
  entityStatusTabs: [
    { name: 'All', value: 'all', icon: 'mdi-all-inclusive' },
    { name: 'Starred', value: 'starred', icon: 'mdi-star' },
    { name: 'Active', value: 'active', icon: 'mdi-lightbulb-on' },
    { name: 'Inactive', value: 'inactive', icon: 'mdi-lightbulb-off' },
  ],
};

const mutations = make.mutations(state);

const getters = {
  //* returns true if at least one validation did not succeed.
  hasValidationErrors: (_, __, rootState) => Object.values(rootState.validationStates).some((innerObj) => Object.values(innerObj).includes(true)),

  //* Loads all the configuration of the selected component.
  selectedEntity: (state, getters) => getters.allEntitiesFiltered[state.selectedEntityIndex],


  //* Disables the right panel navigation arrows if the first component in the array is selected.
  previousEntityDisabled: (state) => state.entityCardGroup === 0,

  //* Disables the right panel navigation arrows if the last component in the array is selected.
  nextEntityDisabled: (state, getters) => state.entityCardGroup === getters.allEntitiesFiltered.length - 1,


  //* Returns the name of the tab name selected within the form field editor
  activeEntityTabName: (state) => state.entityStatusTabs[state.activeStatusTab].value,

  //* Returns components that belongs to a group, status or matching search.
  allEntitiesFiltered: (state, getters, rootState) => {
    if (!getters.hasSelectedSomeGroups) return [];
    return state.allComponents.filter((component) => {
      const search = rootState.application.search.toLowerCase();
      const title = component.config.general_config.title.toLowerCase();
      const status = getters.activeEntityTabName;
      return (
        (!search || title.match(search))
    && (status === 'all'
     || (status === 'inactive' && !component.status.active)
     || (status === 'navigation' && component.config.general_config.isVisibleInSidebar)
     || component.status[status])
    && state.selectedEntityGroups.some((group) => group.id === component.component_group_id)
      );
    });
  },

  //* Returns true if the are no components returned from the backend.
  isUsersEmpty: (state) => isEmpty(state.allComponents),

  //* Returns true if the component has unsaved changes.
  hasUnsavedChanges: (_, getters) => (component) => {
    if (getters.hasSelectedSomeGroups) {
      const { origin, ...current } = component;
      return !isEqual(origin, current);
    }
  },

  //* Returns true if the current groups selected do not contain any components associated to them.
  isAllFilteredComponentsEmpty: (_, getters) => getters.allEntitiesFiltered.length === 0,

  //* Returns the color of the star icon depending on its state.
  isStarredColor: () => (component) => (component.status.starred ? 'orange' : 'grey darken-1'),

  //* Returns the star icon depending on its state.
  isStarredIcon: () => (component) => (component.status.starred ? 'mdi-star' : 'mdi-star-outline'),

  //* Returns the active icon depending on its state.
  isActiveIcon: () => (component) => (component.status.active ? 'mdi-lightbulb-on' : 'mdi-lightbulb-on-outline'),

  //* Returns color of the compoment card in the grid view, depending on the theme settings.
  isActiveColor: (_, __, rootState) => (component) => (rootState.theme.isDark && component.status.active
    ? 'indigo lighten-4'
    : !rootState.theme.isDark && component.status.active
      ? 'indigo darken-4'
      : rootState.theme.isDark && !component.status.active
        ? 'grey darken-1'
        : 'black'),


  //* Returns the count of components belonging to a specific group.
  countComponentsInGroup: (state) => (id) => state.allComponents.filter((component) => component.component_group_id === id).length,
  countComponentsFiltered: (_, getters) => getters.allEntitiesFiltered.length,
};

const actions = {
  ...make.actions(state),



  //* Retrieves the component groups.
  getUsers({}) {
    axios.get('api/allUsers').then((response) => {
      if (response.status === 200) {
        store.set('componentManagement/allGroups', response.data.groups);
      }
    });
  },


  //* Retrieves all available componentes from the database.
  getRoles({}) {
    axios.get('api/showAllComponents').then((response) => {
      if (response.status === 200) {
        store.set('componentManagement/allComponents', response.data.components);
      }
    });
  },





  //* When a component is selected in the components view, it loads its configuration.
  setselectedEntity({ rootState, state }, index) {
    if (state.selectedEntityIndex != index) {
      store.set('componentManagement/selectedEntityIndex', index);
    }

    if (!rootState.drawers.secureComponentDrawer) {
      store.set('drawers/secureComponentDrawer', true);
    }
  },



  //* Rollback changes before saving component configuration.
  rollbackChanges({ state, dispatch }, component) {
    const { origin } = component;
    const index = state.allComponents.findIndex((c) => c.id === component.id);
    store.set(`componentManagement/allComponents@${index}`, { ...origin, origin: cloneDeep(origin) });

    //* Dispatch resetValidationStates action in validationStates module.
    //* This sets the validations to initial state values.
    dispatch('validationStates/resetValidationStates', null, { root: true });
  },



  //* Creates a new component in the database.
  createAccount({ state, getters, dispatch }) {
    return axios.post('api/user', state.account).then((response) => {
      if (response.status === 200) {
        store.set('snackbar/value', true);
        store.set('snackbar/text', 'account created');
        store.set('snackbar/color', 'primary');

        //* Autoselect latest created component
        store.set('componentManagement/dialogAccount', false);
        return true;
      }
    });
  },

  //* Moves to the previous component in the array (navigation arrows).
  previousEntity({ state }) {
    if (state.entityCardGroup > 0) {
      store.set('componentManagement/entityCardGroup', state.entityCardGroup - 1);
      store.set('componentManagement/selectedEntityIndex', state.selectedEntityIndex - 1);
    }
  },

  //* Moves to the next component in the array (navigation arrows).
  nextEntity({ state, getters }) {
    if (state.entityCardGroup < getters.allEntitiesFiltered.length - 1) {
      store.set('componentManagement/entityCardGroup', state.entityCardGroup + 1);
      store.set('componentManagement/selectedEntityIndex', state.selectedEntityIndex + 1);
    }
  },


  //* Sets the component as starred, modular or active.
  setEntityStatus({}, component) {
    axios.patch(`api/component/${component.id}`, { status: component.status });
  },

  //* Sets the component as starred.
  setStarred({ dispatch }, component) {
    component.status.starred = !component.status.starred;
    component.origin.status.starred = !component.origin.status.starred;
    dispatch('setEntityStatus', component);
  },

  //* Sets the component as modular.
  setModular({ dispatch }, component) {
    component.status.modular = !component.status.modular;
    component.origin.status.modular = !component.origin.status.modular;
    dispatch('setEntityStatus', component);
  },

  //* Sets the component as active.
  setActive({ dispatch }, component) {
    component.status.active = !component.status.active;
    component.origin.status.active = !component.origin.status.active;
    dispatch('setEntityStatus', component);
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
