<template>
 <v-card color="transparent" flat class="mt-8">
  <v-row align="center">
   <v-col cols="12" sm="3">
    <small>Component groups</small>
    <v-autocomplete
     @update:search-input="catchGroupInputValue($event)"
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
    >
     <template v-slot:prepend-item>
      <v-list-item ripple @click="selectAll">
       <v-list-item-action>
        <v-icon :color="selectedComponentGroups.length > 0 ? 'indigo darken-4' : 'grey darken-3'">
         {{ icon }}
        </v-icon>
       </v-list-item-action>
       <v-list-item-content>
        <v-list-item-title>
         Select All
        </v-list-item-title>
       </v-list-item-content>
      </v-list-item>
      <v-divider></v-divider>
     </template>

     <template v-slot:selection="data">
      <template>
       <span v-if="data.index === 0" class="grey--text caption"
        ><v-chip labal style="color: black" small label color="blue-grey lighten-4">
         {{ selectedComponentGroups.length }} groups selected.</v-chip
        ></span
       >
      </template>
     </template>

     <template v-slot:no-data>
      <v-list-item class="ml-1">
       <v-list-item-content>
        <v-list-item-title>
         <a @click="parentData.dialogGroup = !parentData.dialogGroup">+ Create group </a>
         {{ parentData.groupInputValue }}
        </v-list-item-title>
       </v-list-item-content>
      </v-list-item>
     </template>
     <template #item="{ item, on }">
      <v-list-item :ripple="false" v-on="on">
       <v-list-item-content>
        <v-list-item-title> {{ item.name }} </v-list-item-title>
       </v-list-item-content>
       <v-list-item-avatar>
        <v-btn :ripple="false" @click.stop depressed fab x-small>
         <v-icon>mdi-delete-outline</v-icon>
        </v-btn>
       </v-list-item-avatar>
      </v-list-item>
     </template>
    </v-autocomplete>
   </v-col>
   <v-col cols="12" sm="9">
    <div>
     <v-chip-group showArrows centerActive>
      <v-chip :ripple="false" close @click:close="unselectGroup(i)" v-for="(item, i) in selectedComponentGroups" :key="i">
       {{ item.name }}
      </v-chip>
     </v-chip-group>
    </div>
   </v-col>
  </v-row>
 </v-card>
</template>

<script>
import axios from "axios";
import { store } from "@/store";
import { sync } from "vuex-pathify";

export default {
 name: "ComponentGroups",

 props: {
  value: Boolean,
  parentData: Object
 },

 computed: {
  ...sync("componentManagement", ["allGroups", "selectedComponentGroups"]),

  selectedAllComponents() {
   return this.selectedComponentGroups.length === this.allGroups.length;
  },

  selectedSomeComponents() {
   return this.selectedComponentGroups.length > 0 && !this.selectedAllComponents;
  },

  icon() {
   if (this.selectedAllComponents) return "mdi-close-box";
   if (this.selectedSomeComponents) return "mdi-minus-box";
   return "mdi-checkbox-blank-outline";
  }
 },

 mounted() {
  this.getGroups();
 },

 methods: {
  catchGroupInputValue(e) {
   this.parentData.groupInputValue = e;
  },

  unselectGroup(index) {
   this.selectedComponentGroups.splice(index, 1);
  },

  selectAll() {
   this.$nextTick(() => {
    if (this.selectedAllComponents) {
     this.selectedComponentGroups = [];
    } else {
     this.selectedComponentGroups = this.allGroups.slice();
    }
   });
  },

  getGroups() {
   axios.get("api/showAllGroups").then(response => {
    if (response.data.status) {
     this.allGroups = response.data.rows;
    }
   });
  },

  saveGroup() {
   axios.post("api/ComponentGroup", { name: this.group_settings.name }).then(response => {
    if (response.data.status) {
     this.dialogGroup = false;
     this.allGroups = response.data.rows;
    }
   });
  }
 }
};
</script>

<style scoped>
.v-card--link:before {
 background: white;
}

.gallery-card-container {
 display: grid;
 grid-template-columns: repeat(auto-fill, minmax(264px, 1fr));
 grid-auto-rows: 180px;
 gap: 16px;
}

.gallery-card-wrapper {
 box-sizing: border-box;
 text-align: left;
}

.gallery-card-title {
 font-size: 1.1rem;
 font-weight: bold;
 line-height: 1.2;
 color: rgb(23, 43, 77);
 letter-spacing: -0.008em;
 margin: 0px;
 display: -webkit-box;
 -webkit-line-clamp: 2;
 -webkit-box-orient: vertical;
 overflow: hidden;
 text-overflow: ellipsis;
}

.gallery-card-subtitle-container {
 width: 100%;
 height: 32px;
 display: flex;
 -webkit-box-pack: justify;
 justify-content: space-between;
 -webkit-box-align: center;
 align-items: center;
 color: rgb(107, 119, 140) !important;
}

.gallery-card-subtitle-wrapper {
 padding: 2px;
 margin-left: -2px;
 margin-right: 4px;
 overflow: hidden;
 text-overflow: ellipsis;
}

.gallery-card-subtitle {
 margin: 0px;
 -webkit-box-flex: 1;
 flex-grow: 1;
 flex-shrink: 1;
 overflow: hidden;
 text-overflow: ellipsis;
 white-space: nowrap;
}
</style>
