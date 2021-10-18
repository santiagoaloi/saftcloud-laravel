import { make } from 'vuex-pathify';
import { isEqual, isEmpty, cloneDeep } from 'lodash';
import axios from 'axios';
import { store } from '@/store';

// When this function is called, the component settings form is back to default values.
const initialComponentSettings = () => ({
  note: '',
  name: '',
  table: '',
  title: '',
  component_group_id: '',
});

const state = {
  editingCapability: false,
  capability: {},
  dbTables: [],
  allGroups: [],
  groupName: '',
  groupParent: 0,
  tableColumns: [],
  dbGroupNames: [],
  searchFields: '',
  allComponents: [],
  activeStatusTab: 0,
  dialogEditor: false,
  isTableLayout: false,
  activeFormFieldTab: 0,
  componentCardGroup: 0,
  dialogComponent: false,
  dialogCapability: false,
  dbTablesAndColumns: {},
  componentEditSheet: false,
  groupNameBeingRemoved: '',
  selectedFieldItemGroup: 0,
  selectedComponentIndex: 0,
  componentsLinkedToGroup: [],
  selectedComponentGroups: [],
  showSelectedFieldsOnly: false,
  componentsConfigStructure: {},
  selectedComponentTableRow: [],
  selectedComponentActiveField: '',
  displayEnabledFormFieldsOnly: false,
  componentEditDrawerActiveMenu: undefined,
  componentSettings: initialComponentSettings(),
  componentStatusTabs: [
    { name: 'All', value: 'all', icon: 'mdi-all-inclusive' },
    { name: 'Starred', value: 'starred', icon: 'mdi-star' },
    { name: 'Active', value: 'active', icon: 'mdi-lightbulb-on' },
    { name: 'Inactive', value: 'inactive', icon: 'mdi-lightbulb-off' },
    { name: 'Modular', value: 'modular', icon: 'mdi-view-module' },
    { name: 'Sidebar', value: 'navigation', icon: 'mdi-menu' },
  ],
  navigationStructure: {},
  componentsLinkedToGroupDialog: false,
};

const mutations = make.mutations(state);

const getters = {
  //* returns true if at least one validation did not succeed.
  hasValidationErrors: (_, __, rootState) =>
    Object.values(rootState.validationStates).some((innerObj) =>
      Object.values(innerObj).includes(true),
    ),

  //* returns the group name where this component belongs.
  mapComponentGroup: (state, getters) => (component) => {
    if (getters.isAllGroupsEmpty) return;
    return state.allGroups.find((g) => g.id === component.component_group_id);
  },

  //* returns the parent group name where this component belongs.
  mapGroupParent: (state, getters) => (component) => {
    if (getters.isAllGroupsEmpty) return;
    const parentGroupId = state.allGroups.find(
      (g) => g.id === component.component_group_id,
    ).component_group_id;
    return state.allGroups.find((g) => g.id === parentGroupId).name;
  },

  //* Loads all the configuration of the selected component.
  selectedComponent: (state, getters) =>
    getters.allComponentsFiltered[state.selectedComponentIndex],

  //* Loads all the field settings of the selected field in component form field tab.
  selectedComponentFormField: (state, getters) => {
    if (getters.selectedComponent) {
      const index = getters.selectedComponent.config.form_fields.findIndex(
        (f) => f.field === state.selectedComponentActiveField,
      );
      return getters.selectedComponent.config.form_fields[index];
    }
  },

  //* Disables the right panel navigation arrows if the first component in the array is selected.
  previousComponentDisabled: (state) => state.componentCardGroup === 0,

  //* Disables the right panel navigation arrows if the last component in the array is selected.
  nextComponentDisabled: (state, getters) =>
    state.componentCardGroup === getters.allComponentsFiltered.length - 1,

  //* Returns form fields matching the search string typed.
  filteredFormFields: (state, getters) => {
    if (getters.selectedComponent) {
      const searchFields = state.searchFields.toString().toLowerCase();
      return getters.selectedComponent.config.form_fields.filter((field) =>
        field.label.toLowerCase().match(searchFields),
      );
    }
  },

  //* Returns form fields that are set to be displayed in the component.
  filteredSelectedFields: (state, getters) => {
    if (getters.selectedComponent) {
      const searchFields = state.searchFields.toString().toLowerCase();
      return getters.selectedComponent.config.form_fields.filter(
        (field) => field.label.toLowerCase().match(searchFields) && field.displayField,
      );
    }
  },

  //* Returns the name of the tab name selected within the form field editor
  activeComponentTabName: (state) => state.componentStatusTabs[state.activeStatusTab].value,

  //* Returns components that belongs to a group, status or matching search string.
  allComponentsFiltered: (state, getters, rootState) => {
    if (!getters.hasSelectedSomeGroups) return {};
    return state.allComponents.filter((component) => {
      const search = rootState.application.search.toLowerCase();
      const title = component.config.general_config.title.toLowerCase();
      const status = getters.activeComponentTabName;
      return (
        (!search || title.match(search)) &&
        (status === 'all' ||
          (status === 'inactive' && !component.status.active) ||
          (status === 'navigation' && component.config.general_config.isVisibleInSidebar) ||
          component.status[status]) &&
        state.selectedComponentGroups.some((group) => group.id === component.component_group_id)
      );
    });
  },

  //* Returns true if there are no components fetched from the backend.
  isComponentsEmpty: (state) => isEmpty(state.allComponents),

  //* Returns true if there are no component groups defined in the groups array.
  isAllGroupsEmpty: (state) => state.allGroups.length === 0,

  //* Returns true if all groups in the component group dropdown are selected.
  hasSelectedAllGroups: (state) => state.selectedComponentGroups.length === state.allGroups.length,

  //* Returns true if one or more component groups in the component group dropdown are selected.
  hasSelectedSomeGroups: () => {
    if (isEmpty(state.selectedComponentGroups)) return true;
    return false;
  },

  //* Returns true if the component has unsaved changes.
  hasUnsavedChanges: (_, getters) => (component) => {
    if (getters.hasSelectedSomeGroups) {
      const { origin, ...current } = component;
      return !isEqual(origin, current);
    }
  },

  //* Returns true if the current groups selected do not contain any components associated to them.
  isAllFilteredComponentsEmpty: (_, getters) => getters.allComponentsFiltered.length === 0,

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

  //* Returns the modular icon depending on its state.
  isModularIcon: () => (component) =>
    component.status.modular ? 'mdi-view-module' : 'mdi-view-module-outline',

  //* Returns color of the card modular icon in the grid view, depending on the theme settings.
  isModularColor: (_, __, rootState) => (component) =>
    rootState.theme.isDark && component.status.modular
      ? 'indigo lighten-4'
      : !rootState.theme.isDark && component.status.modular
      ? 'indigo darken-4'
      : rootState.theme.isDark && !component.status.modular
      ? 'grey darken-1'
      : 'black',

  //* Returns the count of components belonging to a specific group.
  countComponentsInGroup: (state) => (id) =>
    state.allComponents.filter((component) => component.component_group_id === id).length,

  countComponentsFiltered: (_, getters) => getters.allComponentsFiltered.length,
};

const actions = {
  ...make.actions(state),

  //* Saves the component configuration structure as a new version of the configuration (version control).
  saveComponentsConfigStructure({ state, dispatch }) {
    return axios
      .post('api/componentDefault', {
        config_structure: JSON.parse(state.componentsConfigStructure),
      })
      .then(() => {
        dispatch('getComponents');
        dispatch('getNavigationStructure');
        store.set('snackbar/value', true);
        store.set('snackbar/text', 'Config structure updated');
        store.set('snackbar/color', 'primary');
      });
  },

  //* Retrieves the last record of the component configuration structure.
  getComponentsConfigStructure() {
    axios.get('api/componentDefaultLast').then((response) => {
      store.set(
        'componentManagement/componentsConfigStructure',
        JSON.stringify(response.data, null, 2),
      );
    });
  },

  //* Retrieves all avaiable tables from the database.
  getDbTables() {
    axios.get('api/getAllTables').then((response) => {
      store.set('componentManagement/dbTables', response.data);
    });
  },

  //* Retrieves all avaiable tables and its corresponding columns from the database.
  getDbTablesAndColumns() {
    axios.get('api/getAllTablesAndColumns').then((response) => {
      store.set('componentManagement/dbTablesAndColumns', response.data.tableAndColumns);
    });
  },

  //* Retrieves all avaiable group names from the database.
  getDbGroupNames() {
    axios
      .get('api/getAllGroupNames')
      .then((response) => {
        store.set('componentManagement/dbGroupNames', response.data);
      })
      .catch(() => {
        store.set('componentManagement/dbGroupNames', []);
      });
  },

  //* Retrieves the navigation structure for the secure drawer.
  getNavigationStructure() {
    axios.get('api/getNavigationStructure').then((response) => {
      store.set('componentManagement/navigationStructure', response.data.navigationStructure);
    });
  },

  //* Retrieves the component groups.
  getGroups() {
    axios.get('api/getAllGroups').then((response) => {
      if (response.status === 200) {
        store.set('componentManagement/allGroups', response.data.groups);
      }
    });
  },

  //* Unselects a group in the components view.
  unselectGroup({ state }, id) {
    const selectedComponentGroups = state.selectedComponentGroups.filter((cg) => cg.id !== id);
    store.set('componentManagement/selectedComponentGroups', selectedComponentGroups);
  },

  //* Selects all the available groups in the components view.
  selectAllGroups({ state, getters }) {
    if (getters.hasSelectedAllGroups) {
      store.set('componentManagement/selectedComponentGroups', []);
    } else {
      store.set('componentManagement/selectedComponentGroups', state.allGroups.slice());
    }
  },

  //* Retrieves all available componentes from the database.
  getComponents() {
    axios.get('api/getAllComponents').then((response) => {
      if (response.status === 200) {
        store.set('componentManagement/allComponents', response.data.components);
      }
    });
  },

  //* Soft removes a component group (it can be restored).
  removeGroup({ dispatch }, id) {
    axios
      .delete(`api/componentGroup/${id}`)
      .then((response) => {
        if (response.status === 200) {
          if (response.data.components && response.data.components.length) {
            store.set('componentManagement/componentsLinkedToGroup', response.data.components);
            store.set('componentManagement/componentsLinkedToGroupDialog', true);
          } else {
            dispatch('unselectGroup', id);
          }
          if (response.data.groups) {
            store.set('componentManagement/allGroups', response.data.groups);
            store.set('snackbar/value', true);
            store.set('snackbar/text', 'Group removed');
            store.set('snackbar/color', 'primary');

            dispatch('getDbGroupNames');
            dispatch('getNavigationStructure');
            dispatch('getGroups');
          }
        }
      })
      .catch((error) => {
        console.log({ ...error });
      });
  },

  //* Saves the component group configuration settings.
  saveGroup({ state, dispatch }) {
    const parent = state.allGroups.find(
      (g) => g.name === state.dbGroupNames[state.groupParent - 1],
    );
    axios
      .post('api/componentGroup', {
        name: state.groupName,
        component_group_id: parent ? parent.id : null,
      })
      .then((response) => {
        if (response.status === 200) {
          store.set('componentManagement/allGroups', response.data.groups);
          store.set('snackbar/value', true);
          store.set('snackbar/text', `Group "${state.groupName}" created`);
          store.set('snackbar/color', 'primary');
          store.set('componentManagement/groupName', '');
          //  store.set("componentManagement/groupChild", "");
          store.set('componentManagement/groupParent', 0);
          dispatch('getNavigationStructure');
          dispatch('getDbGroupNames');
          dispatch('getGroups');
        }
      })
      .catch((error) => {
        store.set('snackbar/value', true);
        store.set('snackbar/text', `${error.response.status} ${error.response.statusText}`);
        store.set('snackbar/color', 'pink darken-1');
      });
  },

  //* Renames the component group.
  renameGroup({ dispatch, state }, { id, groupParent }) {
    const parent = state.allGroups[groupParent].id;
    axios
      .put(`api/componentGroup/${id}`, {
        name: state.groupName,
        component_group_id: parent === id ? null : parent,
      })
      .then((response) => {
        if (response.status === 200) {
          store.set('componentManagement/allGroups', response.data.groups);
          store.set('componentManagement/groupName', '');
          store.set('snackbar/value', true);
          store.set('snackbar/text', 'Group renamed');
          store.set('snackbar/color', 'primary');
          dispatch('getNavigationStructure');
        }
      });
  },

  //* When a component is selected in the components view, it loads its configuration.
  setSelectedComponent({ rootState, state }, index) {
    if (state.selectedComponentIndex !== index) {
      store.set('componentManagement/selectedComponentIndex', index);
    }

    if (!rootState.drawers.secureComponentDrawer) {
      store.set('drawers/secureComponentDrawer', true);
    }
  },

  //* Saves component configuration.
  saveComponent({ state, dispatch }, component) {
    //* Remove strange characters, add space instead.
    component.config.general_config.sql_query = component.config.general_config.sql_query
      .split(/\r?\n/)
      .map((row) => row.trim().split(/\s+/).join(' '))
      .join('\n')
      .replace(/(\r\n|\n|\r)/gm, ' ');

    return axios.put(`api/component/${component.id}`, component).then((response) => {
      if (response.status === 200) {
        const index = state.allComponents.findIndex((c) => c.id == component.id);
        store.set(`componentManagement/allComponents@${index}`, response.data.component);
        store.set('snackbar/value', true);
        store.set('snackbar/text', 'Component saved');
        store.set('snackbar/color', 'primary');

        dispatch('getNavigationStructure');
        window.eventBus.$emit('BUS_BUILD_ROUTES');
        return true;
      }
      store.set('snackbar/value', true);
      store.set('snackbar/text', response.data.message);
      store.set('snackbar/color', 'pink darken-1');
      return false;
    });
  },

  //* Rollback changes before saving component configuration.
  rollbackChanges({ state, dispatch }, component) {
    const { origin } = component;
    const index = state.allComponents.findIndex((c) => c.id === component.id);
    store.set(`componentManagement/allComponents@${index}`, {
      ...origin,
      origin: cloneDeep(origin),
    });

    //* Dispatch resetValidationStates action in validationStates module.
    //* This sets the validations to initial state values.
    dispatch('validationStates/resetValidationStates', null, { root: true });
  },

  //* Soft removes a component (it can be restored).
  removeComponent({ dispatch, rootState }, { id, method, apiPath }) {
    axios[method](`api/${apiPath}/${id}`)
      .then((response) => {
        if (response.status === 200) {
          store.set('componentManagement/componentsLinkedToGroup', response.data.components);
          store.set('componentManagement/allComponents', response.data.components);
          store.set('snackbar/value', true);
          store.set('snackbar/text', 'Component removed');
          store.set('snackbar/color', 'primary');
          store.set('drawers/secureComponentDrawer', false);
          dispatch('getNavigationStructure');
          if (rootState.drawers.secureComponentDrawer) {
            store.set('drawers/secureComponentDrawer', false);
          }
        }
      })
      .catch((error) => {
        console.log({ ...error });
        store.set('snackbar/value', true);
        store.set('snackbar/text', `${error.response.status} ${error.response.statusText}`);
        store.set('snackbar/color', 'pink darken-1');
      });
  },

  //* Creates a new component in the database.
  createComponent({ state, getters, dispatch }) {
    return axios.post('api/component', state.componentSettings).then((response) => {
      if (response.status === 200) {
        store.set('componentManagement/allComponents', response.data.components);
        store.set('snackbar/value', true);
        store.set('snackbar/text', `"${state.componentSettings.title}" component created`);
        store.set('snackbar/color', 'primary');

        //* Set the status tab as "all"
        state.activeStatusTab = 0;

        store.set('componentManagement/dialogComponent', false);

        //* Autoselect latest created component
        const activeGroup = state.allGroups.find(
          (item) => item.id === state.componentSettings.component_group_id,
        );

        const groupExists = state.selectedComponentGroups.find(
          (item) => item.id === activeGroup.id,
        );

        if (!groupExists) state.selectedComponentGroups.push(activeGroup);

        store.set(
          'componentManagement/componentCardGroup',
          getters.allComponentsFiltered.length - 1,
        );

        store.set(
          'componentManagement/selectedComponentIndex',
          getters.allComponentsFiltered.length - 1,
        );

        store.set('componentManagement/componentSettings', initialComponentSettings());

        dispatch('getNavigationStructure');
        return true;
      }
    });
  },

  //* Creates a new role capability for a component.
  createCapability({ getters }, capability) {
    return axios.post('api/capability', capability).then((response) => {
      if (response.status === 200) {
        store.set('snackbar/value', true);
        store.set('snackbar/text', 'Capability added');
        store.set('snackbar/color', 'primary');
        return true;
      }
    });
  },

  editCapabilitySaveChanges({ getters }, capability) {
    capability.name = `${getters.selectedComponent.name}.${capability.name}`;
    return axios.put(`api/capability/${capability.id}`, capability).then((response) => {
      if (response.status === 200) {
        store.set('snackbar/value', true);
        store.set('snackbar/text', 'Capability edited');
        store.set('snackbar/color', 'primary');
        return true;
      }
    });
  },

  removeCapability({}, capability) {
    return axios.delete(`api/capability/${capability.id}`).then((response) => {
      if (response.status === 200) {
        store.set('snackbar/value', true);
        store.set('snackbar/text', 'Capability removed');
        store.set('snackbar/color', 'primary');
        return true;
      }
    });
  },

  editCapability({ state }, item) {
    state.editingCapability = true;
    state.capability = item;
    state.capability.name = state.capability.name.replace('Test.', '');
  },

  //* Moves to the previous component in the array (navigation arrows).
  previousComponent({ state }) {
    if (state.componentCardGroup > 0) {
      store.set('componentManagement/componentCardGroup', state.componentCardGroup - 1);
      store.set('componentManagement/selectedComponentIndex', state.selectedComponentIndex - 1);
    }
  },

  //* Moves to the next component in the array (navigation arrows).
  nextComponent({ state, getters }) {
    if (state.componentCardGroup < getters.allComponentsFiltered.length - 1) {
      store.set('componentManagement/componentCardGroup', state.componentCardGroup + 1);
      store.set('componentManagement/selectedComponentIndex', state.selectedComponentIndex + 1);
    }
  },

  //* Retrieves form field settings of the selected field  in component form field tab.
  setActiveField({ state }, field) {
    if (state.selectedComponentActiveField !== field) {
      store.set('componentManagement/selectedComponentActiveField', field);
    }
  },

  //* Sets the component as starred, modular or active.
  setComponentStatus(component) {
    axios.patch(`api/component/${component.id}`, { status: component.status });
  },

  //* Sets the component as starred.
  setStarred({ dispatch }, component) {
    component.status.starred = !component.status.starred;
    component.origin.status.starred = !component.origin.status.starred;
    dispatch('setComponentStatus', component);
  },

  //* Sets the component as modular.
  setModular({ dispatch }, component) {
    component.status.modular = !component.status.modular;
    component.origin.status.modular = !component.origin.status.modular;
    dispatch('setComponentStatus', component);
  },

  //* Sets the component as active.
  setActive({ dispatch }, component) {
    component.status.active = !component.status.active;
    component.origin.status.active = !component.origin.status.active;
    dispatch('setComponentStatus', component);
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};
