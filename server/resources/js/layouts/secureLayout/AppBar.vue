<template>
 <v-app-bar :class="{ darkBorder: isDark }" :flat="isDark" clipped-right app height="80">
  <v-app-bar-nav-icon dark class="ml-n2 mr-3" text xSmall fab @click="secureDefaultDrawer = !secureDefaultDrawer" />

  <h4 style="position:absolute" class="white--text ml-9">{{ routeTitle }}</h4>

  <div class="flex-grow-1" />

  <v-text-field
   v-lazy-input:debounce="200"
   v-model="search"
   spellcheck="false"
   :outlined="isDark"
   :solo="!isDark"
   :color="isDark ? '#208ad6' : 'grey'"
   :background-color="isDark ? '#28292b' : 'white'"
   dense
   hide-details
   placeholder="Search..."
   prepend-inner-icon="mdi-magnify"
   :class="expand ? 'expanded' : 'shrinked'"
   class="mx-15 pr-1"
   @focus="expand = true"
   @blur="expand = false"
   rounded
  />

  <v-btn dark class="mr-3" text x-small fab to="/">
   <v-icon>mdi-home-variant</v-icon>
  </v-btn>

  <v-menu origin="center center" transition="scroll-y-transition" :nudge-bottom="10" offset-y>
   <template v-slot:activator="{ on, attrs }">
    <v-btn dark class="mr-3" text x-small fab v-bind="attrs" v-on="on">
     <v-icon>mdi-dots-vertical</v-icon>
    </v-btn>
   </template>
   <v-list class="pa-2" outlined>
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
    <v-btn dark class="mr-3 " text x-small fab @click="pushNotifications()">
     <v-icon>mdi-bell-ring-outline</v-icon>
    </v-btn>
   </v-badge>
  </template>

  <v-menu origin="center center" transition="scroll-y-transition" :nudge-bottom="10" offset-y>
   <template v-slot:activator="{ on, attrs }">
    <v-btn dark class="mr-3" text x-small fab v-bind="attrs" v-on="on">
     <v-icon>mdi-earth</v-icon>
    </v-btn>
   </template>
   <v-list link class="pa-2" outlined>
    <v-list-item v-for="(language, i) in languages" :key="i" :to="language.name">
     <country-flag class="mr-0" :country="language.flag" />
     <v-list-item-content>
      <v-list-item-title class="mr-5">
       {{ language.name }}
      </v-list-item-title>
     </v-list-item-content>
    </v-list-item>
   </v-list>
  </v-menu>

  <v-divider inset vertical class="ml-3 mr-6  grey" />

  <template v-slot:activator="{ attrs }">
   <v-btn class="mr-3" text x-small fab v-bind="attrs">
    <v-icon>mdi-dots-vertical</v-icon>
   </v-btn>
  </template>

  <v-menu origin="center center" transition="scroll-y-transition" :nudge-bottom="10" offset-y>
   <template v-slot:activator="{ on, attrs }">
    <v-btn v-bind="attrs" x-small fab icon class="mr-2" v-on="on">
     <v-avatar size="33px">
      <v-img src="storage/defaults/avatar.png">
       <template v-slot:placeholder>
        <v-row class="fill-height ma-0" align="center" justify="center">
         <v-progress-circular indeterminate color="white" />
        </v-row>
       </template>
      </v-img>
     </v-avatar>
    </v-btn>
   </template>

   <v-list class="pa-2" outlined>
    <v-list-item class="cursor-pointer">
     <v-list-item-content>
      <v-list-item-title style="font-size: 130%; font-weight: 600">
       firstname lastname
      </v-list-item-title>
     </v-list-item-content>
    </v-list-item>

    <v-list-item class="cursor-pointer" style="margin-top: -20px">
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
      <v-list-item-title>{{ isDark ? "Light theme" : "Dark theme" }} </v-list-item-title>
     </v-list-item-content>
     <v-list-item-action>
      <v-switch v-model="isDark" :ripple="false" color="grey darken-1" @click.stop />
     </v-list-item-action>
    </v-list-item>

    <v-list-item @click="pushprofile">
     <v-list-item-action>
      <v-icon>mdi-tune-vertical</v-icon>
     </v-list-item-action>
     <v-list-item-content>
      <v-list-item-title>Profile settings</v-list-item-title>
     </v-list-item-content>
    </v-list-item>

    <v-list-item @click="logout()">
     <v-list-item-action>
      <v-icon>mdi-logout</v-icon>
     </v-list-item-action>
     <v-list-item-content>
      <v-list-item-title>Sign out</v-list-item-title>
     </v-list-item-content>
    </v-list-item>
   </v-list>
  </v-menu>
 </v-app-bar>
</template>

<script>
import axios from "axios";
import { store } from "@/store";
import { call, sync } from "vuex-pathify";
import CountryFlag from "vue-country-flag";

export default {
 name: "SecureAppbar",
 components: {
  CountryFlag
 },

 data() {
  return {
   expand: false,
   imageLoadingFailed: false,
   notificationCount: 0,

   languages: [
    {
     flag: "GB",
     name: "English"
    },
    {
     flag: "ES",
     name: "Espanol"
    }
   ],

   settingsMenu: [
    {
     icon: "mdi-arrow-expand",
     href: "/appconfig/general",
     title: "Configuration"
    },

    {
     icon: "mdi-security",
     href: "/accounts",
     title: "Accounts"
    },

    {
     icon: "mdi-puzzle-outline",
     href: "/components",
     title: "Components"
    },

    {
     icon: "mdi-database-search",
     href: "/SystemSettings/activitylogs",
     title: "Logs"
    }
   ],

   userMenu: [
    {
     icon: "mdi-cogs",
     href: "/secure/config/general",
     title: "Configuration"
    },

    {
     icon: "mdi-security",
     href: "/core/users",
     title: "Users and Groups"
    }
   ],

   miniVariant: false
  };
 },

 computed: {
  ...sync("theme", ["isDark"]),
  ...sync("application", ["search"]),
  ...sync("drawers", ["secureDefaultDrawer"]),

  routeTitle() {
   return this.$route.meta.title;
  }
 },

 methods: {
  ...call("authentication/*"),

  fetchNotificationCount() {
   axios.get("site/fetchNotificationCount").then(response => {
    this.notificationCount = response.data.total;
   });
  },

  pushprofile() {
   this.$router.push("/profile/info");
  },

  pushNotifications() {
   this.$router.push("/notifications");
  },
  pushDesktop() {
   this.$router.push("/desktop");
  }
 }
};
</script>
<style scoped>
.darkBorder {
 border-bottom: solid 1px #404859;
}
</style>
