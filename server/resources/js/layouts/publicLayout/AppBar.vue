<template>
  <fragment>
    <v-app-bar v-show="imageLoaded" class="select-none" elevation="5" app src="storage/appbar/prism2.jpg">
      <v-container data-aos="fade" data-aos-delay="300" class="py-0 px-0 fill-height">
        <router-link to="/" class="d-flex align-center text-decoration-none">
          <img class="mr-4" src="storage/logo.png" height="45" @load="imageLoaded = true" />
          <span class="font-weight-black headline white--text"> SaftCloud ™</span>
        </router-link>

        <v-spacer />

        <template v-if="$vuetify.breakpoint.mdAndUp">
          <v-btn height="36" rounded class="mr-3" color="white" text dark plain x-large @click="testFunction()"> Test </v-btn>
          <v-btn rounded to="/Signup" height="36" class="mr-3" color="white" text dark x-large plain> Team </v-btn>
          <v-btn rounded to="/Signup" height="36" class="mr-3" color="white" text dark x-large plain> Company </v-btn>
          <v-btn rounded to="/signup" height="36" class="mr-3" dark x-large plain>
            <v-icon left> mdi-account-plus </v-icon>Sign up
          </v-btn>
          <v-btn min-width="100px" to="/Components" height="36" class="mr-3" rounded dark color="primary" x-large>
            <v-avatar class="ml-n4 mr-3" size="28" left>
              <v-img :src="user ? user.avatar || 'storage/defaults/avatar.png' : 'storage/defaults/avatar.png'">
                <template #placeholder>
                  <v-row class="fill-height ma-0" align="center" justify="center">
                    <v-progress-circular indeterminate color="white" />
                  </v-row>
                </template>
              </v-img>
            </v-avatar>
            {{ user ? 'Dashboard' : 'Login' }}
          </v-btn>
        </template>
        <template v-else>
          <v-btn fab class="mr-3" color="white" text small dark>
            <v-icon> mdi-menu</v-icon>
          </v-btn>
        </template>

        <v-tooltip transition="false" color="black" bottom>
          <template #activator="{ on }">
            <v-btn fab class="mr-3" color="white" text dark small plain v-on="on" @click="setTheme()">
              <v-icon v-if="isDark"> mdi-lightbulb-on-outline </v-icon>
              <v-icon v-else> mdi-lightbulb-outline </v-icon>
            </v-btn>
          </template>
          <span> {{ isDark ? ' Light mode' : 'Dark mode' }}</span>
        </v-tooltip>
      </v-container>
    </v-app-bar>
  </fragment>
</template>

<script>
  import axios from 'axios';
  import { sync } from 'vuex-pathify';
  import { store } from '@/store';

  export default {
    name: 'PublicAppbar',

    data() {
      return {
        imageLoaded: false,
        responsiveMenu: false,
        store,
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      user: sync('authentication@session.user'),
    },

    methods: {
      setTheme() {
        this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
        this.isDark = !this.isDark;
      },

      async testFunction() {
        const post = { user: 1 };
        axios
          .get('api/getModules')
          .then((response) => {
            if (response.status === 200) {
              console.log(response);
            }
          })
          .catch((error) => {
            console.log({ ...error });
          });
      },
    },
  };
</script>
