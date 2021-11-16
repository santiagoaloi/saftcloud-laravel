<template>
  <div class="select-none">
    <v-app-bar clipped-right app flat>
      <v-app-bar-nav-icon dark class="ml-n2 mr-3" text x-small fab @click="secureDefaultDrawer = !secureDefaultDrawer" />

      <h4 style="position: absolute" class="white--text ml-8">
        {{ routeTitle }}
      </h4>

      <div class="flex-grow-1" />

      <v-text-field
        v-model="search"
        v-lazy-input:debounce="200"
        clearable
        spellcheck="false"
        outlined
        :color="isDark ? '#208ad6' : 'grey'"
        dense
        flat
        solo
        hide-details
        :placeholder="'Search ' + ($route.meta.search || '...')"
        prepend-inner-icon="mdi-magnify"
        :class="expand ? 'expanded' : 'shrinked'"
        class="mx-11 pr-12"
        rounded
        @focus="expand = true"
        @blur="expand = false"
      />

      <v-tooltip transition="false" color="black" bottom>
        <template #activator="{ on }">
          <v-btn x-small fab class="mr-3" color="white" text dark plain v-on="on" @click="setTheme()">
            <v-icon v-if="isDark"> mdi-lightbulb-on-outline </v-icon>
            <v-icon v-else> mdi-lightbulb-outline </v-icon>
          </v-btn>
        </template>
        <span> {{ isDark ? ' Light mode' : 'Dark mode' }}</span>
      </v-tooltip>

      <v-btn x-small fab class="mr-3" text dark plain to="/">
        <v-icon>mdi-home-variant</v-icon>
      </v-btn>

      <v-menu origin="center center" transition="scroll-y-transition" :nudge-bottom="10" offset-y>
        <template #activator="{ on, attrs }">
          <v-btn x-small fab class="mr-3" text dark plain v-bind="attrs" v-on="on">
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>
        <v-list class="pa-2" outlined>
          <v-list-item v-for="(item, i) in settingsMenuFiltered" :key="i" :to="item.href">
            <v-icon class="mr-5">
              {{ item.icon }}
            </v-icon>
            <v-list-item-title class="mr-5">
              {{ item.title }}
            </v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>

      <v-badge
        :color="notificationCount > 0 ? 'teal accent-4' : 'transparent'"
        :content="notificationCount"
        overlap
        offset-x="20"
        offset-y="18"
      >
        <v-btn x-small fab class="mr-3" text dark plain @click="pushNotifications()">
          <v-icon>mdi-bell-ring-outline</v-icon>
        </v-btn>
      </v-badge>

      <v-menu origin="center center" transition="scroll-y-transition" :nudge-bottom="10" offset-y>
        <template #activator="{ on, attrs }">
          <v-btn x-small fab class="mr-3" text dark plain v-bind="attrs" v-on="on">
            <v-icon>mdi-earth</v-icon>
          </v-btn>
        </template>
        <v-list link class="pa-2" outlined>
          <v-list-item v-for="(language, i) in languages" :key="i" :to="language.name">
            <!-- <country-flag class="mr-0" :country="language.flag" /> -->
            <v-list-item-content>
              <v-list-item-title class="mr-5">
                {{ language.name }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-menu>

      <v-divider inset vertical class="ml-3 mr-6 grey" />

      <template #activator="{ attrs }">
        <v-btn x-small fab class="mr-3" text dark plain v-bind="attrs">
          <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>
      </template>

      <v-menu origin="center center" transition="scroll-y-transition" :nudge-bottom="10" offset-y>
        <template #activator="{ on, attrs }">
          <v-btn :loading="logoutLoader" x-small fab class="mr-3" text dark plain v-bind="attrs" v-on="on">
            <v-avatar size="33px">
              <v-img :src="user.avatar || 'storage/defaults/avatar.png'">
                <template #placeholder>
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
                {{ fullName }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item class="cursor-pointer" style="margin-top: -20px">
            <v-list-item-content>
              <v-list-item-title> {{ user.email }} </v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-divider />

          <v-list-item>
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
  </div>
</template>

<script>
  import axios from 'axios';
  import { call, sync } from 'vuex-pathify';
  import capitalize from 'lodash/capitalize';

  export default {
    name: 'SecureAppbar',

    data() {
      return {
        expand: false,
        imageLoadingFailed: false,
        notificationCount: 0,

        languages: [
          {
            flag: 'GB',
            name: 'English',
          },
          {
            flag: 'ES',
            name: 'Espanol',
          },
        ],

        settingsMenu: [
          {
            icon: 'mdi-arrow-expand',
            href: '/appconfig/general',
            title: 'Configuration',
            roles: [],
          },

          {
            icon: 'mdi-security',
            href: '/Entities',
            title: 'Users and Roles',
            roles: ['Admin', 'Root'],
          },

          {
            icon: 'mdi-puzzle-outline',
            href: '/Components',
            title: 'Components',
            roles: ['Root'],
          },

          {
            icon: 'mdi-database-search',
            href: '/SystemSettings/activitylogs',
            title: 'Logs',
            roles: ['Admin', 'Root'],
          },
        ],

        userMenu: [
          {
            icon: 'mdi-cogs',
            href: '/secure/config/general',
            title: 'Configuration',
            roles: [],
          },

          {
            icon: 'mdi-security',
            href: '/core/users',
            title: 'Users and Groups',
            roles: [],
          },
        ],

        miniVariant: false,
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      ...sync('application', ['search']),
      user: sync('authentication@session.user'),
      ...sync('drawers', ['secureDefaultDrawer']),
      ...sync('loaders', ['logoutLoader']),

      settingsMenuFiltered() {
        return this.settingsMenu.filter((menu) => menu.roles.includes(...this.$root.roles) || !menu.roles.length);
      },

      fullName() {
        return `${capitalize(this.user.entity.first_name)} ${capitalize(this.user.entity.last_name)} `;
      },

      routeTitle() {
        return this.$route.meta.title;
      },

      routeIcon() {
        return this.$route.meta.icon;
      },
    },

    methods: {
      ...call('authentication/*'),

      setTheme() {
        this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
        this.isDark = !this.isDark;
      },

      fetchNotificationCount() {
        axios.get('site/fetchNotificationCount').then((response) => {
          this.notificationCount = response.data.total;
        });
      },
    },
  };
</script>
<style scoped>
  .darkBorder {
    border-bottom: solid 1px #404859;
  }
</style>
