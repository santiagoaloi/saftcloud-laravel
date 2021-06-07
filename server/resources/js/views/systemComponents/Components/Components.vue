<template>
 <div>
  <components-appbar :parent-data="$data" />
  <components-groups />
  <div class="d-flex justify-space-between align-center">
   <v-tabs v-model="activeStatusTab" showArrows class="col-6 mt-n3" background-color="transparent" sliderSize="1">
    <v-tab :key="i" y v-for="(tab, i) in componentStatusTabs" :ripple="false">
     <v-icon :color="tab.color" small left>
      {{ tab.icon }}
     </v-icon>
     {{ tab.name }}
    </v-tab>
   </v-tabs>

   <div class="d-flex">
    <v-switch v-model="multipleSelect" label="Multiple selection" class="mt-1 mx-4"> </v-switch>
    <v-btn @click="isTableLayout = !isTableLayout"><v-icon left> mdi-view-grid-outline</v-icon> Switch to grid view</v-btn>
   </div>
  </div>

  <v-divider></v-divider>

  <v-card color="transparent" flat :height="calculateHeight()" style="overflow-y:scroll">
   <template v-if="allComponentsFiltered.length > 0">
    <v-fade-transition hide-on-leave>
     <template v-if="isTableLayout">
      <v-card class="mt-2" flat>
       <v-data-table
        fixed-header
        height="40vh"
        checkbox-color="primary"
        item-key="id"
        show-select
        :headers="headers"
        :items="allComponents"
        :items-per-page="5"
        class="elevation-0"
       ></v-data-table>
      </v-card>
     </template>
    </v-fade-transition>

    <v-fade-transition hide-on-leave>
     <template v-if="!isTableLayout">
      <v-item-group v-model="componentCardGroup" mandatory :multiple="multipleSelect">
       <div class="gallery-card-container pa-2">
        <v-item :key="index" v-for="(component, index) in allComponentsFiltered" v-slot="{ active, toggle }">
         <v-card
          hover
          :color="active ? 'indigo lighten-5' : 'white'"
          :max-width="$vuetify.breakpoint.smAndDown ? '' : 320"
          height="180"
          width="100%"
          :ripple="false"
          class="d-flex flex-column justify-space-between pa-4 "
          @click="
           toggle();
           setSelectedComponent(component);
          "
         >
          <v-card-actions class="px-0 ">
           <v-avatar rounded :color="component.config_settings.icon.color">
            <v-icon dark>
             {{ component.config_settings.icon.name }}
            </v-icon>
           </v-avatar>
           <v-spacer />

           <v-btn @click="setModular(component)" color="white" small icon :ripple="false">
            <v-icon :color="isModularColor(component)"> {{ isModularIcon(component) }} </v-icon>
           </v-btn>

           <v-btn @click="setActive(component)" color="white" small icon :ripple="false">
            <v-icon :color="isActiveColor(component)"> {{ isActiveIcon(component) }} </v-icon>
           </v-btn>
           <v-btn @click="setStarred(component)" color="white" small icon :ripple="false">
            <v-icon :color="isStarredColor(component)"> {{ isStarredIcon(component) }} </v-icon>
           </v-btn>
          </v-card-actions>

          <span class="gallery-card-title"> {{ component.config.title }} </span>

          <div class="gallery-card-subtitle-container">
           <div class="gallery-card-subtitle-wrapper">
            <h5 class="gallery-card-subtitle">
             <v-chip style="pointer-events:none" color="grey lighten-5" text-color="blue darken-4" label class="col-6">
              <div class="col-12 text-truncate">
               {{ mapComponentGroup(component) }}
              </div>
             </v-chip>
            </h5>
           </div>
          </div>
         </v-card>
        </v-item>
       </div>
      </v-item-group>
     </template>
    </v-fade-transition>
   </template>

   <template v-else>
    <v-container fluid>
     <v-sheet color="transparent" height="45vh" class="d-flex pa-2 justify-center align-center">
      <div class="flex-grow-1 align-center justify-center d-flex flex-column">
       <v-img :aspect-ratio="1" width="250" contain src="storage/systemImages/noContent.svg"></v-img>
       No components found. Choose a different filter or search criteria.
      </div>
     </v-sheet>
    </v-container>
   </template>
  </v-card>

  <dialog-group />
  <dialog-component />
  <dialog-component-config v-if="dialogComponentConfig" v-model="dialogComponentConfig" />
 </div>
</template>

<script>
import axios from "axios";
import { store } from "@/store";
import moment from "moment";
import globalMixin from "@/mixins/globalMixin";
import { sync, call, get } from "vuex-pathify";

export default {
 name: "ComponentManagement",
 components: {
  DialogGroup: () => import("./DialogGroup"),
  DialogComponent: () => import("./DialogComponent"),
  ComponentsGroups: () => import("./ComponentsGroups"),
  ComponentsAppbar: () => import("./ComponentsAppbar"),
  DialogComponentConfig: () => import("./DialogComponentConfig")
 },

 mixins: [globalMixin],

 provide() {
  return {
   ...this.getComponentMethods()
  };
 },

 data() {
  return {
   multipleSelect: false,
   dialogComponentConfig: false
  };
 },

 computed: {
  ...sync("drawers", ["secureComponentDrawer"]),
  ...sync("componentManagement", [
   "allGroups",
   "allComponents",
   "activeStatusTab",
   "dialogComponent",
   "selectedComponent",
   "componentCardGroup",
   "componentStatusTabs",
   "selectedComponentGroups"
  ]),
  ...get("componentManagement", ["hasUnsavedChanges", "activeStatusTabName", "allComponentsFiltered", "isModularIcon", "isStarredIcon"])
 },

 methods: {
  ...call("componentManagement/*"),

  calculateHeight() {
   return Number(this.$vuetify.breakpoint.height - 375);
  },

  setSelectedComponent(nextComponent) {
   if (!this.secureComponentDrawer) {
    this.secureComponentDrawer = true;
   }

   if (nextComponent.id != this.selectedComponent.id) {
    this.selectedComponent = nextComponent;
   }
  },

  setStarred(component) {
   component.config_settings.status.starred = !component.config_settings.status.starred;
  },

  isStarredColor(component) {
   if (component.config_settings.status.starred) {
    return "orange darken-2";
   } else {
    return "black";
   }
  },

  setActive(component) {
   component.config_settings.status.active = !component.config_settings.status.active;
   component.config_settings.status.inactive = !component.config_settings.status.active;
  },

  isActiveColor(component) {
   if (component.config_settings.status.active) {
    return "blue darken-4";
   } else {
    return "black";
   }
  },

  isActiveIcon(component) {
   if (component.config_settings.status.active) {
    return "mdi-lightbulb-on";
   } else {
    return "mdi-lightbulb-on-outline";
   }
  },

  setModular(component) {
   component.config_settings.status.modular = !component.config_settings.status.modular;
  },

  isModularColor(component) {
   if (component.config_settings.status.modular) {
    return "blue darken-4";
   } else {
    return "black";
   }
  },

  mapComponentGroup(component) {
   if (this.allGroups.length === 0) return;
   return this.allGroups.filter(g => g.id === component.component_group_id)[0].name;
  }
 },

 mounted() {
  this.getComponents();
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
 grid-auto-rows: 5 0%;
 gap: 10px;
 justify-items: center;
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
