<template>
  <v-app-bar class="bar select-none" clipped-right app elevation="5">
    <v-app-bar-nav-icon dark class="ml-n2 mr-3" text x-small fab @click="secureDefaultDrawer = !secureDefaultDrawer" />

    <baseAppbarTitle />

    <div class="flex-grow-1" />

    <baseAppbarSlot></baseAppbarSlot>

    <div class="flex-grow-1" />

    <baseSearchField />

    <v-tooltip transition="false" color="black" bottom>
      <template #activator="{ on }">
        <v-btn x-small fab class="mr-3" color="white" text dark plain v-on="on" @click="setTheme()">
          <v-icon v-if="isDark"> mdi-lightbulb-on-outline </v-icon>
          <v-icon v-else> mdi-lightbulb-outline </v-icon>
        </v-btn>
      </template>
      <span> {{ isDark ? ' Light mode' : 'Dark mode' }}</span>
    </v-tooltip>

    <v-menu origin="center center" transition="scroll-y-transition" :nudge-bottom="10" offset-y>
      <template #activator="{ on, attrs }">
        <v-btn x-small fab class="mr-3" text dark plain v-bind="attrs" v-on="on">
          <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>
      </template>
      <v-list outlined>
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
      <v-btn x-small fab class="mr-3" text dark plain @click="() => console.log('test')">
        <v-icon>mdi-bell-ring-outline</v-icon>
      </v-btn>
    </v-badge>

    <v-menu origin="center center" transition="scroll-y-transition" :nudge-bottom="10" offset-y>
      <template #activator="{ on, attrs }">
        <v-btn x-small fab class="mr-3" text dark plain v-bind="attrs" v-on="on">
          <v-icon>mdi-earth</v-icon>
        </v-btn>
      </template>
      <v-list link outlined>
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

    <v-divider inset vertical class="ml-3 mr-6 grey" />

    <template #activator="{ attrs }">
      <v-btn x-small fab class="mr-3" text dark plain v-bind="attrs">
        <v-icon>mdi-dots-vertical</v-icon>
      </v-btn>
    </template>

    <v-menu origin="center center" transition="scroll-y-reverse-transition" :nudge-bottom="10" offset-y>
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

      <v-list outlined>
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

        <!--           
      <v-btn x-small fab class="mr-3" text dark plain to="/Homepage">
        <v-icon>mdi-home-variant</v-icon>
      </v-btn>
       -->

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
  import { call, sync } from 'vuex-pathify';
  import capitalize from 'lodash/capitalize';

  export default {
    name: 'SecureAppbar',

    data() {
      return {
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
            icon: 'mdi-key-chain-variant',
            href: '',
            title: 'Global Privileges',
            roles: ['Root'],
          },

          {
            icon: 'mdi-puzzle-outline',
            href: '/Modules',
            title: 'Modules',
            roles: ['Root'],
          },

          {
            icon: 'mdi-database-search',
            href: '/SystemSettings/activitylogs',
            title: 'Logs',
            roles: ['Admin', 'Root'],
          },
        ],
      };
    },

    computed: {
      ...sync('theme', ['isDark']),
      user: sync('authentication@session.user'),
      ...sync('drawers', ['secureDefaultDrawer']),
      ...sync('loaders', ['logoutLoader']),

      settingsMenuFiltered() {
        return this.settingsMenu.filter((menu) => menu.roles.includes(...this.$root.roles) || !menu.roles.length);
      },

      fullName() {
        return `${capitalize(this.user.entity.first_name)} ${capitalize(this.user.entity.last_name)} `;
      },
    },

    methods: {
      ...call('authentication/*'),

      setTheme() {
        this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
        this.isDark = !this.isDark;
      },
    },
  };
</script>
<style scoped></style>
