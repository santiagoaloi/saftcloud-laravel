import { make } from 'vuex-pathify';
import { isEqual, isEmpty, cloneDeep, orderBy } from 'lodash';
import axios from 'axios';
import { store } from '@/store';

// When this function is called, the Modules settings form is back to default values.
const initialmoduleSettings = () => ({
  note: '',
  name: '',
  table: '',
  title: '',
  module_group_id: '',
});

const initialState = () => ({
  loading: false,
  editingCapability: false,
  capability: {},
  dbTables: [],
  allGroups: [],
  groupName: '',
  groupParent: 0,
  tableColumns: [],
  dbGroupNames: [],
  searchFields: '',
  allModules: [],
  activeStatusTab: 0,
  dialogEditor: false,
  dialogGroups: false,
  dialogModules: false,
  dialogCapability: false,
  isTableLayout: false,
  activeFormFieldTab: 0,
  modulesCardGroup: 0,
  dbTablesAndColumns: {},
  modulesEditSheet: false,
  groupNameBeingRemoved: '',
  selectedFieldItemGroup: 0,
  selectedModuleIndex: 0,
  modulesLinkedToGroup: [],
  selectedModuleGroups: [],
  selectedModuleGroupsMenu: [],
  selectedModuleGroupsMenuTrigger: false,
  showSelectedFieldsOnly: false,
  moduleConfigStructure: {},
  selectedModuleTableRow: [],
  selectedModuleActiveField: '',
  displayEnabledFormFieldsOnly: false,
  modulesEditDrawerActiveMenu: undefined,
  moduleSettings: initialmoduleSettings(),
  modulesStatusTabs: [
    { name: 'All', value: 'all', icon: 'mdi-all-inclusive' },
    { name: 'Starred', value: 'starred', icon: 'mdi-star' },
    { name: 'Active', value: 'active', icon: 'mdi-lightbulb-on' },
    { name: 'Inactive', value: 'inactive', icon: 'mdi-lightbulb-off' },
    { name: 'Modular', value: 'modular', icon: 'mdi-view-module' },
    { name: 'Sidebar', value: 'navigation', icon: 'mdi-menu' },
  ],
  navigationStructure: {},
  modulesLinkedToGroupDialog: false,
  activeSheet: '',
  sortOrderAsc: false,
  sortFilter: 'alpha',
});

const state = initialState();
const mutations = make.mutations(state);

const getters = {
  //* returns true if at least one validation did not succeed.
  hasValidationErrors: (_, __, rootState) =>
    Object.values(rootState.validationStatesModules).some((innerObj) => Object.values(innerObj).includes(true)),

  //* returns the group name where this Modules belongs.
  mapModulesGroup: (state, getters) => (module) => {
    if (getters.isAllGroupsEmpty) return;
    return state.allGroups.find((g) => g.id === module.module_group_id);
  },

  //* returns the parent group name where this Modules belongs.
  mapGroupParent: (state, getters) => (module) => {
    if (getters.isAllGroupsEmpty) return;
    const parentGroupId = state.allGroups.find((g) => g.id === module.module_group_id);
    return state.allGroups.find((g) => g.id === parentGroupId).name;
  },

  //* Loads all the field settings of the selected field in Modules form field tab.
  selectedModuleFormField: (state, getters) => {
    if (getters.selectedModule) {
      const index = getters.selectedModule.config.form_fields.findIndex((f) => f.field === state.selectedModuleActiveField);
      return getters.selectedModule.config.form_fields[index];
    }
  },

  //* Returns form fields matching the search string typed.
  filteredFormFields: (state, getters) => {
    if (getters.selectedModule) {
      const searchFields = state.searchFields.toString().toLowerCase();
      return getters.selectedModule.config.form_fields.filter((field) => field.label.toLowerCase().match(searchFields));
    }
  },

  //* Returns form fields that are set to be displayed in the Modules.
  filteredSelectedFields: (state, getters) => {
    if (getters.selectedModule) {
      const searchFields = state.searchFields.toString().toLowerCase();
      return getters.selectedModule.config.form_fields.filter(
        (field) => field.label.toLowerCase().match(searchFields) && field.displayField,
      );
    }
  },

  //* Returns the name of the tab name selected within the form field editor
  selectedTabName: (state) => state.modulesStatusTabs[state.activeStatusTab].value,

  allModulesFilteredByGroup: (state, getters) => {
    const dedupGroups = [...new Set(getters.allModulesFiltered.map((item) => item.module_group_id))];
    return dedupGroups.flatMap((grupId) => ({
      groupId: grupId,
      groupName: state.allGroups.find((group) => group.id === grupId).name,
      modules: getters.allModulesFiltered.filter((m) => m.module_group_id === grupId),
    }));
  },

  allModulesFilteredByGroupSorted: (state, getters) => {
    if (state.sortFilter === 'alpha') {
      return orderBy(getters.allModulesFilteredByGroup, [(group) => group.groupName.toLowerCase()], [getters.sortOrder]);
    }
    if (state.sortFilter === 'count') {
      return orderBy(getters.allModulesFilteredByGroup, (group) => group.modules.length, [getters.sortOrder]);
    }

    return getters.allModulesFilteredByGroup;
  },

  allModulesFilteredSorted: (state, getters) => {
    if (state.sortFilter === 'alpha') {
      return orderBy(
        getters.allModulesFiltered,
        [(modules) => modules.config.general_config.title.toLowerCase()],
        [getters.sortOrder],
      );
    }

    return getters.allModulesFiltered;
  },

  sortOrder: (state) => {
    if (state.sortOrderAsc) {
      return 'asc';
    }
    return 'desc';
  },

  //* Returns true if there are no Modules fetched from the backend.
  isAllModulesEmpty: (state) => isEmpty(state.allModules),

  //* Returns true if there are no Modules groups defined in the groups array.
  isAllGroupsEmpty: (state) => state.allGroups.length === 0,

  //* Returns true if all groups in the Modules group dropdown are selected.
  hasSelectedAllGroups: (state) => state.selectedModuleGroups.length === state.allGroups.length,

  //* Returns true if one or more Modules groups in the Modules group dropdown are selected.
  hasSelectedSomeGroups: (state) => !isEmpty(state.selectedModuleGroups),

  //* Returns true if all groups in the Modules group dropdown are selected.
  hasSelectedModule: (_, getters) => !isEmpty(getters.selectedModule),

  //* Returns true if the Modules has unsaved changes.
  hasUnsavedChanges: (_, getters) => (module) => {
    if (getters.hasSelectedSomeGroups && getters.hasSelectedModule) {
      const { origin, ...current } = module;
      return !isEqual(origin, current);
    }
  },
  //* Loads all the configuration of the selected Modules.
  selectedModule: (state, getters) => getters.allModulesFiltered[state.selectedModuleIndex],

  //* Returns Modules that belongs to a group, status or matching search string.
  allModulesFiltered: (state, getters, rootState) => {
    //! REFACTOR, THIS TRIGGERS  UNSELECT THE Modules IN EVERY CHANGE OF DATA
    console.log('allModulesFiltered triggered');
    if (!getters.hasSelectedSomeGroups || getters.isAllModulesEmpty) return [];
    // state.modulesCardGroup = null;
    // state.selectedModuleIndex = null;

    return state.allModules.filter((module) => {
      const { active } = module.status;
      const groupId = module.module_group_id;
      const sideBar = module.config.general_config.isVisibleInSidebar;

      const status = getters.selectedTabName;
      const search = rootState.application.search.toLowerCase();
      const title = module.config.general_config.title.toLowerCase();

      return (
        (!search || title.includes(search)) &&
        (status === 'all' ||
          (status === 'inactive' && !active) ||
          (status === 'navigation' && sideBar) ||
          module.status[status]) &&
        state.selectedModuleGroups.some((group) => group.id === groupId)
      );
    });
  },

  //* Returns true if the current groups selected do not contain any Modules associated to them.
  isAllFilteredModulesEmpty: (_, getters) => isEmpty(getters.allModulesFiltered),

  //* Returns the color of the star icon depending on its state.
  isStarredColor: () => (module) => module.status.starred ? 'orange' : 'grey darken-1',

  //* Returns the star icon depending on its state.
  isStarredIcon: () => (module) => module.status.starred ? 'mdi-star' : 'mdi-star-outline',

  //* Returns the active icon depending on its state.
  isActiveIcon: () => (module) => module.status.active ? 'mdi-lightbulb-on' : 'mdi-lightbulb-on-outline',

  //* Returns color of the compoment card in the grid view, depending on the theme settings.
  isActiveColor: (_, __, rootState) => (module) =>
    rootState.theme.isDark && module.status.active
      ? 'indigo lighten-4'
      : !rootState.theme.isDark && module.status.active
      ? 'indigo darken-4'
      : rootState.theme.isDark && !module.status.active
      ? 'grey darken-1'
      : 'black',

  //* Returns the modular icon depending on its state.
  isModularIcon: () => (module) => module.status.modular ? 'mdi-view-module' : 'mdi-view-module-outline',

  //* Returns color of the card modular icon in the grid view, depending on the theme settings.
  isModularColor: (_, __, rootState) => (module) =>
    rootState.theme.isDark && module.status.modular
      ? 'indigo lighten-4'
      : !rootState.theme.isDark && module.status.modular
      ? 'indigo darken-4'
      : rootState.theme.isDark && !module.status.modular
      ? 'grey darken-1'
      : 'black',

  //* Returns the count of all available modules
  countAllModules: (state) => state.allModules.length,

  //* Returns the count of modules belonging to a specific group.
  countModulesInGroup: (state) => (id) => state.allModules.filter((module) => module.module_group_id === id).length,

  countModulesFiltered: (_, getters) => getters.allModulesFiltered.length,
};

const actions = {
  ...make.actions(state),

  //* Saves the Modules configuration structure as a new version of the configuration (version control).
  async saveModuleConfigStructure({ state, dispatch }) {
    return axios
      .post('api/moduleDefault', {
        config_structure: JSON.parse(state.moduleConfigStructure),
      })
      .then(() => {
        dispatch('getModules');
        dispatch('getNavigationStructure');
        dispatch('snackbar/snackbarSuccess', 'Config structure updated', { root: true });
        store.set('modulesManagement/dialogEditor', false);
      });
  },

  //* Retrieves the last record of the Modules configuration structure.
  getModuleConfigStructure() {
    axios.get('api/moduleDefaultLast').then((response) => {
      store.set('modulesManagement/moduleConfigStructure', JSON.stringify(response.data, null, 2));
    });
  },

  //* Retrieves all avaiable tables from the database.
  getDbTables() {
    axios.get('api/getAllTables').then((response) => {
      store.set('modulesManagement/dbTables', response.data);
    });
  },

  //* Retrieves all avaiable tables and its corresponding columns from the database.
  getDbTablesAndColumns() {
    axios.get('api/getAllTablesAndColumns').then((response) => {
      const { data } = response.data;
      Object.freeze(data);
      store.set('modulesManagement/dbTablesAndColumns', data);
    });
  },

  //* Retrieves all avaiable group names from the database.
  getDbGroupNames() {
    axios
      .get('api/getAllGroupNames')
      .then((response) => {
        store.set('modulesManagement/dbGroupNames', response.data);
      })
      .catch(() => {
        store.set('modulesManagement/dbGroupNames', []);
      });
  },

  //* Retrieves the navigation structure for the secure drawer.
  getNavigationStructure() {
    axios.get('api/getNavigationStructure').then((response) => {
      store.set('modulesManagement/navigationStructure', response.data.navigationStructure);
    });
  },

  //* Retrieves the Modules groups.
  getGroups() {
    axios.get('api/moduleGroup.showAll').then((response) => {
      if (response.status === 200) {
        store.set('modulesManagement/allGroups', response.data.groups);
      }
    });
  },

  //* Unselects a group in the Modules view.
  unselectGroup({ state }, id) {
    const selectedModuleGroups = state.selectedModuleGroups.filter((mg) => mg.id !== id);
    store.set('modulesManagement/selectedModuleGroups', selectedModuleGroups);
  },

  //* Selects all the available groups in the Modules view.
  selectAllGroups({ state, getters }) {
    if (getters.hasSelectedAllGroups) {
      store.set('modulesManagement/selectedModuleGroups', []);
    } else {
      store.set('modulesManagement/selectedModuleGroups', state.allGroups.slice());
    }
  },

  //* Retrieves all available Moduleses from the database.
  getModules({ state }) {
    store.set('modulesManagement/loading', true);
    axios
      .get('api/module.showAll', {
        // validateStatus(status) {
        //   return status !== 200; // Resolve only if the status code is 200
        // },
      })
      .then((response) => {
        console.log(response.data.modules);
        store.set('modulesManagement/allModules', response.data.modules);
        store.set('modulesManagement/loading', false);
      });
  },

  selectGroup({ state }, { item }) {
    const groupFound = state.selectedModuleGroups.find((g) => g.id === item.id);
    if (groupFound) {
      const removeGroup = state.selectedModuleGroups.filter((g) => g.id !== item.id);
      store.set('modulesManagement/selectedModuleGroups', removeGroup);
    } else {
      store.set(`modulesManagement/selectedModuleGroups@${state.selectedModuleGroups.length}`, item);
    }
  },

  //* Soft removes a Modules group (it can be restored).
  removeGroup({ dispatch }, id) {
    axios
      .delete(`api/moduleGroup/${id}`)
      .then((response) => {
        if (response.status === 200) {
          if (response.data.modules && response.data.modules.length) {
            store.set('modulesManagement/modulesLinkedToGroup', response.data.modules);
            store.set('modulesManagement/modulesLinkedToGroupDialog', true);
          } else {
            dispatch('unselectGroup', id);
          }
          if (response.data.groups) {
            store.set('modulesManagement/allGroups', response.data.groups);
            dispatch('getGroups');
            dispatch('getDbGroupNames');
            dispatch('getNavigationStructure');
            dispatch('snackbar/snackbarSuccess', 'Group removed', { root: true });
          }
        }
      })
      .catch(() => {});
  },

  //* Saves the Modules group configuration settings.
  saveGroup({ state, dispatch }) {
    const parent = state.allGroups.find((g) => g.name === state.dbGroupNames[state.groupParent - 1]);
    axios
      .post('api/moduleGroup', {
        name: state.groupName,
        module_group_id: parent ? parent.id : null,
      })
      .then((response) => {
        if (response.status === 200) {
          store.set('modulesManagement/allGroups', response.data.groups);
          dispatch('snackbar/snackbarSuccess', `Group "${state.groupName}" created`, {
            root: true,
          });

          store.set('modulesManagement/groupName', '');
          //  store.set("modulesManagement/groupChild", "");
          store.set('modulesManagement/groupParent', 0);
          dispatch('getNavigationStructure');
          dispatch('getDbGroupNames');
          dispatch('getGroups');
        }
      })
      .catch((error) => {
        dispatch('snackbar/snackbarError', `${error.response.status} ${error.response.statusText}`, {
          root: true,
        });
      });
  },

  //* Renames the Modules group.
  renameGroup({ dispatch, state }, { id, groupParent }) {
    const parent = state.allGroups[groupParent].id;
    axios
      .put(`api/moduleGroup/${id}`, {
        name: state.groupName,
        module_group_id: parent === id ? null : parent,
      })
      .then((response) => {
        if (response.status === 200) {
          store.set('modulesManagement/allGroups', response.data.groups);
          store.set('modulesManagement/groupName', '');
          dispatch('snackbar/snackbarSuccess', 'Group removed', {
            root: true,
          });
          dispatch('getNavigationStructure');
        }
      });
  },

  //* When a Modules is selected, it loads its configuration.
  setselectedModule({ state }, index) {
    if (state.selectedModuleIndex !== index) {
      store.set('modulesManagement/selectedModuleIndex', index);
    }
  },

  //* Saves Modules configuration.
  async saveModule({ state, dispatch }, module) {
    //* Remove strange characters, add space instead.
    module.config.general_config.sql_query = module.config.general_config.sql_query
      .split(/\r?\n/)
      .map((row) => row.trim().split(/\s+/).join(' '))
      .join('\n')
      .replace(/(\r\n|\n|\r)/gm, ' ');

    return axios
      .put(`api/module/${module.id}`, module, {
        validateStatus(status) {
          return status === 200; // Resolve only if the status code is 200
        },
      })
      .then((response) => {
        if (response) {
          const index = state.allModules.findIndex((m) => m.id === module.id);
          store.set(`modulesManagement/allModules@${index}`, response.data.modules);
          store.set('modulesManagement/groupName', '');
          dispatch('snackbar/snackbarSuccess', 'Module saved', {
            root: true,
          });

          dispatch('getNavigationStructure');
          window.eventBus.$emit('BUS_BUILD_ROUTES');
          return true;
        }

        dispatch('snackbar/snackbarError', response.data.message, {
          root: true,
        });

        return false;
      });
  },

  //* Rollback changes before saving Modules configuration.
  rollbackChanges({ state, dispatch }, module) {
    const { origin } = module;
    const index = state.allModules.findIndex((m) => m.id === module.id);
    store.set(`modulesManagement/allModules@${index}`, {
      ...origin,
      origin: cloneDeep(origin),
    });

    //* Dispatch resetValidationStates action in validationStates module.
    //* This sets the validations to initial state values.
    dispatch('validationStatesModules/resetValidationStates', null, { root: true });
  },

  //* Soft removes a Modules (it can be restored).
  removeModule({ dispatch, rootState }, { id, method, apiPath }) {
    axios[method](`api/${apiPath}/${id}`)
      .then((response) => {
        if (response.status === 200) {
          store.set('modulesManagement/modulesLinkedToGroup', response.data.modules);
          store.set('modulesManagement/allModules', response.data.modules);
          dispatch('snackbar/snackbarSuccess', 'Modules removed', {
            root: true,
          });
          store.set('drawers/secureModulesDrawer', false);
          dispatch('getNavigationStructure');
          if (rootState.drawers.secureModulesDrawer) {
            store.set('drawers/secureModulesDrawer', false);
          }
        }
      })
      .catch((error) => {
        dispatch('snackbar/snackbarError', `${error.response.status} ${error.response.statusText}`, {
          root: true,
        });
      });
  },

  //* Creates a new Modules in the database.
  async createModules({ state, getters, dispatch }) {
    store.set('modulesManagement/loading', true);

    return axios
      .post('api/module', state.moduleSettings, {
        validateStatus(status) {
          return status === 200; // Resolve only if the status code is 200
        },
      })
      .then((response) => {
        store.set('modulesManagement/allModules', response.data.modules);

        //* Set the status tab as "all"
        store.set('modulesManagement/activeStatusTab', 0);
        store.set('modulesManagement/dialogModules', false);

        //!  REFACTOR AND USE NEW ACTION "selectGroup"
        const activeGroup = state.allGroups.find((item) => item.id === state.moduleSettings.module_group_id);
        const groupExists = state.selectedModuleGroups.find((item) => item.id === activeGroup.id);
        if (!groupExists) state.selectedModuleGroups.push(activeGroup);

        store.set('modulesManagement/modulesCardGroup', getters.allModulesFiltered.length - 1);
        store.set('modulesManagement/selectedModuleIndex', getters.allModulesFiltered.length - 1);
        store.set('modulesManagement/moduleSettings', initialmoduleSettings());

        dispatch('getNavigationStructure');

        dispatch('snackbar/snackbarSuccess', `"${state.moduleSettings.title}" Modules created`, {
          root: true,
        });

        store.set('modulesManagement/loading', false);

        return true;
      });
  },

  //* Creates a new role capability for a Modules.
  async createCapability({ dispatch }, capability) {
    return axios.post('api/capability', capability).then((response) => {
      if (response.status === 200) {
        dispatch('snackbar/snackbarSuccess', 'Capability added', {
          root: true,
        });
        return true;
      }
    });
  },

  async editCapabilitySaveChanges({ getters, dispatch }, capability) {
    capability.name = `${getters.selectedModule.name}.${capability.name}`;
    return axios.put(`api/capability/${capability.id}`, capability).then((response) => {
      if (response.status === 200) {
        dispatch('snackbar/snackbarSuccess', 'Capability edited', {
          root: true,
        });
        return true;
      }
    });
  },

  async removeCapability({ dispatch }, capability) {
    return axios.delete(`api/capability/${capability.id}`).then((response) => {
      if (response.status === 200) {
        dispatch('snackbar/snackbarSuccess', 'Capability removed', {
          root: true,
        });
        return true;
      }
    });
  },

  editCapability({ state }, item) {
    state.capability = item;
    state.editingCapability = true;
    state.capability.name = state.capability.name.replace('Test.', '');
  },

  //* Retrieves form field settings of the selected field  in Modules form field tab.
  setActiveField({ state }, field) {
    if (state.selectedModuleActiveField !== field) {
      store.set('modulesManagement/selectedModuleActiveField', field);
    }
  },

  //* Sets the Modules as starred, modular or active.
  setModuleStatus(_, module) {
    axios.patch(`api/module/${module.id}`, { status: module.status });
  },

  //* Sets the Modules as starred.
  setStarred({ dispatch }, module) {
    module.status.starred = !module.status.starred;
    module.origin.status.starred = !module.origin.status.starred;
    dispatch('setModuleStatus', module);
  },

  //* Sets the Modules as modular.
  setModular({ dispatch }, module) {
    module.status.modular = !module.status.modular;
    module.origin.status.modular = !module.origin.status.modular;
    dispatch('setModuleStatus', module);
  },

  //* Sets the Modules as active.
  setActive({ dispatch }, module) {
    module.status.active = !module.status.active;
    module.origin.status.active = !module.origin.status.active;
    dispatch('setModuleStatus', module);
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
