<template>
  <div>
    <v-list class="pa-2 text-start" dark nav dense>
      <template v-for="(item, i) in menuItems">
        <div v-if="item.header" :key="i" class="pa-1 mt-2 overline">
          {{ item.header }}
        </div>
        <v-list-item
          v-else
          :key="i"
          active-class="primary--text text--lighten-5"
          :to="item.link"
          :disabled="item.disabled || hasValidationErrors"
          @click="entitiesEditDrawerActiveMenu = item.link"
        >
          <v-list-item-icon>
            <v-icon small :class="{ 'grey--text': item.disabled }">
              {{ item.icon || 'mdi-circle-medium' }}
            </v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title v-html="item.text" />
            <v-list-item-subtitle v-html="item.group" />
          </v-list-item-content>
        </v-list-item>
      </template>
    </v-list>
  </div>
</template>

<script>
  import { sync, get } from 'vuex-pathify';

  export default {
    name: 'EntitiesEditSheetMenu',
    data: () => ({
      menuItems: [{ header: 'User Settings' }, { icon: 'mdi-view-dashboard-outline', text: 'Basic', link: '/Entities/Basic' }],
    }),

    computed: {
      ...sync('entitiesManagement', ['entitiesEditSheet', 'entitiesEditDrawerActiveMenu']),
      ...get('entitiesManagement', ['hasValidationErrors']),
    },

    mounted() {
      if (!this.entitiesEditDrawerActiveMenu && this.$route.name !== '/Entities/Basic') {
        this.$router.push('/Entities/Basic');
      } else if (this.$route.name !== this.entitiesEditDrawerActiveMenu) {
        this.$router.push(this.entitiesEditDrawerActiveMenu);
      }
    },
  };
</script>
