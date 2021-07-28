<template>
 <div>
  <!-- <v-list-group v-if="!menuItem.items">
   <template v-slot:activator> -->
  <v-list-item v-if="!menuItem.items" :input-value="menuItem.value" :to="menuItem.link" :exact="menuItem.exact" :disabled="menuItem.disabled" link>
   <div class="d-flex">
    <v-list-item-icon>
     <v-icon :class="{ 'grey--text': menuItem.disabled }">
      {{ menuItem.icon ? menuItem.icon : "mdi-folder-outline" }}
     </v-icon>
    </v-list-item-icon>
    <v-list-item-content>
     <v-list-item-title>
      {{ menuItem.title || menuItem.name }}
     </v-list-item-title>
    </v-list-item-content>
   </div>
  </v-list-item>
  <!-- </template>
  </v-list-group> -->
  <v-list-group
   no-action
   v-else
   :value="menuItem.regex ? menuItem.regex.test($route.path) : false"
   :disabled="menuItem.disabled"
   :sub-group="subgroup"
   color="primary lighten-2"
   ref="group"
   :prepend-icon="subgroup ? false : ''"
  >
   <template v-slot:activator>
    <v-list-item-icon v-if="!subgroup">
     <v-icon>{{ icon }}</v-icon>
    </v-list-item-icon>

    <slot v-if="subgroup" name="prependIcon">
     <v-icon class="ml-n4 mr-3">{{ icon }}</v-icon>
    </slot>

    <v-list-item-content>
     <v-list-item-title>
      {{ menuItem.name }}
     </v-list-item-title>
    </v-list-item-content>
   </template>

   <slot></slot>
  </v-list-group>
 </div>
</template>

<script>
/*
|---------------------------------------------------------------------
| Navigation Menu Item Component
|---------------------------------------------------------------------
|
| Navigation items for the NavMenu component
|
*/
export default {
 data: () => ({
  icon: "mdi-folder-outline"
 }),

 props: {
  menuItem: {
   type: Object,
   default: () => {}
  },
  subgroup: {
   type: Boolean,
   default: false
  },
  small: {
   type: Boolean,
   default: false
  }
 },
 mounted() {
  this.$watch(
   () => {
    if (this.$refs.group) return this.$refs.group.isActive;
   },
   val => {
    this.icon = val ? "mdi-folder-open-outline" : "mdi-folder-outline";
   }
  );
 }
};
</script>
<style scoped>
.v-application--is-ltr .v-list-group__items .v-list-item {
 padding-left: 18px !important;
}
</style>
