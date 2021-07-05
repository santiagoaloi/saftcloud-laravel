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
 dbGroupNames: [],
 allGroups: [],
 groupName: "",
 groupParent: "",
 tableColumns: [],
 searchFields: "",
 allComponents: [],
 dialogComponent: false,
 dialogIcons: false,
 activeStatusTab: 0,
 isTableLayout: false,
 componentEditSheet: false,
 selectedFieldItemGroup: 0,
 selectedComponentIndex: 0,
 showSelectedFieldsOnly: false,
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
 ],

 //  navigationStructure: {
 //   menu: [
 //    {
 //     items: [
 //      {
 //       name: "Products",
 //       icon: "mdi-file-outline",
 //       items: [
 //        { icon: "mdi-file-outline", name: "Child  2.1", link: "/" },
 //        {
 //         icon: "mdi-file-outline",
 //         name: "Sub-Child 2.2 ",
 //         items: [
 //          { icon: "mdi-file-outline", name: "Menu Levels 3.1", link: "/" },
 //          { icon: "mdi-file-outline", name: "Menu Levels 3.2", link: "/" }
 //         ]
 //        }
 //       ]
 //      }
 //     ]
 //    }
 //   ]
 //  }
 navigationStructure: {}
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

 hasUnsavedChanges: (_, getters) => component => {
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

 countComponentsInGroup: state => id => state.allComponents.filter(component => component.component_group_id === id).length
};

const actions = {
 ...make.actions(state),

 closeComponentDialog({}) {
  store.set("componentManagement/dialogComponent", false);
 },

 saveComponentsConfigStructure({ state, dispatch }) {
  axios.post("api/componentDefault", { config_structure: JSON.parse(state.ComponentsConfigStructure) }).then(response => {
   dispatch("getComponents");
   dispatch("getNavigationStructure");
   store.set("snackbar/value", true);
   store.set("snackbar/text", "Config structure updated");
   store.set("snackbar/color", "grey darken-2");
  });
 },

 getComponentsConfigStructure({}) {
  axios.get("api/componentDefaultLast").then(response => {
   store.set("componentManagement/ComponentsConfigStructure", JSON.stringify(response.data, null, 2));
  });
 },

 getDbTables({}) {
  axios.get("api/showAllTables").then(response => {
   store.set("componentManagement/dbTables", response.data);
  });
 },

 getDbTablesAndColumns({}) {
  axios.get("api/showAllTablesAndColumns").then(response => {
   store.set("componentManagement/dbTablesAndColumns", response.data.tableAndColumns);
  });
 },

 getDbGroupNames({}) {
  axios
   .get("api/showAllGroupNames")
   .then(response => {
    store.set("componentManagement/dbGroupNames", response.data);
   })
   .catch(error => {
    store.set("componentManagement/dbGroupNames", []);
   });
 },

 getNavigationStructure({}) {
  axios
   .get("api/getNavigationStructure")
   .then(response => {
    store.set("componentManagement/navigationStructure", response.data);
   })
   .catch(error => {
    store.set("componentManagement/navigationStructure", {});
   });
 },

 getGroups({}) {
  axios.get("api/showAllGroups").then(response => {
   if (response.data.status) {
    store.set("componentManagement/allGroups", response.data.groups);
   }
  });
 },

 unselectGroup({ state }, id) {
  const selectedComponentGroups = state.selectedComponentGroups.filter(cg => cg.id !== id);
  store.set("componentManagement/selectedComponentGroups", selectedComponentGroups);
 },

 selectAllGroups({ state, getters }) {
  if (getters.selectedAllGroups) {
   store.set("componentManagement/selectedComponentGroups", []);
  } else {
   store.set("componentManagement/selectedComponentGroups", state.allGroups.slice());
  }
 },

 getComponents({}) {
  axios.get("api/showAllComponents").then(response => {
   if (response.data.status) {
    store.set("componentManagement/allComponents", response.data.components);
   }
  });
 },

 removeGroup({ dispatch }, id) {
  axios.delete(`api/componentGroup/${id}`).then(response => {
   if (response.data.status) {
    store.set("componentManagement/allGroups", response.data.groups);
    store.set("snackbar/value", true);
    store.set("snackbar/text", "Group removed");
    store.set("snackbar/color", "pink darken-1");
    dispatch("getNavigationStructure");
   }
  });
 },

 renameGroup({}, { id, newName }) {
  axios.patch(`api/componentGroup/${id}`, { name: newName }).then(response => {
   if (response.data.status) {
    store.set("componentManagement/allGroups", response.data.groups);
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

 removeComponent({}, id) {
  axios.delete(`api/component/${id}`).then(response => {
   if (response.data.status) {
    store.set("componentManagement/allComponents", response.data.components);
    store.set("snackbar/value", true);
    store.set("snackbar/text", "Component removed");
    store.set("snackbar/color", "pink darken-1");
   }
  });
 },

 saveGroup({ state, dispatch }) {
  // store.set("componentManagement/groupName", "");
  // store.set("componentManagement/groupParent", "");

  let parent;
  if (state.groupParent === "No Parent") {
   parent = null;
  } else {
   parent = state.allGroups.find(g => g.name === state.dbGroupNames[state.groupParent - 1]);
  }

  alert(parent);

  axios.post("api/componentGroup", { name: state.groupName, component_group_id: parent.id }).then(response => {
   if (response.data.status) {
    store.set("componentManagement/allGroups", response.data.groups);
    store.set("componentManagement/groupName", "");
    store.set("componentManagement/groupChild", "");
    store.set("snackbar/value", true);
    store.set("snackbar/text", `Group "${state.groupName}" created`);
    store.set("snackbar/color", "grey darken-2");
    dispatch("getNavigationStructure");
   }
  });
 },

 createComponent({ state, getters }) {
  axios.post("api/component", state.componentSettings).then(response => {
   if (response.data.status) {
    store.set("componentManagement/allComponents", response.data.components);
    store.set("componentManagement/dialogComponent", false);
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
    store.set("componentManagement/componentSettings", state.initialComponentSettings());
   }
  });
 },

 previousComponent({ state }) {
  if (state.componentCardGroup > 0) {
   store.set("componentManagement/componentCardGroup", state.componentCardGroup - 1);
   store.set("componentManagement/selectedComponentIndex", state.selectedComponentIndex - 1);
  }
 },

 nextComponent({ state, getters }) {
  if (state.componentCardGroup < getters.allComponentsFiltered.length - 1) {
   store.set("componentManagement/componentCardGroup", state.componentCardGroup + 1);
   store.set("componentManagement/selectedComponentIndex", state.selectedComponentIndex + 1);
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
