<template>
  <div>
    <v-app-bar
      :color="$route.name === '/Homepage' ? 'transparent' : '#36393f'"
      app
      flat
      height="70"
      src="storage/appbar/prism2.jpg"
    >
      <v-container
        data-aos="fade"
        data-aos-anchor-placement="center-bottom"
        data-aos-delay="300"
        data-aos-once="true"
        data-aos-easing="linear"
        data-aos-duration="400"
        style="background-color: transparent"
        class="py-0 px-0 fill-height"
      >
        <router-link to="/" class="d-flex align-center text-decoration-none">
          <img class="mr-4" src="storage/logo.png" height="45" />
          <span class="font-weight-black headline white--text"> SaftCloud ™</span>
        </router-link>

        <v-spacer />

        <template v-if="$vuetify.breakpoint.mdAndUp">
          <v-btn
            height="36"
            rounded
            class="mr-3"
            color="white"
            text
            dark
            plain
            x-large
            @click="testFunction()"
          >
            Test
          </v-btn>
          <v-btn
            rounded
            to="/signup"
            height="36"
            class="mr-3"
            color="white"
            text
            dark
            x-large
            plain
          >
            Team
          </v-btn>
          <v-btn
            rounded
            to="/signup"
            height="36"
            class="mr-3"
            color="white"
            text
            dark
            x-large
            plain
          >
            Company
          </v-btn>
          <v-btn rounded to="/signup" height="36" class="mr-3" dark x-large plain>
            <v-icon left> mdi-account-plus </v-icon>Sign up
          </v-btn>
          <v-btn
            min-width="100px"
            to="/Login"
            height="36"
            class="mr-3"
            rounded
            dark
            color="primary"
            x-large
          >
            <v-avatar class="ml-n4 mr-3" size="28" left>
              <v-img v-if="user" :src="user.avatar">
                <template #placeholder>
                  <v-row class="fill-height ma-0" align="center" justify="center">
                    <v-progress-circular indeterminate color="white" />
                  </v-row>
                </template>
              </v-img>
              <v-img v-else src="storage/defaults/avatar.png" />
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
            <v-btn
              fab
              class="mr-3"
              color="white"
              text
              dark
              small
              plain
              v-on="on"
              @click="isDark = !isDark"
            >
              <v-icon v-if="isDark"> mdi-lightbulb-on-outline </v-icon>
              <v-icon v-else> mdi-lightbulb-outline </v-icon>
            </v-btn>
          </template>
          <span> {{ isDark ? ' Light mode' : 'Dark mode' }}</span>
        </v-tooltip>
      </v-container>
    </v-app-bar>
  </div>
</template>

<script>
  import axios from 'axios';
  import { sync } from 'vuex-pathify';
  import { store } from '@/store';

  export default {
    name: 'PublicAppbar',

    data() {
      return {
        responsiveMenu: false,
        store,
        navMenu: [
          {
            name: 'aktuellt',
            href: 'pub_aktuellt',
            disabled: false,
          },
          {
            name: 'Portfolio',
            href: 'portfolio',
            disabled: false,
          },
          {
            name: 'Bli medlem',
            href: 'medlem',
            disabled: false,
          },
          {
            name: 'Press',
            href: 'press',
            disabled: false,
          },
          {
            name: 'Om oss',
            href: 'om',
            disabled: false,
          },
          {
            name: 'Kontakt',
            href: 'kontakt',
            disabled: false,
          },
          {
            name: 'English',
            href: 'english',
            disabled: false,
          },
        ],
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      user: sync('authentication@session.user'),
    },

    methods: {
      async testFunction() {
        const post = { email: 'facu.ft@gmail.com', password: 'password' };
        axios
          .get('api/testFunction')
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
