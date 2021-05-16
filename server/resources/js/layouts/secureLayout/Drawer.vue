<template>
  <div>
    <v-navigation-drawer
      v-model="drawer"
      hide-overlay
      :mobile-breakpoint="0"
      disable-resize-watcher
      :style="
        $vuetify.breakpoint.smAndDown
          ? 'background: rgba(43, 54, 67, 0.9);width: 100vw!important;'
          : 'background:  rgba(45, 45, 45, 0.7)'
      "
      :src="background"
      dark
      app
      clipped
      width="250"
      :temporary="$vuetify.breakpoint.smAndDown || isTemporary"
    >
      <div class="mt-2">
        <template v-if="$vuetify.breakpoint.smAndDown || isTemporary">
          <v-list style="margin-left: 7px; cursor: pointer" dense>
            <v-list-item @click="closeDrawer()">
              <v-list-item-icon>
                <v-icon>mdi-close</v-icon>
              </v-list-item-icon>

              <v-list-item-content>
                <v-list-item-title>Stäng</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </template>

        <v-card color="transparent" class="mx-auto pa-3" rounded="xl" flat>
          <template v-for="(item, i) in menus">
            <v-list
              class="py-1"
              v-if="item.items"
              :key="i"
              rounded="xl"
              color="transparent"
              dense
              style="text-transform: uppercase"
            >
              <!--group with subitems-->
              <v-list-group
                v-if="item.items"
                color="white"
                :group="item.group"
                no-action="no-action"
                mandatory
              >
                <v-list-item slot="activator">
                  <v-tooltip
                    open-delay="450"
                    nudge-bottom="5"
                    max-width="250"
                    close-delay="100"
                    right
                  >
                    <template v-slot:activator="{ on }">
                      <v-list-item-icon v-on="on">
                        <!-- <v-icon>{{ item.icon }}</v-icon> -->
                        <v-icon>mdi-folder</v-icon>
                      </v-list-item-icon>
                    </template>
                    <span>{{ item.title }}</span>
                  </v-tooltip>

                  <v-list-item-content>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>

                <template v-for="(subItem, i) in item.items">
                  <!-- SubGroup -->
                  <v-list-group
                    v-if="subItem.items"
                    :key="subItem.name"
                    :group="subItem.group"
                    sub-group="sub-group"
                  >
                    <v-list-item slot="activator">
                      <v-list-item-content>
                        <v-list-item-title>{{
                          subItem.title
                        }}</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>

                    <v-list-item
                      v-for="(grand, i) in subItem.items"
                      :key="i"
                      active-class="white--text grey lighten-2"
                      :to="genChildTarget(item, grand)"
                      :href="grand.href"
                    >
                      <v-list-item-content>
                        <v-list-item-title>{{ grand.title }}</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list-group>

                  <!--Childs-->
                  <v-list-item
                    v-else
                    :key="i"
                    :to="genChildTarget(item, subItem)"
                    :href="subItem.href"
                    :target="subItem.target"
                    :disabled="subItem.disabled"
                    @click="
                      if ($vuetify.breakpoint.smAndDown) {
                        drawer = false;
                      }
                    "
                  >
                    <v-list-item-icon>
                      <v-icon>{{ subItem.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                      <v-list-item-title>
                        <span>{{ subItem.title }}</span>
                      </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </template>
              </v-list-group>

              <v-subheader v-else-if="item.header" :key="i">
                {{ item.header }}
              </v-subheader>

              <v-divider v-else-if="item.divider" :key="i" />

              <!--top-level link-->
              <v-list-item
                v-else
                :key="item.name"
                :to="!item.href ? { name: item.name } : null"
                :disabled="item.disabled"
              >
                <v-list-item-action v-if="item.icon">
                  <v-icon>mdi-folder</v-icon>
                </v-list-item-action>

                <v-list-item-content>
                  <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item-content>

                <v-list-item-action v-if="item.subAction">
                  <v-icon class="red--text">
                    {{ item.subAction }}
                  </v-icon>
                </v-list-item-action>
              </v-list-item>
            </v-list>
          </template>
        </v-card>
      </div>

      <v-footer color="rgba(43, 54, 67, 0.7)" absolute>
        <v-icon
          v-ripple
          style="cursor: pointer"
          @click="isTemporary = !isTemporary"
        >
          mdi-dock-window
        </v-icon>
      </v-footer>
    </v-navigation-drawer>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Sidemenu",

  filters: {
    capitalize: function(value) {
      if (!value) return "";
      value = value.toString();
      return value.charAt(0).toUpperCase() + value.slice(1);
    }
  },

  data() {
    return {
      isTemporary: false,
      menuGroup: "",
      x: 0,
      y: 0,
      items: [],
      menusFolder: null,
      menus: null,
      avatar: null,
      fixed: false,
      miniVariant: "",
      drawer: false,
      search: "",
      background: "storage/systemImages/nav.png"
    };
  },

  computed: {},

  mounted() {
    // this.loadApiMenu();
  },

  destroyed() {
    window.getApp.$off("APP_DRAWER_TOGGLED");
    window.getApp.$off("APP_RELOAD_MENU");
  },

  created() {
    window.getApp.$on("APP_DRAWER_TOGGLED", () => {
      this.drawer = !this.drawer;
    });

    window.getApp.$on("APP_RELOAD_MENU", () => {
      this.loadApiMenu();
    });
  },

  methods: {
    closeDrawer() {
      this.drawer = false;
    },

    loadApiMenu() {
      axios
        .get("site/apimenu")
        .then(response => {
          if (response.data.status == "success") {
            this.menus = response.data.data;
            this.menusFolder = response.data.folder;
          }
        })
        .catch(error => {
          console.log(error.response);
          this.logoutVuex();
        });
    },

    genChildTarget(item, subItem) {
      if (subItem.href) return;
      if (subItem.component) {
        return {
          name: subItem.component
        };
      }
      return { name: `${subItem.name}` };
    }
  }
};
</script>
<style scoped>
::v-deep .v-list-item {
  padding: 0 7px;
}

.v-application--is-ltr
  .v-list-group--no-action
  > .v-list-group__items
  > .v-list-item {
  padding-left: 14px !important;
}

.rounded {
  width: 100px !important;
  height: 100px !important;
  position: relative;
  overflow: hidden;
  border-radius: 50%;
  z-index: 999999 !important;
  margin-top: -1em !important;
  margin-left: 4.5em !important;
  margin-bottom: 1em !important;
}

::v-deep .v-navigation-drawer {
  transition-duration: 0.05s !important;
  transition-timing-function: linear;
}

.shadows {
  text-shadow: rgba(61, 61, 61, 0.1) 1px 1px, rgba(149, 207, 245, 0.3) 1px 1px;
}
</style>
