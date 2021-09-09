<template>
 <div>
  <v-app-bar :color="$route.name === '/homepage' ? 'transparent' : '#36393f'" absolute app flat height="80">
   <v-container
    data-aos="fade"
    data-aos-anchor-placement="center-bottom"
    data-aos-delay="300"
    data-aos-once="true"
    data-aos-easing="linear"
    data-aos-duration="400"
    style="background-color:transparent"
    class="py-0 px-0 px-sm-2 fill-height"
   >
    <router-link to="/" class="d-flex align-center  text-decoration-none ml-3">
     <img class="mr-4" src="storage/logo.png" height="45" />
     <span class="font-weight-black headline white--text"> SaftCloud</span>
    </router-link>

    <v-spacer></v-spacer>

    <template v-if="$vuetify.breakpoint.mdAndUp">
     <v-btn rounded height="36" class="mr-3" color="white" text dark x-large plain @click="testFunction()"> Test</v-btn>
     <v-btn rounded to="/signup" height="36" class="mr-3" color="white" text dark x-large plain> Team</v-btn>
     <v-btn rounded to="/signup" height="36" class="mr-3" color="white" text dark x-large plain> Company</v-btn>
     <v-btn rounded to="/signup" height="36" class="mr-3" dark x-large plain> <v-icon left> mdi-account-plus</v-icon>Sign up</v-btn>
     <template>
      <v-btn min-width="100px" to="/login" height="36" class="mr-3" rounded dark color="primary" x-large>
       <v-avatar class="ml-n4 mr-3" size="28" left>
        <v-img src="storage/defaults/avatar.png"></v-img>
       </v-avatar>
       Login</v-btn
      >

      <!-- <v-chip to="/login" link>
            <v-avatar left>
              <v-img :src="getAvatarSoruce()"></v-img>
            </v-avatar>
            Login
          </v-chip> -->
     </template>
     <!-- 
          <v-menu
            v-if="isLoggedIn"
            rounded="xl"
            origin="center center"
            transition="scale-transition"
            :nudge-bottom="10"
            offset-y
          >
            <template v-slot:activator="{ on }">
              <v-chip v-on="on">
                <v-avatar left>
                  <v-img :src="getAvatarSoruce()"></v-img>
                </v-avatar>
                {{ profile.first_name }}
              </v-chip>
            </template>
            <v-card
              color="rgba(250, 250, 250, 1)"
              class="mx-auto pa-2"
              max-width="300"
              rounded="xl"
            >
              <v-list rounded="xl" color="rgba(250, 250, 250, 1)" outlined>
                <v-list-item>
                  <v-list-item-avatar>
                    <v-img :src="getAvatarSoruce()"></v-img>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-title>
                      {{ profile.first_name }}
                      {{ profile.last_name }}</v-list-item-title
                    >
                    <v-list-item-subtitle>{{
                      sessionEmail
                    }}</v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
              <v-list rounded="xl" color="rgba(250, 250, 250, 1)" outlined>
                <v-list-item to="/login">
                  <v-list-item-action>
                    <v-icon>mdi-view-dashboard-outline</v-icon>
                  </v-list-item-action>
                  <v-list-item-subtitle>POS Console</v-list-item-subtitle>
                </v-list-item>
                <v-list-item @click="logout()">
                  <v-list-item-action>
                    <v-icon>mdi-logout</v-icon>
                  </v-list-item-action>
                  <v-list-item-subtitle>Log Out</v-list-item-subtitle>
                </v-list-item>
              </v-list>
            </v-card>
          </v-menu> -->
    </template>
    <template v-else>
     <v-btn fab class="mr-3" color="white" text small dark>
      <v-icon> mdi-menu</v-icon>
     </v-btn>
    </template>

    <v-tooltip transition="false" color="black" bottom>
     <template v-slot:activator="{ on }">
      <v-btn v-on="on" @click="isDark = !isDark" fab class="mr-3" color="white" text dark small plain>
       <v-icon v-if="isDark">mdi-lightbulb-on-outline</v-icon>
       <v-icon v-else>mdi-lightbulb-outline</v-icon></v-btn
      >
     </template>
     <span> {{ isDark ? " Light mode" : "Dark mode" }}</span>
    </v-tooltip>
   </v-container>
  </v-app-bar>
 </div>
</template>

<script>
import { store } from "@/store";
import axios from "axios";
import { sync, get, call } from "vuex-pathify";
export default {
 name: "PublicAppbar",

 data() {
  return {
   responsiveMenu: false,
   store: store,
   navMenu: [
    {
     name: "aktuellt",
     href: "pub_aktuellt",
     disabled: false
    },
    {
     name: "Portfolio",
     href: "portfolio",
     disabled: false
    },
    {
     name: "Bli medlem",
     href: "medlem",
     disabled: false
    },
    {
     name: "Press",
     href: "press",
     disabled: false
    },
    {
     name: "Om oss",
     href: "om",
     disabled: false
    },
    {
     name: "Kontakt",
     href: "kontakt",
     disabled: false
    },
    {
     name: "English",
     href: "english",
     disabled: false
    }
   ]
  };
 },

 computed: {
  ...sync("theme", ["isDark"])
 },

 methods: {
  async testFunction() {
   let post = { email: "facu.ft@gmail.com", password: 'password'};
   axios
    .get("api/componentConstructor/2", post)
    .then(response => {
     if (response.status === 200) {
      console.log(response);
     }
    })
    .catch(error => {
     console.log({ ...error });
    });
  }
 }
};
</script>

<style scoped lang="scss">
.v-chip.v-size--default {
 height: 36px;
}

::v-deep [data-v-4be6215a] .v-toolbar__content,
.v-toolbar__extension[data-v-4be6215a] {
 border-bottom: 0px solid #ccc !important;
}

.header-logo:hover {
 opacity: 0.8;
}
.userLink {
 letter-spacing: 1px;
 text-transform: uppercase;
 font-weight: 600;
 font-size: 13px;
 color: black;
 &:hover {
  color: #909090;
  visibility: visible;
 }
}

.menuActive {
 letter-spacing: 1px;
 position: relative;
 text-decoration: none;
 font-weight: 300;
 font-size: 13px;
 color: #909090;
 transition: all 0.35s ease;

 &::before {
  content: "";
  position: absolute;
  width: 95%;
  height: 0.8px;
  bottom: -10px;
  left: 0;
  background-color: #606060;
  visibility: visible;
  -webkit-transform: scaleX(1.1);
  transform: scaleX(1.1);
 }

 &:hover {
  color: #909090;

  &::before {
   visibility: visible;
   -webkit-transform: scaleX(1.1);
   transform: scaleX(1.1);
  }
 }
}

.menu {
 letter-spacing: 1px;
 position: relative;
 text-decoration: none;
 font-weight: 300;
 font-size: 13px;
 color: black;
 transition: all 0.35s ease;

 &::before {
  content: "";
  position: absolute;
  width: 95%;
  height: 0.8px;
  bottom: -10px;
  left: 0;
  background-color: #606060;
  visibility: hidden;
 }

 &::before {
  content: "";
  position: absolute;
  width: 95%;
  height: 0.8px;
  bottom: -10px;
  left: 0;
  background-color: #606060;
  visibility: hidden;
 }

 &:hover {
  color: #909090;

  &::before {
   visibility: visible;
   -webkit-transform: scaleX(1.1);
   transform: scaleX(1.1);
  }
 }
}

.capitalLetters {
 font-weight: 600;
 text-transform: uppercase;
 font-size: 13px;
}
.menu-option:last-child {
 padding-right: 12px !important;
}
.v-toolbar {
 transition-duration: 0s, 0s, 0s, 0s, 0ms, 0s, 0s;
}

.responsiveMenu {
 position: fixed;
 top: 100px;
 right: 0;
 width: 200px;
 z-index: 1;
 .menu-item {
  display: flex;
  justify-content: flex-end;
 }
}

::v-deep .v-toolbar__content,
.v-toolbar__extension {
 border-bottom: 1px solid #ccc;
}

@media screen and (min-width: 960px) {
 .responsiveMenu {
  top: 120px;
 }
}
</style>
