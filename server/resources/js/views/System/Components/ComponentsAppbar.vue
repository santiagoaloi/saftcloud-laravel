<template>
 <div>
      <div  class="d-flex justify-end transparent" >

        <components-groups/>      

      <div class="flex-grow-1" />
    <v-btn plain @click="dialogEditor = true" class="mx-2 "> <v-icon class="mr-2" small> mdi-code-json </v-icon>Config Structure </v-btn>
    <v-btn plain class="mx-2 "> <v-icon class="mr-2" small> mdi-arrow-top-right </v-icon>Export </v-btn>
    <v-btn class="ml-2" :color="isDark ? 'accent' : 'primary'" @click.stop="dialogComponent = true">
     <v-icon class="mr-2" small> mdi-plus </v-icon>Create component
    </v-btn>


      </div>

        <v-divider class="mt-2"></v-divider>

<v-sheet class="transparent" height="40">
           <components-groups-chips/>

</v-sheet>




  <v-divider class="mt-3"></v-divider>
  <dialog-config-editor />
  
 </div>
</template>

<script>
import { sync, call } from "vuex-pathify";
export default {
 name: "ComponentsAppbar",
 components: {
  DialogConfigEditor: () => import(/* webpackChunkName: 'components-dialog-config-editor' */ "./DialogConfigEditor"),
    ComponentsGroups: () => import(/* webpackChunkName: 'components-groups' */ "./ComponentsGroups"),
      ComponentsGroupsChips: () => import(/* webpackChunkName: 'components-groups-chips' */ "./ComponentsGroupsChips")


 },
 methods: {
  ...call("componentManagement/*")
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("componentManagement", ["dialogComponent", "dialogEditor"])
 }
};
</script>
