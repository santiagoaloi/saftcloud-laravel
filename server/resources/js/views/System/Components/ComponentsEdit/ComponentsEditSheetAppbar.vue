<template>
 <v-app-bar color="#24292e" flat dense>
  <v-toolbar-title class="white--text"
   >Editing <span class="accent--text text--lighten-4"> {{ selectedComponent.config.general_config.title }} </span></v-toolbar-title
  >

  <v-spacer></v-spacer>

  <v-fade-transition>
   <div v-if="hasUnsavedChanges(selectedComponent)">
    <v-btn rounded :color="isDark ? 'grey darken-3' : 'white'" class="mx-2" small @click="rollbackChanges(selectedComponent)"
     ><span class="pink--text text--lighten-2  mr-2"> Unsaved </span>
     <v-chip class="pointer-events-none" x-small>rollback </v-chip>
    </v-btn>
   </div>
  </v-fade-transition>

  <v-tooltip transition="false" color="black" bottom>
   <template v-slot:activator="{ on }">
    <v-btn
     :disabled="!hasUnsavedChanges(selectedComponent)"
     v-on="on"
     @click="validateComponentEditor(selectedComponent)"
     class="mr-2"
     x-small
     color="white"
     text
     fab
    >
     <v-icon color="green lighten-2"> mdi-check </v-icon>
    </v-btn>
   </template>
   <span>Save changes</span>
  </v-tooltip>

  <v-tooltip transition="false" color="black" bottom>
   <template v-slot:activator="{ on }">
    <v-btn v-on="on" @click="isDark = !isDark" fab class="mx-2" color="white" text x-small>
     <v-icon v-if="isDark">mdi-lightbulb-on-outline</v-icon>
     <v-icon v-else>mdi-lightbulb-outline</v-icon></v-btn
    >
   </template>
   <span> {{ isDark ? " Light mode" : "Dark mode" }}</span>
  </v-tooltip>

  <v-divider inset vertical class="mx-3 grey" />

  <v-tooltip transition="false" color="black" bottom>
   <template v-slot:activator="{ on }">
    <v-btn v-on="on" dark :disabled="previousComponentDisabled" @click="previousComponent()" class="mr-2" fab text x-small>
     <v-icon>mdi-chevron-left</v-icon>
    </v-btn>
   </template>
   <span>Previous component</span>
  </v-tooltip>

  <v-tooltip transition="false" color="black" bottom>
   <template v-slot:activator="{ on }">
    <v-btn v-on="on" dark :disabled="nextComponentDisabled" @click="nextComponent()" fab text x-small>
     <v-icon>mdi-chevron-right</v-icon>
    </v-btn>
   </template>
   <span>Next component</span>
  </v-tooltip>

  <v-tooltip transition="false" color="black" bottom>
   <template v-slot:activator="{ on }">
    <v-btn v-on="on" dark class="mr-2" @click="componentEditSheet = false" fab text x-small>
     <v-icon>mdi-chevron-down</v-icon>
    </v-btn>
   </template>
   <span>Hide</span>
  </v-tooltip>
 </v-app-bar>
</template>

<script>
import { sync, get, call } from "vuex-pathify";
export default {
 name: "ComponentsEditAppbar",
 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["componentEditSheet", "componentEditDrawerActiveMenu"]),
  ...get("componentManagement", ["previousComponentDisabled", "nextComponentDisabled", "selectedComponent", "hasUnsavedChanges"]),
  ...sync("refs", ["componentsEditBasic", "componentsEditQuery"])
 },

 methods: {
  ...call("componentManagement/*"),

  validateComponentEditor(selectedComponent) {
   let validators = [this.validateComponentsEditBasic(), this.validateComponentsEditQuery()];

   Promise.all([...validators]).then(result => {
    const errors = result.filter(validation => validation.value === false);
    if (errors.length) {
     if (this.$route.name != errors[0].route) {
      this.$router.push(errors[0].route);
     }
    } else {
     this.saveComponent(selectedComponent);
    }
   });
  },

  validateComponentsEditBasic() {
   if (!this.componentsEditBasic) return { value: null };
   return this.componentsEditBasic.validate().then(success => {
    if (success) {
     return { value: true };
    } else {
     return { value: false, route: "/components/basic" };
    }
   });
  },

  validateComponentsEditQuery() {
   if (!this.componentsEditQuery) return { value: null };
   return this.componentsEditQuery.validate().then(success => {
    if (success) {
     return { value: true };
    } else {
     return { value: false, route: "/components/query" };
    }
   });
  }
 }
};
</script>
