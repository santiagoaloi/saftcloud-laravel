import { store } from "@/store";
import { sync, call, get } from "vuex-pathify";

export default {
 name: "globalMixin",
 data() {
  return {
   loading: true,
   workspace: this.$route.name,
   elements: []
  };
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["allGroups", "selectedComponentGroups", "groupName", "groupParent", "allComponents"]),
  ...get("componentManagement", ["selectedAllGroups", "selectedSomeGroups", "hasSelectedComponentGroups", "countComponentsInGroup"]),

  formattedGroup() {
   if (this.groupName) return `"${this.groupName}"`;
  },

  icon() {
   if (this.selectedAllGroups) return "mdi-close-box";
   if (this.selectedSomeGroups) return "mdi-minus-box";
   return "mdi-checkbox-blank-outline";
  }
 },

 mounted() {
  this.getGroups();
 },

 methods: {
  ...call("componentManagement/*"),

  addGroupDialog() {
   this.$swal({
    title: `<span style="color:${this.isDark ? "lightgrey" : "black"} "> add group </span>`,
    showCancelButton: true,
    confirmButtonText: "Continue",
    cancelButtonText: "Cancel",
    confirmButtonColor: "#5469d4",
    customClass: {
     input: `${this.isDark ? "swalDarkTitle" : ""}`
    },
    input: "text",
    inputValue: this.groupName,
    backdrop: `${this.isDark ? "rgba(0, 0, 0, 0.6)" : "rgba(108, 122, 137, 0.8)"}`,
    background: `${this.isDark ? "#2f3136" : ""}`
   }).then(result => {
    if (result.value) {
     this.groupName = result.value;
     this.selectGroupParent();
    }
   });
  },

  selectGroupParent() {
   let fruits = ["Products", "test"];
   this.$swal({
    title: `<span style="color:${this.isDark ? "lightgrey" : "black"} "> Select Group Parent </span>`,
    showCancelButton: true,
    confirmButtonText: "Create group",
    cancelButtonText: "Back",
    confirmButtonColor: "#5469d4",
    customClass: {
     input: `${this.isDark ? "swalDarkSelect" : ""}`
    },
    input: "select",
    inputOptions: ["No Parent", ...fruits],
    backdrop: `${this.isDark ? "rgba(0, 0, 0, 0.6)" : "rgba(108, 122, 137, 0.8)"}`,
    background: `${this.isDark ? "#2f3136" : ""}`
   }).then(result => {
    if (result.value) {
     this.groupParent = result.value;
     this.saveGroup();
    } else if (result.dismiss === "cancel") {
     this.addGroupDialog();
    }
   });
  },

  renameGroupWarning(id, name) {
   this.$swal({
    title: `<span style="color:${this.isDark ? "lightgrey" : "black"} "> Edit group </span>`,
    showCancelButton: true,
    confirmButtonText: "Continue",
    cancelButtonText: "Cancel",
    confirmButtonColor: "#5469d4",
    customClass: {
     input: `${this.isDark ? "swalDarkTitle" : ""}`
    },
    input: "text",
    inputValue: name,
    backdrop: `${this.isDark ? "rgba(0, 0, 0, 0.6)" : "rgba(108, 122, 137, 0.8)"}`,
    background: `${this.isDark ? "#2f3136" : ""}`
   }).then(result => {
    if (result.value) {
     let newName = result.value;
     this.renameGroup({ id, newName });
    }
   });
  },

  removeGroupWarning(id, name) {
   this.$swal({
    title: `<span style="color:${this.isDark ? "lightgrey" : ""} "> Delete ${name} group? </span>`,
    html: `<span style="color:${this.isDark ? "lightgrey" : ""} ">  This action cannot be undone. </span>`,
    showCancelButton: true,
    confirmButtonText: "Delete",
    cancelButtonText: "Cancel",
    confirmButtonColor: "#EC407A",
    backdrop: `${this.isDark ? "rgba(0, 0, 0, 0.6)" : "rgba(108, 122, 137, 0.8)"}`,
    background: `${this.isDark ? "#2f3136" : ""}`
   }).then(result => {
    if (result.value) {
     this.removeGroup(id);
    }
   });
  },

  syncGroupInputValue(e) {
   store.set("componentManagement/groupName", e);
  }
 }
};
