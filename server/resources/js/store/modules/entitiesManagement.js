import { make } from 'vuex-pathify';
import { isEqual, isEmpty, cloneDeep } from 'lodash';
import axios from 'axios';
import { store } from '@/store';

// When this function is called, the users settings form is back to default values.
const initialUserSettings = () => ({
  name: '',
  last_name: '',
  email: '',
});

// When this function is called, the roles settings form is back to default values.
const initialRoleSettings = () => ({
  name: '',
  description: '',
});

const state = {
  groupName: '',
  searchPrivileges: '',
  allUsers: [],
  allRoles: [],
  allCapabilities: [],
  activeStatusTab: 0,
  isTableLayout: false,
  entityCardGroup: 0,
  dialogEntity: false,
  dialogPrivileges: false,
  dialogAssignRoles: false,
  selectedEntityType: 'Users',
  selectedEntityIndex: 0,
  selectedEntityTableRow: [],
  selectedUserRoles: [],
  user: initialUserSettings(),
  role: initialRoleSettings(),
  identityTypeButton: '',
  entityStatusTabs: [
    { name: 'All', value: 'all', icon: 'mdi-all-inclusive' },
    { name: 'Starred', value: 'starred', icon: 'mdi-star' },
    { name: 'Banned', value: 'banned', icon: 'mdi-lightbulb-on' },
  ],
};

const mutations = make.mutations(state);

const getters = {
  //* returns true if at least one validation did not succeed.
  hasValidationErrors: (_, __, rootState) =>
    Object.values(rootState.validationStatesEntities).some((innerObj) =>
      Object.values(innerObj).includes(true),
    ),

  //* Loads all the configuration of the selected entity.
  selectedEntity: (state, getters) => getters.allEntitiesFiltered[state.selectedEntityIndex],

  //* Disables the right panel navigation arrows if the first entity in the array is selected.
  previousEntityDisabled: (state) => state.entityCardGroup === 0,

  //* Disables the right panel navigation arrows if the last entity in the array is selected.
  nextEntityDisabled: (state, getters) =>
    state.entityCardGroup === getters.allEntitiesFiltered.length - 1,

  //* Returns the name of the tab name selected within the form field editor
  activeEntityTabName: (state) => state.entityStatusTabs[state.activeStatusTab].value,

  //* Returns entities that belongs to a status or matching search.
  allEntitiesFiltered: (state, _, rootState) => {
    const entity = state.selectedEntityType === 'Roles' ? 'allRoles' : 'allUsers';
    const entityName = state.selectedEntityType === 'Roles' ? 'name' : 'email';
    return state[entity].filter((ent) => {
      const search = rootState.application.search.toLowerCase();
      const title = ent[entityName].toLowerCase();
      return !search || title.match(search);
    });
  },

  // //* Filter privileges in the privileges dialog sinple tabe.
  filteredPrivileges: (state, getters) => {
    if (getters.selectedEntity.role.length) {
      // Search field string
      const search = state.searchPrivileges.toString().toLowerCase();

      const privileges = [];

      for (const role of getters.selectedEntity.role) {
        for (const capability of role.capability) {
          privileges.push({ name: capability.name, role: capability.pivot.role_id });
        }
      }

      // return all privileges or the ones matching the search string.
      return privileges.filter((p) => p.name.toLowerCase().match(search));
    }
    return null;
  },

  //* Returns true if there are no users returned from the backend.
  isUsersEmpty: (state) => isEmpty(state.allUsers),

  //* Returns true if the entity has unsaved changes.
  hasUnsavedChanges: () => (entity) => {
    const { origin, ...current } = entity;
    return !isEqual(origin, current);
  },

  //* Returns true if the current groups selected do not contain any entities associated to them.
  isAllFilteredEntitiesEmpty: (_, getters) => getters.allEntitiesFiltered.length === 0,

  //* Returns the color of the star icon depending on its state.
  isStarredColor: () => (component) => component.status.starred ? 'orange' : 'grey darken-1',

  //* Returns the star icon depending on its state.
  isStarredIcon: () => (component) => component.status.starred ? 'mdi-star' : 'mdi-star-outline',

  //* Returns the active icon depending on its state.
  isActiveIcon: () => (component) =>
    component.status.active ? 'mdi-lightbulb-on' : 'mdi-lightbulb-on-outline',

  //* Returns color of the compoment card in the grid view, depending on the theme settings.
  isActiveColor: (_, __, rootState) => (component) =>
    rootState.theme.isDark && component.status.active
      ? 'indigo lighten-4'
      : !rootState.theme.isDark && component.status.active
      ? 'indigo darken-4'
      : rootState.theme.isDark && !component.status.active
      ? 'grey darken-1'
      : 'black',
};

const actions = {
  ...make.actions(state),

  //* Retrieves all users.
  getUsers() {
    axios.get('api/getAllUsers').then((response) => {
      if (response.status === 200) {
        store.set('entitiesManagement/allUsers', response.data.records);
      }
    });
  },

  //* Retrieves all roles.
  getRoles() {
    axios.get('api/getAllRoles').then((response) => {
      if (response.status === 200) {
        store.set('entitiesManagement/allRoles', response.data.records);
      }
    });
  },

  //* Retrieves all capabilities.
  getCapabilities() {
    axios.get('api/getAllCapabilities').then((response) => {
      if (response.status === 200) {
        store.set('entitiesManagement/allCapabilities', response.data.records);
      }
    });
  },

  //* When an entity is selected in the entities view, it loads its configuration.
  setSelectedEntity({ rootState, state }, index) {
    if (state.selectedEntityIndex !== index) {
      store.set('entitiesManagement/selectedEntityIndex', index);
    }

    if (!rootState.drawers.secureEntitiesDrawer) {
      store.set('drawers/secureEntitiesDrawer', true);
    }
  },

  //* Rollback changes before saving entity configuration.
  rollbackChanges({ state, dispatch }, { selectedEntity, selectedEntityType }) {
    const { origin } = selectedEntity;
    const index = state[`all${selectedEntityType}`].findIndex((e) => e.id === selectedEntity.id);
    store.set(`entitiesManagement/all${selectedEntityType}@${index}`, {
      ...origin,
      origin: cloneDeep(origin),
    });

    //* Dispatch resetValidationStates action in validationStates module.
    //* This sets the validations to initial state values.
    dispatch('validationStatesEntities/resetValidationStates', null, { root: true });
  },

  //* Creates a new user in the database.
  async createUser({ state, dispatch }) {
    return axios.post('api/user', state.user).then((response) => {
      if (response.status === 200) {
        dispatch('snackbar/snackbarSuccess', 'New user created', { root: true });
        return true;
      }
    });
  },

  //* Creates a new role in the database.
  async createRole({ state, rootState, dispatch }) {
    const post = {
      ...state.role,
      entity_id: rootState.authentication.activeBranch,
    };
    return axios.post('api/role', post).then((response) => {
      if (response.status === 200) {
        dispatch('snackbar/snackbarSuccess', 'New role created', { root: true });
        store.set('entitiesManagement/dialogEntity', false);
        return true;
      }
    });
  },

  test1() {
    return axios.get('api/test1');
  },

  test2() {
    return axios.get('api/test1');
  },

  test3() {
    return axios.get('api/test1');
  },

  //* Saves Entity User Settings
  async saveEntityUser({ state, getters }) {
    const userId = getters.selectedEntity.id;
    const roles = { name: 'role', items: getters.selectedEntity.role };

    return axios.post(`api/syncUser/${userId}`, roles).then((response) => {
      if (response.status === 200) {
        const index = state[`all${state.selectedEntityType}`].findIndex(
          (e) => e.id === getters.selectedEntity.id,
        );

        //* Avoids origin duplication.
        delete getters.selectedEntity.origin;

        store.set(`entitiesManagement/all${state.selectedEntityType}@${index}`, {
          ...getters.selectedEntity,
          origin: cloneDeep(getters.selectedEntity),
        });
        return true;
      }
    });
  },

  //* Saves Entity User Settings
  async saveEntityRole({ dispatch, getters }) {
    const roleId = getters.selectedEntity.id;
    const capabilities = { name: 'capability', items: getters.selectedEntity.capability };

    return axios.post(`api/syncRole/${roleId}`, capabilities).then((response) => {
      if (response.status === 200) {
        const meta = {
          name: getters.selectedEntity.name,
          description: getters.selectedEntity.description,
        };

        return axios
          .put(`api/role/${roleId}`, meta)
          .then((response) => {
            if (response.status === 200) {
              // const index = state.allRoles.findIndex((r) => r.id === getters.selectedEntity.id);

              // //* Avoids origin duplication.
              // delete getters.selectedEntity.origin;

              // store.set(`entitiesManagement/all${state.selectedEntityType}@${index}`, {
              //   ...getters.selectedEntity,
              //   origin: cloneDeep(getters.selectedEntity),
              // });

              axios.get(`api/role/${getters.selectedEntity.id}`).then(() => {
                // store.set(`entitiesManagement/allRoles@${index}`, {
                // });
              });

              return true;
            }
          })
          .catch(() => {
            dispatch('snackbar/snackbarError', 'There was an error saving', { root: true });
          });
      }
    });
  },

  //* Moves to the previous entity in the array (navigation arrows).
  previousEntity({ state }) {
    if (state.entityCardGroup > 0) {
      store.set('entitiesManagement/entityCardGroup', state.entityCardGroup - 1);
      store.set('entitiesManagement/selectedEntityIndex', state.selectedEntityIndex - 1);
    }
  },

  //* Moves to the next entity in the array (navigation arrows).
  nextEntity({ state, getters }) {
    if (state.entityCardGroup < getters.allEntitiesFiltered.length - 1) {
      store.set('entitiesManagement/entityCardGroup', state.entityCardGroup + 1);
      store.set('entitiesManagement/selectedEntityIndex', state.selectedEntityIndex + 1);
    }
  },

  //* Sets the component as starred, modular or active.
  setEntityStatus(_, component) {
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
