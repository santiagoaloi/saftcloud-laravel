<template>
 <div>
  <v-row align="center" class="mt-2">
   <v-col cols="12" sm="4">
    <baseFieldLabel label="Component groups" />
    <v-autocomplete
     @update:search-input="syncGroupInputValue($event)"
     v-model="selectedComponentGroups"
     :items="allGroups"
     multiple
     :maxlength="25"
     item-value="id"
     item-text="name"
     return-object
     placeholder="Select or create groups"
     hide-selected
     item-color="primary"
     :menu-props="{
      transition: 'slide-y-transition'
     }"
     :outlined="isDark"
     :solo="!isDark"
     :color="isDark ? '#208ad6' : 'grey'"
     :background-color="isDark ? '#28292b' : 'grey lighten-5'"
    >
     <template v-if="allGroups.length" v-slot:prepend-item>
      <v-list-item @click="selectAllGroups" :ripple="false">
       <v-list-item-avatar>
        <v-icon>
         {{ icon }}
        </v-icon>
       </v-list-item-avatar>
       <v-list-item-content>
        <v-list-item-title> {{ selectedAllGroups ? "Unselect all groups" : "Select all groups" }} </v-list-item-title>
       </v-list-item-content>
      </v-list-item>
      <v-divider></v-divider>
     </template>

     <template v-slot:selection="data">
      <v-chip
       v-if="data.index === 0"
       :style="isDark ? 'color: white' : 'color:black'"
       small
       :color="isDark ? 'grey-darken-4' : 'blue-grey lighten-4'"
      >
       {{ selectedComponentGroups.length }} groups selected.</v-chip
      >
     </template>

     <template v-slot:no-data>
      <v-list-item @click="addGroupDialog()">
       <v-list-item-avatar>
        <v-icon>
         mdi-plus
        </v-icon>
       </v-list-item-avatar>

       <v-list-item-content>
        <v-list-item-title>
         <span>Create group </span>
         {{ formattedGroup }}
        </v-list-item-title>
       </v-list-item-content>
      </v-list-item>
     </template>

     <template #item="{ item, on }">
      <v-list-item :ripple="false" v-on="on">
       <v-list-item-avatar style="margin-left:1px">
        <v-avatar class="white--text" tile size="30" color="primary">
         <h6>{{ countComponentsInGroup(item.id) }}</h6>
        </v-avatar>
       </v-list-item-avatar>
       <v-list-item-content>
        <v-list-item-title> {{ item.name }} </v-list-item-title>
       </v-list-item-content>

       <v-tooltip transition="false" color="black" bottom>
        <template v-slot:activator="{ on }">
         <v-btn v-on="on" class="mr-2" :ripple="false" @click.stop="renameGroupDialog(item.id, item.name)" small depressed>
          <v-icon small>mdi-pencil-outline</v-icon>
         </v-btn>
        </template>
        <span>Edit group</span>
       </v-tooltip>

       <v-tooltip transition="false" color="black" bottom>
        <template v-slot:activator="{ on }">
         <v-btn v-on="on" :ripple="false" @click.stop="removeGroupWarning(item.id, item.name)" small depressed>
          <v-icon small>mdi-delete-outline</v-icon>
         </v-btn>
        </template>
        <span>Remove group</span>
       </v-tooltip>
      </v-list-item>
     </template>
    </v-autocomplete>
   </v-col>
   <v-col cols="12" sm="8">
    <v-chip-group class="mt-n1" showArrows centerActive>
     <transition-group appear name="scale-transition">
      <v-chip :ripple="false" close @click:close="unselectGroup(item.id)" v-for="(item, index) in selectedComponentGroups" :key="`${index}`">
       <v-avatar left>
        <v-btn style="pointer-events:none" :color="isDark ? 'grey darken-3' : 'grey lighten-4'"> {{ countComponentsInGroup(item.id) }}</v-btn>
       </v-avatar>
       {{ item.name }}
      </v-chip>
     </transition-group>
    </v-chip-group>
   </v-col>
  </v-row>

  <baseDialog
   @close="componentsLinkedToGroupDialog = !componentsLinkedToGroupDialog"
   @save="componentsLinkedToGroupDialog = !componentsLinkedToGroupDialog"
   width="700"
   v-model="componentsLinkedToGroupDialog"
   title="Components still linked to this group"
   v-if="componentsLinkedToGroupDialog"
  >
   <v-expand-transition appear>
    <v-sheet v-model="removeAlert" color="transparent" v-if="removeAlert">
     <v-alert dismissible border="left" colored-border color="grey darken-2" elevation="2" class="text-left ">
      <div>These componets are still associated with the group "{{ groupNameBeingRemoved }}"</div>
      <div>You can remove the components permanently and then remove the group.</div>
     </v-alert>
    </v-sheet>
   </v-expand-transition>

   <v-data-table checkbox-color="primary" item-key="id" show-select :headers="headers" :items="componentsLinkedToGroup" :items-per-page="-1">
    <template v-slot:[`item.avatar`]="{ item }">
     <v-avatar class="cursor-pointer" size="30" rounded :color="item.config_settings.icon.color">
      <v-icon size="25" dark>
       {{ item.config_settings.icon.name }}
      </v-icon>
     </v-avatar>
    </template>

    <template v-slot:[`item.actions`]>
     <v-menu rounded="lg" origin="center center" transition="scale-transition" :nudge-bottom="10" offset-y>
      <template v-slot:activator="{ on }">
       <v-btn icon v-on="on">
        <v-icon>mdi-dots-vertical</v-icon>
       </v-btn>
      </template>

      <v-list class="pa-2" rounded="xl" outlined>
       <v-list-item @click.stop>
        <v-list-item-action>
         <v-btn small icon dark color="#4C4C4C">
          <v-icon color="grey darken-2" small class="mx-2">
           mdi-pencil-outline
          </v-icon>
         </v-btn>
        </v-list-item-action>
        <v-list-item-title>Editar</v-list-item-title>
       </v-list-item>

       <v-list-item @click.stop>
        <v-list-item-action>
         <v-btn small icon dark color="#4C4C4C">
          <v-icon color="red lighten-2" small class="mx-2">
           mdi-delete-outline
          </v-icon>
         </v-btn>
        </v-list-item-action>

        <v-list-item-title>Eliminar</v-list-item-title>
       </v-list-item>
      </v-list>
     </v-menu>
    </template>
    <template v-slot:[`item.deleted_at`]="{ item }">
     <v-chip v-if="item.deleted_at">Removed</v-chip>
     <v-chip color="primary" v-else>Active</v-chip>
    </template>
   </v-data-table>
  </baseDialog>
 </div>
</template>

<script>
import { sync, get, call } from "vuex-pathify";
import componentGroups from "@/mixins/componentGroups";
export default {
 name: "ComponentsGroups",
 mixins: [componentGroups],

 data() {
  return {
   removeAlert: true,
   headers: [
    {
     text: "Avatar",
     align: "start",
     sortable: false,
     value: "avatar"
    },
    {
     text: "Component",
     align: "start",
     sortable: true,
     value: "name"
    },
    {
     text: "Status",
     align: "center",
     sortable: true,
     value: "deleted_at"
    },
    {
     text: "Actions",
     align: "end",
     sortable: false,
     value: "actions"
    }
   ]
  };
 },

 computed: {
  ...sync("componentManagement", ["componentsLinkedToGroupDialog", "componentsLinkedToGroup", "groupNameBeingRemoved"])
 },
 methods: {
  ...call("componentManagement/*")
 }
};
</script>
<style>
.swalDarkTitle {
 color: white !important;
}

.swalDarkValidation {
 align-items: center;
 justify-content: center;
 margin: 0;
 padding: 0;
 background: transparent;
 color: white;
 font-size: 1em;
 font-weight: 300;
}

.swalDarkSelect {
 min-width: 100% !important;
 background: rgb(54, 57, 63) !important;
 color: white !important;
 border-radius: 8px;
 height: 50px;
}
</style>
