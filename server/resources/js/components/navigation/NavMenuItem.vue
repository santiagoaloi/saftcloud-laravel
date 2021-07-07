<template>
 <div>
  <v-list-item v-if="!menuItem.items" :input-value="menuItem.value" :to="menuItem.link" :exact="menuItem.exact" :disabled="menuItem.disabled" link>
   <v-list-item-icon>
    <v-icon :class="{ 'grey--text': menuItem.disabled }">
     {{ menuItem.value ? "mdi-folder-open-outline" : "mdi-folder-outline" }}
    </v-icon>
   </v-list-item-icon>
   <v-list-item-content>
    <v-list-item-title>
     {{ menuItem.name }}
    </v-list-item-title>
   </v-list-item-content>
  </v-list-item>

  <v-list-group
   v-else
   :value="menuItem.regex ? menuItem.regex.test($route.path) : false"
   :disabled="menuItem.disabled"
   :sub-group="subgroup"
   :to="menuItem.link"
   link
   color="primary lighten-2"
   ref="group"
  >
   <template v-slot:activator>
    <v-list-item-icon v-if="!subgroup">
     <v-icon>{{ icon }}</v-icon>
    </v-list-item-icon>
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
    return this.$refs.group.isActive;
   },
   val => {
    this.icon = val ? "mdi-folder-open-outline" : "mdi-folder-outline";
   }
  );
 }
};
</script>
