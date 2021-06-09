Refresh all component configuration structure
<template>
  <baseDialog
    v-model="internalValue"
    title="Advanced operations"
    persistent
    max-width="900"
    show-remove
    @close="() => (internalValue = false)"
  >
    <v-card color="#f8f9fa">
      <v-card-text>
        <v-container>
          <v-list color="transparent">
            <v-list-item>
              <v-list-item-icon>
                <v-btn @click="updateConfigStructure()">
                  <v-icon> mdi-cog</v-icon>
                </v-btn>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title
                  >Refresh all component configuration
                  structure</v-list-item-title
                >
                <v-list-item-subtitle>
                  Update v_components config column for all components with new
                  structure. This will remove old keys, rename old values and
                  compare object structures with template structures to keep
                  consistency. This might require re-configuration in components
                  where certain configurations won't be valid anymore.
                </v-list-item-subtitle>
                <v-list-item-subtitle>
                  It does not replace existing values.
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-divider />
          </v-list>
        </v-container>
      </v-card-text>
    </v-card>
  </baseDialog>
</template>
<script>
import formFieldStructure from "@/util/formFieldStructure";
import componentConfigStructure from "@/util/componentConfigStructure";

import axios from "axios";
import cloneDeep from "lodash/cloneDeep";
import isEmpty from "lodash/isEmpty";

export default {
  name: "SystemOperations",
  inheritAttrs: true,

  props: {
    value: Boolean,
  },

  data() {
    return {
      internalValue: this.value,
      componentList: [],
      updatedComponentList: [],
      formFieldStructure: formFieldStructure,
      componentConfigStructure: componentConfigStructure,
    };
  },

  watch: {
    internalValue(val, oldVal) {
      if (val === oldVal) return;

      this.$emit("input", val);
    },
    value(val, oldVal) {
      if (val === oldVal) return;

      this.internalValue = val;
    },
  },

  mounted() {
    this.fetchComponentsConfig();
  },

  methods: {

    // First argument is the object to modify, second is the structure to follow.
    compareAndModifyObject(object, template) {
      (function addFromTemplate(obj, temp) {
        for (var prop in temp) {
          // Unknown to `obj`! Add it
          if (!(prop in obj)) {
            obj[prop] = temp[prop];
          } else if ( typeof obj[prop] == "object" && typeof temp[prop] == "object" ) {
            addFromTemplate(obj[prop], temp[prop]); // Nested objects! Recursion-step
          }
        }
      })(object, template); // Start adding to `object` from `template`

      (function removeFromObject(obj, temp) {
        for (var prop in obj) {
          if (!(prop in temp)) delete obj[prop];
          // Unknown to `temp`! Remove it
          else if (
            typeof obj[prop] == "object" &&
            typeof temp[prop] == "object"
          )
            removeFromObject(obj[prop], temp[prop]); // Nested objects! Recursion-step
        }
      })(object, template); // Start removing properties of `object`
    },

    fetchComponentsConfig() {
      axios.get("sximo/components/getAllComponentConfig/").then((response) => {
        if (response.data.status == "success") {
          let payload = response.data.data;

          let counter = 0;
          payload.forEach((component) => {
            counter++;
            if (component.config != "") {
              component.config = JSON.parse(component.config);
            }

            // Remove old keys, rename grid and forms
            if ("forms" in component.config) {
              delete Object.assign(component.config, {
                ["formFields"]: component.config["forms"],
              })["forms"];
            }

            if ("grid" in component.config) {
              delete Object.assign(component.config, {
                ["columns"]: component.config["grid"],
              })["grid"];
            }

            // if component config is missing, create it empty.
            if (!component.config.componentConfig) {
              component.config.componentConfig = {};
            }

            //remove unused object
            delete component.config["setting"];

            if (counter == payload.length) {
              this.componentList = payload;
            }
          });
        } else {
          console.log("error getting components list");
        }
      });
    },

    updateConfigStructure() {
      this.$swal({
        title: "Update all components",
        text:
          "This will rename old configuration values and remove unused keys. This operation cannot be undone. It is strongly recommended to backup v_components table in the database, before proceeding.",
        showCancelButton: true,
        confirmButtonText: "Continue",
        cancelButtonText: "Cancel",
        confirmButtonColor: "grey",
        backdrop: "rgba(108, 122, 137, 0.8)",
        width: 500,
        icon: "warning",
      }).then((result) => {
        if (result.value) {
          this.updatedComponentList = cloneDeep(this.componentList);
          let counter = 0;
          this.updatedComponentList.forEach((component) => {
            counter++;
            component.config.formFields.forEach((config) => {
              //Compare formFields structure
              this.compareAndModifyObject(config, this.formFieldStructure);
              config.alias = component.config.table_db;
            });

            //Compare componentConfigStructure structure
            this.compareAndModifyObject(
              component.config.componentConfig,
              this.componentConfigStructure
            );

            component.config = JSON.stringify(component.config);

            if (counter == this.updatedComponentList.length) {
              this.save();
            }
          });
        } else {
          console.log("cancel");
        }
      });
    },

    save() {
      axios
        .post(
          "sximo/components/saveAllComponentConfig/",
          this.updatedComponentList
        )
        .then((response) => {
          if (response.data.status == "success") {
            window.getApp.$emit(
              "APP_SHOW_SNACKBAR",
              "teal accent-4",
              "mdi-information-variant",
              "Component settings saved."
            );
          }
        });
    },
  },
};
</script>
