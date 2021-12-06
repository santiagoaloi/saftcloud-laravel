import axios from 'axios';
import { make } from 'vuex-pathify';
import { isEqual, isEmpty, cloneDeep } from 'lodash';
import { AvatarGenerator } from 'random-avatar-generator';
import { store } from '@/store';

const avatarGenerator = new AvatarGenerator();

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

const initialState = () => ({
  allUsers: [],
  allRoles: [],
  groupName: '',
  activeStatusTab: 0,
  entityCardGroup: 0,
  dialogEntity: false,
  allCapabilities: [],
  searchPrivileges: '',
  isTableLayout: false,
  selectedUserRoles: [],
  identityTypeButton: '',
  selectedEntityIndex: 0,
  dialogPrivileges: false,
  dialogAssignRoles: false,
  entitiesEditSheet: false,
  selectedEntityType: 'Users',
  selectedEntityTableRow: [],
  user: initialUserSettings(),
  role: initialRoleSettings(),
  entitiesEditDrawerActiveMenu: undefined,
  entityStatusTabs: [
    { name: 'All', value: 'all', icon: 'mdi-all-inclusive' },
    { name: 'Starred', value: 'starred', icon: 'mdi-star' },
    { name: 'Banned', value: 'banned', icon: 'mdi-lightbulb-on' },
  ],
});

const state = initialState();
const mutations = make.mutations(state);

const getters = {
  //* returns true if at least one validation did not succeed.
  hasValidationErrors: (_, __, rootState) =>
    Object.values(rootState.validationStatesEntities).some((innerObj) => Object.values(innerObj).includes(true)),

  //* Loads all the configuration of the selected entity.
  selectedEntity: (state, getters) => getters.allEntitiesFiltered[state.selectedEntityIndex],

  //* Disables the right panel navigation arrows if the first entity in the array is selected.
  previousEntityDisabled: (state) => !state.entityCardGroup,

  //* Disables the right panel navigation arrows if the last entity in the array is selected.
  nextEntityDisabled: (state, getters) => state.entityCardGroup === getters.allEntitiesFiltered.length - 1,

  //* Returns the name of the tab name selected within the form field editor
  activeEntityTabName: (state) => state.entityStatusTabs[state.activeStatusTab].value,

  //* Returns entities that belongs to a status or matching search.
  allEntitiesFiltered: (state, _, rootState) => {
    const entity = state.selectedEntityType === 'Roles' ? 'allRoles' : 'allUsers';
    const userFields = ['email', 'id'];
    const userMetaFields = ['first_name', 'last_name'];
    const roleFields = ['name'];

    return state[entity].filter((entity) => {
      const search = rootState.application.search.toLowerCase();
      return state.selectedEntityType === 'Roles'
        ? roleFields.some((field) => entity[field].toString().toLowerCase().includes(search))
        : userFields.some((field) => entity[field].toString().toLowerCase().includes(search)) ||
            userMetaFields.some((field) => entity.entity[field].toString().toLowerCase().includes(search));
    });
  },

  // //* Filter privileges in the privileges dialog sinple tabe.
  filteredPrivileges: (state, getters) => {
    if (state.selectedEntityType === 'Users' && getters.hasSelectedEntity && !getters.isUsersEmpty) {
      // Search field string
      const search = state.searchPrivileges.toString().toLowerCase();

      const privileges = getters.selectedEntity.role.flatMap((role) =>
        role.capability.flatMap((privilege) => ({ name: privilege.name, role: privilege.pivot.role_id })),
      );

      // return all privileges or the ones matching the search string.
      return privileges.filter((p) => p.name.toLowerCase().includes(search));
    }
  },

  //* Returns true if there are no users fetched from the backend.
  isUsersEmpty: (state) => isEmpty(state.allUsers),

  //* Returns true if the entity has unsaved changes.
  hasUnsavedChanges: (_, getters) => (entity) => {
    if (getters.hasSelectedEntity) {
      const { origin, ...current } = entity;
      return !isEqual(origin, current);
    }
  },

  //* Returns true if the entity has unsaved changes.
  hasSelectedEntity: (_, getters) => !isEmpty(getters.selectedEntity),

  //* Returns true if the current groups selected do not contain any entities associated to them.
  isAllFilteredEntitiesEmpty: (_, getters) => !getters.allEntitiesFiltered.length,

  //* Returns the color of the star icon depending on its state.
  isStarredColor: () => (component) => component.status.starred ? 'orange' : 'grey darken-1',

  //* Returns the star icon depending on its state.
  isStarredIcon: () => (component) => component.status.starred ? 'mdi-star' : 'mdi-star-outline',

  //* Returns the active icon depending on its state.
  isActiveIcon: () => (component) => component.status.active ? 'mdi-lightbulb-on' : 'mdi-lightbulb-on-outline',

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

  //* Returns true if 2 objects are different.
  isDifferent: () => (a, b) => !isEqual(a, b),

  //* Retrieves all users.
  getUsers() {
    axios.get('api/user.showAll').then((response) => {
      if (response.status === 200) {
        store.set('entitiesManagement/allUsers', response.data.records);
      }
    });
  },

  //* Retrieves all roles.
  getRoles() {
    axios.get('api/role.showAll').then((response) => {
      if (response.status === 200) {
        store.set('entitiesManagement/allRoles', response.data.records);
      }
    });
  },

  //* Retrieves all capabilities.
  getCapabilities() {
    axios.get('api/capability.showAll').then((response) => {
      if (response.status === 200) {
        store.set('entitiesManagement/allCapabilities', response.data.records);
      }
    });
  },

  //* When an entity is selected in the entities view, it loads its configuration.
  setSelectedEntity({ state }, index) {
    if (state.selectedEntityIndex !== index) {
      store.set('entitiesManagement/selectedEntityIndex', state.entityCardGroup);
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
  async createUser({ state, rootState, dispatch }) {
    const post = {
      ...state.user,
      entity_id: rootState.authentication.activeBranch,
    };

    post.avatar = avatarGenerator.generateRandomAvatar();

    return axios.post('api/user', post).then((response) => {
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

  async removeUser({ state, dispatch }, id) {
    return axios.delete(`api/user/${id}`).then((response) => {
      if (response.status === 200) {
        state.allUsers = state.allUsers.filter((user) => user.id !== id);
        dispatch('snackbar/snackbarSuccess', 'User removed', {
          root: true,
        });
        return true;
      }
    });
  },

  async removeRole({ dispatch }, id) {
    return axios.delete(`api/role/${id}`).then((response) => {
      if (response.status === 200) {
        dispatch('snackbar/snackbarSuccess', 'Role removed', {
          root: true,
        });
        return true;
      }
    });
  },

  //* Saves Entity User Roles
  async saveUserRoles({ getters }) {
    const userId = getters.selectedEntity.id;
    const roles = { name: 'role', items: getters.selectedEntity.role };
    return axios.post(`api/user.sync/${userId}`, roles);
  },

  //* Saves Entity User Metadata
  async saveUserMetadata({ getters }) {
    const entity = { ...getters.selectedEntity.entity };
    return axios.patch(`api/entity/${entity.id}`, entity);
  },

  //* Saves Entity User Email
  async saveUserEmail({ getters }) {
    const userId = getters.selectedEntity.id;
    const { email } = getters.selectedEntity;
    return axios.patch(`api/user/${userId}`, { email });
  },

  //* Get User
  async getUser({ getters }) {
    const user = { ...getters.selectedEntity.id };
    return axios.get(`api/user/${user}`);
  },

  //* Get User
  async getUserAndReplace({ state, getters, dispatch }) {
    const user = getters.selectedEntity.id;
    return axios
      .get(`api/user/${user}`)
      .then((response) => {
        const index = state.allUsers.findIndex((e) => e.id === user);
        store.set(`entitiesManagement/allUsers@${index}`, response.data.record);
      })
      .catch(() => {
        dispatch('snackbar/snackbarError', 'There was an error fetching the users', { root: true });
      });
  },

  //* Saves Entity User Settings
  async saveRole({ state, dispatch, getters }) {
    const roleId = getters.selectedEntity.id;
    const capabilities = { name: 'capability', items: getters.selectedEntity.capability };

    return axios.post(`api/role.sync/${roleId}`, capabilities).then((response) => {
      if (response.status === 200) {
        const meta = {
          name: getters.selectedEntity.name,
          description: getters.selectedEntity.description,
        };

        return axios
          .put(`api/role/${roleId}`, meta)
          .then((response) => {
            if (response.status === 200) {
              const index = state.allRoles.findIndex((r) => r.id === getters.selectedEntity.id);

              axios.get(`api/role/${getters.selectedEntity.id}`).then((responseMeta) => {
                store.set(`entitiesManagement/allRoles@${index}`, responseMeta.data.record);
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
