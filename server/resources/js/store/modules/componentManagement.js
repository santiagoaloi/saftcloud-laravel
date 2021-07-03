import axios from "axios";
import { store } from "@/store";
import { make } from "vuex-pathify";
import isEqual from "lodash/isEqual";
import isEmpty from "lodash/isEmpty";
import cloneDeep from "lodash/cloneDeep";

const initialComponentSettings = () => {
 return {
  note: "",
  name: "",
  table: "",
  title: "",
  component_group_id: ""
 };
};

const state = {
 search: "",
 dbTables: [],
 dbTablesAndColumns: {},
 allGroups: [],
 groupName: "",
 tableColumns: [],
 searchFields: "",
 allComponents: [],
 dialogs: {
  dialogIcons: false,
  dialogComponent: false
 },
 activeStatusTab: 0,
 isTableLayout: false,
 componentEditSheet: false,
 selectedComponentIndex: 0,
 selectedComponentGroups: [],
 ComponentsConfigStructure: {},
 componentCardGroup: undefined,
 selectedComponentActiveField: "",
 displayEnabledFormFieldsOnly: false,
 componentEditDrawerActiveMenu: undefined,
 componentSettings: initialComponentSettings(),
 tableHeaders: [
  {
   text: "Component",
   align: "start",
   sortable: true,
   value: "config.name"
  }
 ],

 componentStatusTabs: [
  { name: "All", value: "all", icon: "mdi-all-inclusive", color: "" },
  { name: "Starred", value: "starred", icon: "mdi-star", color: "" },
  { name: "Modular", value: "modular", icon: "mdi-view-module", color: "" },
  { name: "Active", value: "active", icon: "mdi-lightbulb-on", color: "" }
 ]
};

const mutations = make.mutations(state);

const getters = {
 selectedComponent: (state, getters) => {
  return getters.allComponentsFiltered[state.selectedComponentIndex];
 },

 selectedComponentFormField: (state, getters) => {
  const index = getters.selectedComponent.config.form_fields.findIndex(f => f.field == state.selectedComponentActiveField);
  return getters.selectedComponent.config.form_fields[index];
 },

 previousComponentDisabled: state => {
  return state.componentCardGroup === 0;
 },

 nextComponentDisabled: (state, getters) => {
  return state.componentCardGroup === getters.allComponentsFiltered.length - 1;
 },

 selectedAllGroups: state => {
  return state.selectedComponentGroups.length === state.allGroups.length;
 },

 filteredFormFields: (state, getters) => {
  const searchFields = state.searchFields.toString().toLowerCase();
  return getters.selectedComponent.config.form_fields.filter(item => {
   return item.label.toLowerCase().match(searchFields);
  });
 },

 filteredSelectedFields: (state, getters) => {
  const searchFields = state.searchFields.toString().toLowerCase();
  return getters.selectedComponent.config.form_fields.filter(item => {
   return item.label.toLowerCase().match(searchFields) && item.displayField;
  });
 },

 allComponentsFiltered: (state, getters) => {
  if (!getters.hasSelectedComponentGroups) return [];
  const search = state.search.toLowerCase();
  return state.allComponents.filter(component => {
   return (
    (search === "" || component.config.title.toLowerCase().match(search)) &&
    (getters.activeStatusTabName === "all" || component.status[getters.activeStatusTabName]) &&
    state.selectedComponentGroups.some(g => g.id === component.component_group_id)
   );
  });
 },

 isComponentsEmpty: state => {
  return isEmpty(state.allComponents);
 },

 hasSelectedComponentGroups: state => {
  return !isEmpty(state.selectedComponentGroups);
 },

 selectedSomeGroups: (_state, getters) => {
  if (getters.hasSelectedComponentGroups) return true;
  return false;
 },

 hasUnsavedChanges: (_state, getters) => component => {
  if (getters.hasSelectedComponentGroups) {
   const { origin, ...current } = component;
   return !isEqual(origin, current);
  }
 },

 isAllGroupsEmpty: state => {
  return state.allGroups.length === 0;
 },

 isAllFilteredComponentsEmpty: (_, getters) => {
  return getters.allComponentsFiltered.length === 0;
 },

 activeStatusTabName: state => {
  return state.componentStatusTabs[state.activeStatusTab].value;
 },

 isStarredColor: () => component => (component.status.starred ? "orange" : "grey darken-1"),

 isStarredIcon: () => component => (component.status.starred ? "mdi-star" : "mdi-star-outline"),

 isActiveIcon: () => component => (component.status.active ? "mdi-lightbulb-on" : "mdi-lightbulb-on-outline"),

 isModularIcon: () => component => (component.status.modular ? "mdi-view-module" : "mdi-view-module-outline"),

 isActiveColor: (_, __, rootState) => component =>
  rootState.theme.isDark && component.status.active
   ? "indigo lighten-4"
   : !rootState.theme.isDark && component.status.active
   ? "indigo darken-4"
   : rootState.theme.isDark && !component.status.active
   ? "grey darken-1"
   : "black",

 isModularColor: (_, __, rootState) => component =>
  rootState.theme.isDark && component.status.modular
   ? "indigo lighten-4"
   : !rootState.theme.isDark && component.status.modular
   ? "indigo darken-4"
   : rootState.theme.isDark && !component.status.modular
   ? "grey darken-1"
   : "black",

 countComponentsInGroup: () => id => state.allComponents.filter(component => component.component_group_id === id).length
};

const actions = {
 ...make.actions(state),

 saveComponentsConfigStructure({ state, dispatch }) {
  axios.post("api/componentDefault", { config_structure: JSON.parse(state.ComponentsConfigStructure) }).then(response => {
   dispatch("getComponents");
   store.set("snackbar/value", true);
   store.set("snackbar/text", "Config structure updated");
   store.set("snackbar/color", "grey darken-2");
  });
 },

 getComponentsConfigStructure({ commit }) {
  axios.get("api/componentDefaultLast").then(response => {
   commit("ComponentsConfigStructure", JSON.stringify(response.data, null, 2));
  });
 },

 getDbTables({ commit }) {
  axios.get("api/showAllTables").then(response => {
   commit("dbTables", response.data);
  });
 },

 getDbTablesAndColumns({ commit }) {
  axios.get("api/showAllTablesAndColumns").then(response => {
   commit("dbTablesAndColumns", response.data.tableAndColumns);
  });
 },

 getGroups({ commit }) {
  axios.get("api/showAllGroups").then(response => {
   if (response.data.status) {
    commit("allGroups", response.data.groups);
   }
  });
 },

 unselectGroup({ state, commit }, id) {
  const selectedComponentGroups = state.selectedComponentGroups.filter(cg => cg.id !== id);
  commit("selectedComponentGroups", selectedComponentGroups);
 },

 selectAllGroups({ commit, state, getters }) {
  if (getters.selectedAllGroups) {
   commit("selectedComponentGroups", []);
  } else {
   commit("selectedComponentGroups", state.allGroups.slice());
  }
 },

 getComponents({ commit }) {
  axios.get("api/showAllComponents").then(response => {
   if (response.data.status) {
    commit("allComponents", response.data.components);
   }
  });
 },

 removeGroup({ commit }, id) {
  axios.delete(`api/ComponentGroup/${id}`).then(response => {
   if (response.data.status) {
    commit("allGroups", response.data.groups);
    store.set("snackbar/value", true);
    store.set("snackbar/text", "Group removed");
    store.set("snackbar/color", "pink darken-1");
   }
  });
 },

 renameGroup({ commit }, { id, newName }) {
  axios.patch(`api/ComponentGroup/${id}`, { name: newName }).then(response => {
   if (response.data.status) {
    commit("allGroups", response.data.groups);
    store.set("snackbar/value", true);
    store.set("snackbar/text", "Group renamed");
    store.set("snackbar/color", "grey darken-2");
   }
  });
 },

 setSelectedComponent({ rootState, state }, index) {
  if (!rootState.drawers.secureComponentDrawer) {
   store.set("drawers/secureComponentDrawer", true);
  }
  if (state.selectedComponentIndex != index) {
   store.set("componentManagement/selectedComponentIndex", index);
  }
 },

 setActiveField({ state }, field) {
  if (state.selectedComponentActiveField != field) {
   store.set("componentManagement/selectedComponentActiveField", field);
  }
 },

 setComponentStatus({}, component) {
  axios.patch(`api/component/${component.id}`, { status: component.status });
 },

 saveComponent({ state }, component) {
  //Remove strange characters, add space instead.
  component.config.sql_query = component.config.sql_query
   .split(/\r?\n/)
   .map(row =>
    row
     .trim()
     .split(/\s+/)
     .join(" ")
   )
   .join("\n")
   .replace(/(\r\n|\n|\r)/gm, " ");

  axios.put(`api/component/${component.id}`, component).then(response => {
   if (response.data.status) {
    const index = state.allComponents.findIndex(c => c.id == component.id);
    store.set(`componentManagement/allComponents@${index}`, response.data.component);
    store.set("snackbar/value", true);
    store.set("snackbar/text", "Component saved");
    store.set("snackbar/color", "grey darken-2");
   } else {
    store.set("snackbar/value", true);
    store.set("snackbar/text", response.data.message);
    store.set("snackbar/color", "pink darken-1");
   }
  });
 },

 rollbackChanges({ state }, component) {
  const { origin } = component;
  const index = state.allComponents.findIndex(c => c.id === component.id);
  store.set(`componentManagement/allComponents@${index}`, { ...origin, origin: cloneDeep(origin) });
 },

 removeComponent({ commit }, id) {
  axios.delete(`api/component/${id}`).then(response => {
   if (response.data.status) {
    commit("allComponents", response.data.components);
    store.set("snackbar/value", true);
    store.set("snackbar/text", "Component removed");
    store.set("snackbar/color", "pink darken-1");
   }
  });
 },

 saveGroup({ state, commit }) {
  axios.post("api/ComponentGroup", { name: state.groupName }).then(response => {
   if (response.data.status) {
    state.dialogs.dialogGroup = false;
    commit("allGroups", response.data.groups);
    store.set("componentManagement/groupName", null);
    store.set("snackbar/value", true);
    store.set("snackbar/text", `Group "${state.groupName}" created`);
    store.set("snackbar/color", "grey darken-2");
   }
  });
 },

 createComponent({ state, commit, getters }) {
  axios.post("api/Component", state.componentSettings).then(response => {
   if (response.data.status) {
    commit("allComponents", response.data.components);
    state.dialogs.dialogComponent = false;
    store.set("snackbar/value", true);
    store.set("snackbar/text", `"${state.componentSettings.title}" component created`);
    store.set("snackbar/color", "indigo darken-2");

    // Autoselect latest created component
    store.set("drawers/secureComponentDrawer", true);

    const activeGroup = state.allGroups.find(item => item.id === state.componentSettings.component_group_id);
    const groupExists = state.selectedComponentGroups.find(item => item.id === activeGroup.id);

    if (!groupExists) state.selectedComponentGroups.push(activeGroup);

    store.set("componentManagement/componentCardGroup", getters.allComponentsFiltered.length - 1);
    store.set("componentManagement/selectedComponentIndex", state.allComponents.length - 1);
    state.componentSettings = initialComponentSettings();
   }
  });
 },

 previousComponent({ state }) {
  if (state.componentCardGroup > 0) {
   state.componentCardGroup--;
   state.selectedComponentIndex--;
  }
 },

 nextComponent({ state, getters }) {
  if (state.componentCardGroup < getters.allComponentsFiltered.length - 1) {
   state.componentCardGroup++;
   state.selectedComponentIndex++;
  }
 }
};

export default {
 namespaced: true,
 state,
 mutations,
 actions,
 getters
};
