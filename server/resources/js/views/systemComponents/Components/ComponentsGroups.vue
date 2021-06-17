<template>
 <v-card color="transparent" flat class="mt-8">
  <v-row align="center">
   <v-col cols="12" sm="4">
    <small>Component groups</small>
    <v-autocomplete
     @update:search-input="syncGroupInputValue($event)"
     solo
     v-model="selectedComponentGroups"
     :items="allGroups"
     multiple
     :maxlength="25"
     item-value="id"
     item-text="name"
     return-object
     placeholder="Select or create groups"
     hide-selected
     color="primary"
     item-color="primary"
     :menu-props="{
      transition: 'slide-y-transition'
     }"
    >
     <template v-if="allGroups.length > 0" v-slot:prepend-item>
      <v-list-item @click="selectAllGroups" :ripple="false">
       <v-list-item-avatar>
        <v-icon>
         {{ icon }}
        </v-icon>
       </v-list-item-avatar>
       <v-list-item-content>
        <v-list-item-title> {{ selectedAllGroups ? "Unselect All" : "Select All" }} </v-list-item-title>
       </v-list-item-content>
      </v-list-item>
      <v-divider></v-divider>
     </template>

     <template v-slot:selection="data">
      <span v-if="data.index === 0" class="grey--text caption"
       ><v-chip
        labal
        :style="$vuetify.theme.dark ? 'color: white' : 'color:black'"
        small
        label
        :color="$vuetify.theme.dark ? 'grey-darken-4' : 'blue-grey lighten-4'"
       >
        {{ selectedComponentGroups.length }} groups selected.</v-chip
       ></span
      >
     </template>

     <template v-slot:no-data>
      <v-list-item @click="dialogGroup = !dialogGroup">
       <v-list-item-avatar>
        <v-icon>
         mdi-plus
        </v-icon>
       </v-list-item-avatar>

       <v-list-item-content>
        <v-list-item-title>
         <span>Create group </span>
         {{ formattedGroupTest }}
        </v-list-item-title>
       </v-list-item-content>
      </v-list-item>
     </template>

     <template #item="{ item, on }">
      <v-list-item :ripple="false" v-on="on">
       <v-list-item-avatar>
        <v-icon>mdi-folder-outline</v-icon>
       </v-list-item-avatar>
       <v-list-item-content>
        <v-list-item-title> {{ item.name }} </v-list-item-title>
       </v-list-item-content>
       <v-list-item-avatar>
        <v-btn :ripple="false" @click.stop="renameGroup(item.id, item.name)" depressed fab x-small>
         <v-icon>mdi-pencil-outline</v-icon>
        </v-btn>
       </v-list-item-avatar>
       <v-list-item-avatar>
        <v-btn :ripple="false" @click.stop="removeGroupWarning(item.id, item.name)" depressed fab x-small>
         <v-icon>mdi-delete-outline</v-icon>
        </v-btn>
       </v-list-item-avatar>
      </v-list-item>
     </template>
    </v-autocomplete>
   </v-col>
   <v-col cols="12" sm="8">
    <div>
     <v-chip-group showArrows centerActive>
      <transition-group appear name="scale-transition">
       <v-chip :ripple="false" close @click:close="unselectGroup(item.id)" v-for="(item, index) in selectedComponentGroups" :key="`${index}`">
        <v-avatar left>
         <v-btn style="pointer-events:none" :color="$vuetify.theme.dark ? 'grey darken-3' : 'grey lighten-4'">
          {{ countComponentsInGroup(item.id) }}</v-btn
         >
        </v-avatar>
        {{ item.name }}
       </v-chip>
      </transition-group>
     </v-chip-group>
    </div>
   </v-col>
  </v-row>
 </v-card>
</template>

<script>
import axios from "axios";
import { store } from "@/store";
import { sync, call, get } from "vuex-pathify";

export default {
 name: "ComponentsGroups",

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["allGroups", "selectedComponentGroups", "dialogGroup", "groupName", "allComponents"]),
  ...get("componentManagement", ["selectedAllGroups", "selectedSomeGroups", "hasSelectedComponentGroups", "countComponentsInGroup"]),

  formattedGroupTest() {
   if (this.groupName !== null) return `"${this.groupName}"`;
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

  renameGroup(id, name) {
   this.$swal({
    title: `<span style="color:${this.isDark ? "lightgrey" : "white"} "> Rename group </span>`,
    showCancelButton: true,
    confirmButtonText: "Rename",
    cancelButtonText: "Cancel",
    confirmButtonColor: "#42b883",
    input: "text",
    inputValue: name,
    backdrop: `${this.isDark ? "rgba(0, 0, 0, 0.6)" : "rgba(108, 122, 137, 0.8)"}`,
    background: `${this.isDark ? "#2f3136" : ""}`
   }).then(result => {
    if (result.value) {
     alert("renamed");
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
</script>
