<template>
 <baseDialog v-model="internalValue" title="Add new component" persistent max-width="900" @save="generate()" @close="() => (internalValue = false)">
  <ValidationObserver ref="newComponentForm" slim>
   <v-container class="mt-2" fluid>
    <v-row dense>
     <v-col cols="12" sm="12" lg="6">
      <small>Group</small>
      <validation-provider v-slot="{ errors }" name="component group" rules="required">
       <v-autocomplete
        autofocus
        v-model="parentData.componentSettings.component_group_id"
        :background-color="errors.length > 0 ? '#faebeb' : 'white'"
        :error-messages="errors[0]"
        color="primary"
        label="Select group"
        solo
        :items="allGroups"
        item-value="id"
        item-text="name"
        placeholder=" "
        item-color="primary"
        :menu-props="{
         transition: 'slide-y-transition',
         closeOnClick: false,
         closeOnContentClick: true
        }"
        @contextmenu="handler($event)"
       >
       </v-autocomplete>
      </validation-provider>
     </v-col>

     <!-- <v-col cols="12" sm="12" lg="6">
            <span>Sidebar parent</span>
            <v-select
              v-model="parentData.componentSettings.parent_id"
              solo
              label=" "
              :menu-props="{ transition: 'slide-y-transition' }"
              :items="parentData.groupComponent"
              item-value="id"
              item-text="title"
              placeholder="Select parent..."
              item-color="primary"
              color="primary"
            />
          </v-col> -->

     <v-col cols="12" sm="12" lg="6">
      <small>Component title</small>
      <validation-provider v-slot="{ errors }" name="component title" rules="required">
       <v-text-field
        ref="componentTitle"
        v-model="parentData.componentSettings.title"
        solo
        prepend-inner-icon="mdi-comment"
        counter
        maxlength="35"
        :background-color="errors.length > 0 ? '#faebeb' : 'white'"
        :error-messages="errors[0]"
       />
      </validation-provider>
     </v-col>

     <v-col cols="12" sm="12" lg="6">
      <small>Component name</small>
      <validation-provider v-slot="{ errors }" name="component title" rules="required">
       <v-text-field
        ref="componentTitle"
        v-model="parentData.componentSettings.name"
        solo
        prepend-inner-icon="mdi-comment"
        counter
        maxlength="35"
        :background-color="errors.length > 0 ? '#faebeb' : 'white'"
        :error-messages="errors[0]"
       />
      </validation-provider>
     </v-col>

     <v-col cols="12" sm="12" lg="6">
      <small>Component description</small>
      <validation-provider v-slot="{ errors }" name="component desc" rules="required">
       <v-text-field
        v-model="parentData.componentSettings.note"
        solo
        prepend-inner-icon="mdi-file"
        counter
        maxlength="35"
        color="primary"
        label
        placeholder="Description"
        :background-color="errors.length > 0 ? '#faebeb' : 'white'"
        :error-messages="errors[0]"
       />
      </validation-provider>
     </v-col>

     <!-- <v-col cols="12" sm="12" lg="6">
            <span>Component / controller name</span>
            <validation-provider v-slot="{ errors }" name="component description" rules="required">
              <v-text-field
                v-model="parentData.componentSettings.controller"
                prepend-inner-icon="mdi-file"
                counter
                maxlength="35"
                solo
                color="primary"
                label
                :background-color="errors.length > 0 ? '#faebeb' : 'white'"
                :error-messages="errors[0]"
                @keydown.space.prevent
              />
            </validation-provider>
          </v-col> -->

     <!-- <v-col cols="12" sm="12" lg="6">
              <span>Template type</span>
              <v-select
                v-model="parentData.componentSettings.type_id"
                item-color="primary"
                color="primary"
                placehold="Folder and files name"
                solo
                prepend-inner-icon="mdi-application"
                :menu-props="{ transition: 'slide-y-transition' }"
                label
                :items="parentData.items_type"
              />
            </v-col> -->
    </v-row>
    <v-row>
     <v-col cols="12" sm="12" lg="6">
      <small>Database table</small>
      <validation-provider v-slot="{ errors }" name="component table" rules="required">
       <v-autocomplete
        v-model="parentData.componentSettings.table"
        :background-color="errors.length > 0 ? '#faebeb' : 'white'"
        :error-messages="errors[0]"
        :menu-props="{
         transition: 'slide-y-transition',
         closeOnClick: false,
         closeOnContentClick: true
        }"
        clearable
        solo
        label=" "
        prepend-inner-icon="mdi-table"
        hint="Table in your DB."
        item-color="primary"
        color="primary"
        :items="dbTables"
       >
        <template v-slot:item="data">
         <template>
          <v-list-item-avatar>
           <v-icon small> mdi-table </v-icon>
          </v-list-item-avatar>

          <v-list-item-content>
           <v-list-item-title v-html="data.item" />
          </v-list-item-content>
         </template>
        </template>
       </v-autocomplete>
      </validation-provider>
     </v-col>
     <!-- 
          <v-col cols="12" sm="12" lg="6">
            <span>Table key</span>
            <validation-provider v-slot="{ errors }" name="component table key" rules="required">
              <v-autocomplete
                v-model="parentData.componentSettings.table_key"
                :background-color="errors.length > 0 ? '#faebeb' : 'white'"
                :error-messages="errors[0]"
                :menu-props="{ transition: 'slide-y-transition' }"
                clearable
                solo
                prepend-inner-icon="mdi-key"
                item-color="primary"
                color="primary"
                label="Database table key"
                :disabled="parentData.componentSettings.table === ''"
                :items="tableColumns"
              >
                <template v-slot:item="data">
                  <template>
                    <v-list-item-avatar>
                      <v-icon small> mdi-key </v-icon>
                    </v-list-item-avatar>

                    <v-list-item-content>
                      <v-list-item-title v-html="data.item" />
                    </v-list-item-content>
                  </template>
                </template>
              </v-autocomplete>
            </validation-provider>
          </v-col> -->
    </v-row>
   </v-container>
  </ValidationObserver>
 </baseDialog>
</template>
<script>
import { sync } from "vuex-pathify";
export default {
 name: "DialogComponent",
 inheritAttrs: true,
 inject: ["generate"],

 props: {
  value: Boolean,
  parentData: Object
 },

 data() {
  return {
   internalValue: this.value,
   dbTables: [],
   selectedTable: "",
   tableColumns: []
  };
 },

 mounted() {
  this.getDbTables();
 },

 methods: {
  getDbTables() {
   axios.get("api/showAllTables").then(response => {
    this.dbTables = response.data;
   });
  },

  getColumns() {
   axios.post("api/getTableColumns", { table: this.parentData.componentSettings.table }).then(response => {
    this.tableColumns = response.data;
   });
  }
 },

 computed: {
  ...sync("componentManagement", ["allGroups"])
 },

 watch: {
  internalValue(val, oldVal) {
   if (val === oldVal) return;

   this.$emit("input", val);
  },
  value(val, oldVal) {
   if (val === oldVal) return;

   this.internalValue = val;
  }
 }
};
</script>
