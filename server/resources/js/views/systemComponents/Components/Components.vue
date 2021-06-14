<template>
 <div>
  <components-appbar :parent-data="$data" />
  <components-groups />
  <div class="d-flex justify-space-between align-center">
   <v-tabs color="secondary" v-model="activeStatusTab" showArrows class="col-6 mt-n3" background-color="transparent" sliderSize="1">
    <v-tab
     :activeClass="$vuetify.theme.dark ? 'white--text' : ''"
     :disabled="isComponentsEmpty"
     :key="i"
     v-for="(tab, i) in componentStatusTabs"
     :ripple="false"
    >
     <v-icon :color="tab.color" small left>
      {{ tab.icon }}
     </v-icon>
     {{ tab.name }}
    </v-tab>
   </v-tabs>

   <div class="d-flex">
    <v-switch v-model="multipleSelect" label="Multiple selection" class="mt-1 mx-4"> </v-switch>
    <!-- <v-btn @click="isTableLayout = !isTableLayout"><v-icon left> mdi-view-grid-outline</v-icon> Switch to grid view</v-btn> -->
   </div>
  </div>

  <v-divider></v-divider>

  <v-card color="transparent" flat :height="calculateHeight()" style="overflow-y:scroll">
   <template v-if="!isAllFilteredComponentsEmpty">
    <!-- <v-fade-transition hide-on-leave>
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
    </v-fade-transition> -->

    <!-- <template v-if="!isTableLayout"> -->
    <template>
     <v-item-group v-model="componentCardGroup" :multiple="multipleSelect">
      <transition-group class="gallery-card-container pa-2" appear css name="slide-x-transition">
       <v-item :key="`${index}`" v-for="(component, index) in allComponentsFiltered" v-slot="{ active, toggle }">
        <v-card
         :ref="`SEL${componentCardGroup}ID${index}`"
         :color="getComponentCardColor(active)"
         height="210"
         width="100%"
         :ripple="false"
         class="d-flex flex-column justify-space-between pa-4 hoverElevationSoft"
         @click="
          toggle();
          setSelectedComponent(index);
         "
        >
         <v-card-actions class="px-0 ">
          <v-avatar @click="dialogIcons = true" rounded :color="component.config_settings.icon.color">
           <v-icon dark>
            {{ component.config_settings.icon.name }}
           </v-icon>
          </v-avatar>

          <v-spacer />

          <v-btn @click.stop="setModular(component)" color="white" small icon :ripple="false">
           <v-icon :color="isModularColor(component)"> {{ isModularIcon(component) }} </v-icon>
          </v-btn>

          <v-btn @click.stop="setActive(component)" color="white" small icon :ripple="false">
           <v-icon :color="isActiveColor(component)"> {{ isActiveIcon(component) }} </v-icon>
          </v-btn>

          <v-btn @click.stop="setStarred(component)" color="white" small icon :ripple="false">
           <v-icon :color="isStarredColor(component)"> {{ isStarredIcon(component) }} </v-icon>
          </v-btn>
         </v-card-actions>

         <span class="gallery-card-title"> {{ component.config.title }} </span>

         <div class="gallery-card-subtitle-container">
          <div class="gallery-card-subtitle-wrapper">
           <h5 class="gallery-card-subtitle">
            <v-chip v-if="!$vuetify.theme.dark" style="pointer-events:none" color="grey lighten-5" text-color="black" label class="col-6">
             <v-icon small> mdi-folder-outline</v-icon>
             <div class="col-12 text-truncate">{{ mapComponentGroup(component) }}</div>
            </v-chip>
            <span v-else> {{ mapComponentGroup(component) }} </span>
           </h5>
          </div>
          <v-scale-transition>
           <div v-if="hasUnsavedChanges(component)" class="gallery-card-subtitle-wrapper">
            <h5 class="gallery-card-subtitle">
             <v-tooltip transition="false" color="black" bottom>
              <template v-slot:activator="{ on, attrs }">
               <v-icon v-on="on" :color="isDark ? 'white' : 'grey darken-4'">mdi-content-save-alert-outline</v-icon>
              </template>
              <span>Unsaved</span>
             </v-tooltip>
            </h5>
           </div>
          </v-scale-transition>
         </div>
        </v-card>
       </v-item>
      </transition-group>
     </v-item-group>
    </template>
   </template>

   <v-fade-transition hide-on-leave>
    <template v-if="isAllFilteredComponentsEmpty">
     <v-container fluid>
      <v-sheet color="transparent" height="45vh" class="d-flex pa-2 justify-center align-center">
       <div class="flex-grow-1 align-center justify-center d-flex flex-column">
        <v-img :aspect-ratio="1" width="250" contain src="storage/systemImages/noContent.svg"></v-img>
        No components found. Choose a different filter or
        <span :class="$vuetify.theme.dark ? 'secundary--text' : 'primary--text'" @click="dialogComponent = true" class=" cursor-pointer"
         ><b> create a new component</b></span
        >
       </div>
      </v-sheet>
     </v-container>
    </template>
   </v-fade-transition>
  </v-card>

  <dialog-group v-if="dialogGroup" />
  <dialog-icons v-if="dialogIcons" />
  <dialog-component v-if="dialogComponent" />
 </div>
</template>

<script>
import { store } from "@/store";
import globalMixin from "@/mixins/globalMixin";
import { sync, call, get } from "vuex-pathify";

export default {
 name: "ComponentManagement",
 components: {
  DialogGroup: () => import("./DialogGroup"),
  DialogIcons: () => import("./DialogIcons"),
  DialogComponent: () => import("./DialogComponent"),
  ComponentsAppbar: () => import("./ComponentsAppbar"),
  ComponentsGroups: () => import("./ComponentsGroups")
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
  ...sync("theme", ["isDark"]),
  ...sync("drawers", ["secureComponentDrawer"]),
  ...sync("componentManagement", [
   "allGroups",
   "allComponents",
   "activeStatusTab",
   "componentCardGroup",
   "componentStatusTabs",
   "dialogComponent",
   "dialogIcons",
   "dialogGroup"
  ]),
  ...get("componentManagement", [
   "hasUnsavedChanges",
   "allComponentsFiltered",
   "isModularIcon",
   "isStarredIcon",
   "selectedComponentIndex",
   "isAllFilteredComponentsEmpty",
   "isComponentsEmpty",
   "isStarredColor",
   "isActiveColor",
   "isModularColor",
   "isActiveIcon"
  ])
 },

 mounted() {
  this.getGroups();
  this.getComponents();
 },

 methods: {
  ...call("componentManagement/*"),

  getComponentCardColor(active) {
   if (this.$vuetify.theme.dark && !active) return "#40434a";
   if (this.$vuetify.theme.dark && active) return "#51555e";
   if (!this.$vuetify.theme.dark && !active) return "white";
   if (!this.$vuetify.theme.dark && active) return "indigo lighten-5";
  },

  calculateHeight() {
   return Number(this.$vuetify.breakpoint.height - 375);
  },

  setSelectedComponent(index) {
   this.secureComponentDrawer = true;
   store.set("componentManagement/selectedComponentIndex", index);
  },

  setStarred(component) {
   component.status.starred = !component.status.starred;
   component.origin.status.starred = !component.origin.status.starred;
   this.setComponentStatus(component);
  },

  setModular(component) {
   component.status.modular = !component.status.modular;
   component.origin.status.modular = !component.origin.status.modular;
   this.setComponentStatus(component);
  },

  setActive(component) {
   component.status.active = !component.status.active;
   component.origin.status.active = !component.origin.status.active;
   this.setComponentStatus(component);
  },

  mapComponentGroup(component) {
   if (this.allGroups.length === 0) return;
   return this.allGroups.filter(g => g.id === component.component_group_id)[0].name;
  }
 }
};
</script>

<style scoped lang="scss">
.hoverElevationSoft {
 border-radius: 8px;
 -webkit-transition-property: color, background-color, -webkit-box-shadow, -webkit-transform;
 transition-property: color, background-color, box-shadow, transform, -webkit-box-shadow, -webkit-transform;
 transition-duration: 0.3s;
 box-shadow: 0 10px 60px -12px rgb(50 50 93 / 25%), 0 18px 36px -18px rgb(0 0 0 / 30%), 0 -12px 36px -8px rgb(0 0 0 / 3%) !important;
}

.hoverElevationSoft:hover {
 transform: translateY(1px) !important;
 box-shadow: 0 13px 27px -5px rgb(50 50 93 / 25%), 0 8px 16px -8px rgb(0 0 0 / 30%), 0 -6px 16px -6px rgb(0 0 0 / 3%) !important;
}
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

.theme--dark.v-tabs .v-tab--active:hover::before,
.theme--dark.v-tabs .v-tab--active::before {
 opacity: 0;
}

.v-tab:before {
 background-color: unset;
}
</style>
