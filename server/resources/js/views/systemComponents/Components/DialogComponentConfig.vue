<template>
 <baseDialog v-model="internalValue" title="Config builder" persistent max-width="900" @close="() => (internalValue = false)">
  <template>
   <v-treeview :items="items"></v-treeview>
  </template>
 </baseDialog>
</template>
<script>
import { sync } from "vuex-pathify";
export default {
 name: "ConfigBuilder",
 inheritAttrs: true,
 //  inject: ["generate"],

 props: {
  value: Boolean,
  parentData: Object
 },

 data() {
  return {
   internalValue: this.value,
   items: [
    {
     id: 1,
     name: "formFields",
     formFields: [
      {
       id: 2,
       name: "formFields",
       field: "",
       label: "",
       inputType: "text",
       fieldType: "text",
       displayField: true,
       hiddenField: false,
       inputParameters: "",
       inputParametersPreview: [],
       inputParametersDefault: "",
       inputIcon: "",
       textareaRows: 3,
       responsiveGrid: 6,
       inputPlaceholder: "",
       inputHint: "",
       validation: {
        rulesString: "",
        rulesArray: [],
        range: {
         active: false,
         min: 0,
         max: 0
        },
        minValue: {
         active: false,
         value: 0
        },
        maxValue: {
         active: false,
         value: 0
        },
        length: {
         active: false,
         value: 0
        },
        maxLength: {
         active: false,
         value: 0
        },
        minLength: {
         active: false,
         value: 0
        },
        digits: {
         active: false,
         value: 0
        },
        regex: {
         active: false,
         value: ""
        },
        unique: false
       },
       events: {
        eventInput: "",
        eventChange: "",
        eventBlur: "",
        eventFocus: ""
       },
       slots: {
        prepend: {
         active: false,
         function: "",
         button: "",
         buttonColor: "",
         icon: "",
         iconColor: "",
         whiteText: false
        }
       },
       parentMenu: 0,
       datePickerTrigger: false,
       dropdownText: "text",
       dropdownValue: "value",
       options: {
        fieldBackgroundColor: "",
        fieldColor: "teal",
        tooltip: "",
        returnObject: {
         conditioned: false,
         conditionFunction: "",
         value: false
        },
        disabled: {
         conditioned: false,
         conditionFunction: "",
         value: false
        },
        clearable: {
         conditioned: false,
         conditionFunction: "",
         value: false
        },
        multiple: {
         conditioned: false,
         conditionFunction: "",
         value: false
        },
        hideDetails: {
         conditioned: false,
         conditionFunction: "",
         value: false
        },
        dark: {
         conditioned: false,
         conditionFunction: "",
         value: false
        },
        noResize: {
         conditioned: false,
         conditionFunction: "",
         value: false
        },
        dense: {
         conditioned: false,
         conditionFunction: "",
         value: false
        },
        counter: {
         conditioned: false,
         conditionFunction: "",
         value: false
        },
        field: "",
        display_field: true
       }
      }
     ]
    }
   ]
  };
 },

 mounted() {},

 methods: {
  // getColumns() {
  //  axios.post("api/getTableColumns", { table: this.parentData.componentSettings.table }).then(response => {
  //   this.tableColumns = response.data;
  //  });
  // }
 },

 computed: {
  // ...sync("componentManagement", ["allGroups"])
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
