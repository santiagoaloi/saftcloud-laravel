import axios from "axios";
import { store } from "@/store";
import { make } from "vuex-pathify";
import isEqual from "lodash/isEqual";
import isEmpty from "lodash/isEmpty";
import cloneDeep from "lodash/cloneDeep";

const initialComponentSettings = () => {
 return {
  name: "",
  note: "",
  table: "",
  title: "",
  component_group_id: ""
 };
};

const state = {
 search: "",
 dbTables: [],
 allGroups: [],
 tableColumns: [],
 allComponents: [],
 dialogGroup: false,
 dialogIcons: false,
 activeStatusTab: 0,
 dialogComponent: false,
 componentEditSheet: false,
 componentCardGroup: undefined,
 selectedComponentIndex: 0,
 selectedComponentGroups: [],
 groupName: "",
 isTableLayout: false,
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

 previousComponentDisabled: state => {
  return state.componentCardGroup === 0;
 },

 nextComponentDisabled: (state, getters) => {
  return state.componentCardGroup === getters.allComponentsFiltered.length - 1;
 },

 selectedAllGroups: state => {
  return state.selectedComponentGroups.length === state.allGroups.length;
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

 isStarredIcon: () => component => (component.status.starred ? "mdi-star" : "mdi-star-outline"),
 isActiveIcon: () => component => (component.status.active ? "mdi-lightbulb-on" : "mdi-lightbulb-on-outline"),
 isModularIcon: () => component => (component.status.modular ? "mdi-view-module" : "mdi-view-module-outline"),

 isStarredColor: () => component => (component.status.starred ? "orange" : "grey darken-1"),

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
 getDbTables({ commit }) {
  axios.get("api/showAllTables").then(response => {
   commit("dbTables", response.data);
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

 renameGroup({ commit }, { id, name }) {
  axios.patch(`api/ComponentGroup/${id}`, { name: name }).then(response => {
   if (response.data.status) {
    commit("allGroups", response.data.groups);
    store.set("snackbar/value", true);
    store.set("snackbar/text", "Group renamed");
    store.set("snackbar/color", "grey darken-2");
   }
  });
 },

 setComponentStatus({}, component) {
  axios.patch(`api/Component/${component.id}`, { sztatus: component.status });
 },

 saveComponent({ state }, component) {
  axios.put(`api/Component/${component.id}`, component).then(response => {
   if (response.data.status) {
    const index = state.allComponents.findIndex(c => c.id == component.id);
    store.set(`componentManagement/allComponents@${index}`, response.data.component);
    store.set("snackbar/value", true);
    store.set("snackbar/text", "Component saved");
    store.set("snackbar/color", "grey darken-2");
   }
  });
 },

 rollbackChanges({ state }, component) {
  const { origin } = component;
  const index = state.allComponents.findIndex(c => c.id === component.id);
  store.set(`componentManagement/allComponents@${index}`, { ...origin, origin: cloneDeep(origin) });
 },

 removeComponent({ commit }, id) {
  axios.delete(`api/Component/${id}`).then(response => {
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
    state.dialogGroup = false;
    commit("allGroups", response.data.groups);
    store.set("componentManagement/groupName", "");
    store.set(`componentManagement/allComponents@${index}`, response.data.component);
    store.set("snackbar/value", true);
    store.set("snackbar/text", `Group "${state.groupName}" created`);
    store.set("snackbar/color", "grey darken-2");
   }
  });
 },

 createComponent({ state, commit }) {
  axios.post("api/Component", state.componentSettings).then(response => {
   if (response.data.status) {
    commit("allComponents", response.data.components);
    state.dialogComponent = false;
    state.componentSettings = initialComponentSettings();
    store.set("snackbar/value", true);
    store.set("snackbar/text", "Component created");
    store.set("snackbar/color", "grey darken-2");
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
