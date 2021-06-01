<template>
  <div>
    <v-app-bar absolute dense class="px-2">
      <v-btn :disabled="previousComponentDisabled()" @click="previousComponent()" class="mr-2" fab text x-small>
        <v-icon>mdi-chevron-left</v-icon>
      </v-btn>
      <v-btn :disabled="nextComponentDisabled()" @click="nextComponent()" fab text x-small>
        <v-icon>mdi-chevron-right</v-icon>
      </v-btn>
      <v-spacer></v-spacer>

      <v-select
        solo
        hide-details
        flat
        dense
        :items="items"
        :menu-props="{ top: true, offsetY: true }"
        label="Choose component"
      ></v-select>

      <v-btn @click="secureComponentDrawer = false" fab text x-small>
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-app-bar>

    <v-list class="mt-13">
      <v-list-item>
        <v-list-item-avatar>
          <v-icon :color="activeComponent.config_settings.icon.color">
            {{ activeComponent.config_settings.icon.name }}
          </v-icon>
        </v-list-item-avatar>

        <v-list-item-content>
          <v-list-item-title>{{ activeComponent.config.title }}</v-list-item-title>
        </v-list-item-content>

        <v-list-item-icon>
          <v-icon>
            mdi-star
          </v-icon>
        </v-list-item-icon>
      </v-list-item>
    </v-list>

    <v-card flat class="mx-auto pa-1 mt-n3" max-width="344">
      <v-card-text>
        <div class="text--primary">
          {{ activeComponent.config.note }}
        </div>
      </v-card-text>
    </v-card>

    <template>
      <div class="text-center mb-3">
        <v-btn depressed class="mx-2" height="70" dark large small color="white">
          <v-icon color="orange" large dark>
            mdi-pencil-outline
          </v-icon>
        </v-btn>
        <v-btn depressed class="mx-2" height="70" dark large small color="white">
          <v-icon color="black" large dark>
            mdi-link
          </v-icon>
        </v-btn>
        <v-btn @click="removeComponent(activeComponent.id)" depressed class="mx-2" height="70" dark large small color="white">
          <v-icon color="pink" large dark>
            mdi-trash-can-outline
          </v-icon>
        </v-btn>
      </div>
    </template>

    <template>
      <v-card flat class="mx-auto">
        <v-list subheader two-line>
          <v-subheader>Database</v-subheader>

          <v-list-item>
            <v-list-item-icon>
              <v-icon color="indigo">
                mdi-table
              </v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title> {{ activeComponent.config.sql_table }}</v-list-item-title>
              <v-list-item-subtitle>Table</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-list-item>
            <v-list-item-icon>
              <v-icon color="indigo">
                mdi-table-row
              </v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>{{ activeComponent.config.columns.length }}</v-list-item-title>
              <v-list-item-subtitle> Table columns</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-divider></v-divider>

          <v-list-item>
            <v-list-item-icon>
              <v-icon color="indigo">
                mdi-calendar-plus
              </v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>Created</v-list-item-title>
              <v-list-item-subtitle> {{ activeComponent.created_at }} </v-list-item-subtitle>
              <v-list-item-subtitle>12 days ago</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-list-item>
            <v-list-item-icon>
              <v-icon color="indigo">
                mdi-calendar-edit
              </v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>Edited</v-list-item-title>
              <v-list-item-subtitle> {{ activeComponent.updated_at }} </v-list-item-subtitle>
              <v-list-item-subtitle>8 days ago</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-divider></v-divider>

          <v-container>
            <small>Component group </small>
            <v-autocomplete
              @update:search-input="catchGroupInputValue($event)"
              solo
              :items="allGroups"
              :maxlength="25"
              item-value="id"
              item-text="name"
              hide-no-data
            />
          </v-container>
        </v-list>
      </v-card>
    </template>
  </div>
</template>

<script>
import { sync } from "vuex-pathify";

export default {
  data: () => ({
    items: ["Foo", "Bar", "Fizz", "Buzz"]
  }),
  computed: {
    ...sync("drawers", ["secureComponentDrawer"]),
    ...sync("componentManagement", ["componentCardGroup", "allComponents", "allGroups"]),

    activeComponent() {
      return this.allComponents[this.componentCardGroup];
    }
  },

  methods: {
    removeComponent(id) {
      axios.delete(`api/Component/${id}`).then(response => {
        if (response.data.status) {
          this.allComponents = response.data.components;
        }
      });
    },

    previousComponent() {
      if (this.componentCardGroup > 0) {
        this.componentCardGroup--;
      }
    },

    previousComponentDisabled() {
      if (this.componentCardGroup === 0) {
        return true;
      }
    },

    nextComponent() {
      if (this.componentCardGroup < this.allComponents.length - 1) {
        this.componentCardGroup++;
      }
    },

    nextComponentDisabled() {
      if (this.componentCardGroup === this.allComponents.length - 1) {
        return true;
      }
    }
  }
};
</script>
