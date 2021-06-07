import axios from "axios";
import { store } from "@/store";
import { make } from "vuex-pathify";
import isEqual from "lodash/isEqual";
import isEmpty from "lodash/isEmpty";

const initialComponentSettings = () => {
 return {
  name: "",
  note: "",
  table: "",
  title: "",
  prev_group_id: 0,
  component_group_id: 0
 };
};

const state = {
 search: "",
 dbTables: [],
 allGroups: [],
 tableColumns: [],
 allComponents: [],
 dialogGroup: false,
 activeStatusTab: 0,
 selectedComponent: {},
 componentCardGroup: 0,
 dialogComponent: false,
 selectedComponentGroups: [],
 groupSettings: {
  name: "",
  icon: "",
  total: "",
  folder: "",
  group_id: "",
  ordering: ""
 },
 componentSettings: initialComponentSettings(),
 componentStatusTabs: [
  { name: "All", value: "all", icon: "mdi-all-inclusive", color: "" },
  { name: "Starred", value: "starred", icon: "mdi-star", color: "" },
  { name: "Modular", value: "modular", icon: "mdi-view-module", color: "" },
  { name: "Active", value: "active", icon: "mdi-lightbulb-on", color: "blue darken-4" },
  { name: "Inactive", value: "inactive", icon: "mdi-lightbulb-on-outline", color: "black" }
 ]
};

const mutations = make.mutations(state);

const getters = {
 previousComponentDisabled: state => {
  return state.componentCardGroup === 0;
 },

 nextComponentDisabled: state => {
  return state.componentCardGroup === state.allComponents.length - 1;
 },

 selectedAllComponents: state => {
  return state.selectedComponentGroups.length === state.allGroups.length;
 },

 allComponentsFiltered: (state, getters) => {
  if (!getters.hasSelectedComponentGroups) return [];
  const search = state.search.toLowerCase();
  return state.allComponents.filter(component => {
   return (
    (search === "" || component.config.title.toLowerCase().match(search)) &&
    (getters.activeStatusTabName === "all" || component.config_settings.status[getters.activeStatusTabName]) &&
    state.selectedComponentGroups.some(g => g.id === component.component_group_id)
   );
  });
 },

 hasLoadedComponents: state => {
  return !isEmpty(state.allComponents);
 },

 hasSelectedComponent: state => {
  return !isEmpty(state.selectedComponent);
 },

 hasSelectedComponentGroups: state => {
  return !isEmpty(state.selectedComponentGroups);
 },

 selectedSomeComponents: (state, getters) => {
  if (getters.hasSelectedComponentGroups) return true;
  return false;
 },

 hasUnsavedChanges: (state, getters) => {
  if (getters.hasSelectedComponent) {
   const { origin, ...current } = state.selectedComponent;
   return !isEqual(origin, current);
  }
  return false;
 },

 isAllGroupsEmpty: state => {
  return state.allGroups.length === 0;
 },

 activeStatusTabName: state => {
  return state.componentStatusTabs[state.activeStatusTab].value;
 },

 isModularIcon: () => component => (component.config_settings.status.modular ? "mdi-view-module" : "mdi-view-module-outline"),
 isStarredIcon: () => component => (component.config_settings.status.starred ? "mdi-star" : "mdi-star-outline"),
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

 unselectGroup(index) {
  state.selectedComponentGroups.splice(index, 1);
 },

 selectAllGroups({ commit, state, getters }) {
  if (getters.selectedAllComponents) {
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

 saveComponent({ dispatch }, id, component) {
  axios.put(`api/Component/${id}`, component).then(response => {
   if (response.data.status) {
    dispatch("getComponents");
    store.set("snackbar/value", true);
    store.set("snackbar/text", "Component saved");
    store.set("snackbar/color", "indigo darken-1");
   }
  });
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
  axios.post("api/ComponentGroup", { name: state.groupSettings.name }).then(response => {
   if (response.data.status) {
    state.dialogGroup = false;
    commit("allGroups", response.data.groups);
    store.set("snackbar/value", true);
    store.set("snackbar/text", `Group "${state.groupSettings.name}" created`);
    store.set("snackbar/color", "indigo darken-1");
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
    store.set("snackbar/color", "indigo darken-1");
   }
  });
 },

 previousComponent({ state }) {
  if (state.componentCardGroup > 0) {
   state.componentCardGroup--;
  }
 },

 nextComponent({ state }) {
  if (state.componentCardGroup < state.allComponents.length - 1) {
   state.componentCardGroup++;
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
