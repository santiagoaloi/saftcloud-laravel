<template>
    <v-app-bar clipped-right dense app >

      <v-container fluid class="py-0 px-0 px-sm-2 fill-height">

      
      <v-app-bar-nav-icon  class="ml-0" text xSmall fab @click="secureDefaultDrawer = !secureDefaultDrawer" />

      <h3 class="ml-3">SaftCloud</h3>

      <div class="flex-grow-1" />

      <v-btn class="mr-2 " text x-small fab to="/">
        <v-icon>mdi-home-variant</v-icon>
      </v-btn>

      <v-btn class="mr-2 " text x-small fab @click="pushDesktop">
        <v-icon>mdi-desktop-mac</v-icon>
      </v-btn>

      <v-menu rounded="xl" origin="center center" transition="scale-transition" :nudge-bottom="10" offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-btn class="mr-2" text x-small fab v-bind="attrs" v-on="on">
            <v-icon>mdi-auto-fix</v-icon>
          </v-btn>
        </template>
           <v-list class="pa-2" rounded="xl" color="rgba(250, 250, 250, 1)" outlined>
            <v-list-item v-for="(item, i) in cmsMenu" :key="i" :to="item.href">
              <v-icon class="mr-5">
                {{ item.icon }}
              </v-icon>
              <v-list-item-title class="mr-5">
                {{ item.title }}
              </v-list-item-title>
            </v-list-item>
          </v-list>
      </v-menu>

      <v-menu rounded="xl" origin="center center" transition="scale-transition" :nudge-bottom="10" offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-btn class="mr-3  " text x-small fab v-bind="attrs" v-on="on">
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>
          <v-list class="pa-2" rounded="xl" color="rgba(250, 250, 250, 1)" outlined>
            <v-list-item v-for="(item, i) in settingsMenu" :key="i" :to="item.href">
              <v-icon class="mr-5">
                {{ item.icon }}
              </v-icon>
              <v-list-item-title class="mr-5">
                {{ item.title }}
              </v-list-item-title>
            </v-list-item>
          </v-list>
      </v-menu>

      <template>
        <v-badge :color="notificationCount > 0 ? 'teal accent-4' : 'transparent'" :content="notificationCount" overlap offset-x="20" offset-y="18">
          <v-btn class="mr-2 " text x-small fab @click="pushNotifications()">
            <v-icon>mdi-bell-ring-outline</v-icon>
          </v-btn>
        </v-badge>
      </template>

      <v-divider inset vertical class="mx-3 grey" />

      <template v-slot:activator="{ attrs }">
        <v-btn class="mr-3" text x-small fab v-bind="attrs">
          <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>
      </template>

      <v-menu rounded="xl" origin="center center" transition="scale-transition" :nudge-bottom="10" offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-btn v-bind="attrs" x-small fab icon class="mr-2" v-on="on">
            <v-avatar size="33px">
              <v-img src="storage/defaults/avatar.png">
                <template v-slot:placeholder>
                  <v-row class="fill-height ma-0" align="center" justify="center">
                    <v-progress-circular indeterminate color="grey lighten-5" />
                  </v-row>
                </template>
              </v-img>
            </v-avatar>
          </v-btn>
        </template>

        <v-card color="rgba(250, 250, 250, 1)" class="mx-auto pa-2" max-width="300" rounded="xl">
          <v-list rounded="xl" color="rgba(250, 250, 250, 1)" outlined>
            <!-- <v-list-item style="cursor: pointer">
            <v-list-item-content>
              <v-list-item-title style="font-size: 130%; font-weight: 600">
                {{ profile.first_name }} {{ profile.last_name }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item> -->

            <v-list-item style="cursor: pointer">
              <v-list-item-content>
                <v-list-item-title style="font-size: 130%; font-weight: 600">
                  firstname lastname
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <!-- <v-list-item style="cursor: pointer; margin-top: -20px">
            <v-list-item-content>
              <v-list-item-title>{{ profile.email }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item> -->

            <v-list-item style="cursor: pointer; margin-top: -20px">
              <v-list-item-content>
                <v-list-item-title>email</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-divider />

            <v-list-item>
              <v-list-item-action>
                <v-icon>mdi-tune-vertical</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Mörkt läge</v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                <v-switch inset @click.stop="setDarkMode()" />
              </v-list-item-action>
            </v-list-item>

            <v-list-item rel="noopener" @click="pushprofile">
              <v-list-item-action>
                <v-icon>mdi-tune-vertical</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Profilinställngar</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item @click="logoutSanctum">
              <v-list-item-action>
                <v-icon>mdi-logout</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Logga ut</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-card>
      </v-menu>
      </v-container>
    </v-app-bar>
  </v-container>
</template>

<script>
import axios from "axios";
import { store } from "@/store";
import { call , sync} from "vuex-pathify";

export default {
  name: "DefaultBar",

  data() {
    return {
      imageLoadingFailed: false,
      notificationCount: 0,
      appBarKey: 1,
      x: 0,
      cmsMenu: [
        {
          icon: "mdi-auto-fix",
          href: "/formBuilder",
          title: "CMS Builder"
        }
      ],

      settingsMenu: [
        {
          icon: "mdi-arrow-expand",
          href: "/appconfig/general",
          title: "Konfiguration"
        },

        {
          icon: "mdi-security",
          href: "/users",
          title: "Konton"
        },

        {
          icon: "mdi-puzzle-outline",
          href: "/components",
          title: "Komponenter"
        },

        {
          icon: "mdi-database-search",
          href: "/SystemSettings/activitylogs",
          title: "Aktivitetsloggar"
        }
      ],

      userMenu: [
        {
          icon: "mdi-cogs",
          href: "/secure/config/general",
          title: "Konfiguration"
        },

        {
          icon: "mdi-security",
          href: "/core/users",
          title: "Användare & Grupper"
        }
      ],

      miniVariant: false
    };
  },

  computed: {
    // profileAvatar() {
    //   if (this.profile.avatar == null || this.imageLoadingFailed) {
    //     return `${this.lazy}avatar.png`;
    //   } else {
    //     return this.profile.avatar;
    //   }
    // }
    // siteInfo() {
    //   return store.state.appData.siteInfo;
    // },
    // profile() {
    //   return store.state.sessionData.userProfile;
    // },
    // groupId() {
    //   return store.state.sessionData.login.group_id;
    // }
  },

  destroyed() {
    window.getApp.$off("APP_SIDEBAR_HAMBURGER");
  },

  mounted() {
    // this.fetchNotificationCount();
    // window.getApp.$on("APP_SIDEBAR_HAMBURGER", () => {
    //   this.miniVariant = true;
    // });
    // window.getApp.$on("APP_REFRESH_NOTIFICATIONS", () => {
    //   this.fetchNotificationCount();
    // });
  },

  computed: {
    ...sync('drawers', [
      'secureDefaultDrawer',
    ]),
  },

  methods: {
    logoutSanctum: call("authentication/logout"),

    setDarkMode() {
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
    },

    fetchNotificationCount() {
      axios.get("site/fetchNotificationCount").then(response => {
        this.notificationCount = response.data.total;
      });
    },

    pushprofile() {
      this.disableModeration();
      this.$router.push("/profile/info");
    },

    pushNotifications() {
      this.$router.push("/notifications");
    },
    pushDesktop() {
      this.disableModeration();
      this.$router.push("/desktop");
    },


  }
};
</script>
