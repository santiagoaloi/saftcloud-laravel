<template>
  <v-list subheader>
    <v-subheader>Metadata</v-subheader>
    <v-list-item v-for="meta in metadata()" :key="meta.title">
      <v-list-item-icon>
        <v-icon v-once> {{ meta.icon }} </v-icon>
      </v-list-item-icon>

      <v-list-item-content>
        <v-list-item-title> {{ meta.title }} </v-list-item-title>
        <v-list-item-subtitle>
          {{ meta.subTitle }}
        </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>
  </v-list>
</template>

<script>
  import { get } from 'vuex-pathify';
  import moment from 'moment';

  export default {
    name: 'ModulesDrilldownMetadata',

    computed: {
      ...get('modulesManagement', ['selectedModule']),
    },

    methods: {
      metadata() {
        return [
          {
            icon: 'mdi-table',
            title: 'Table',
            subTitle: this.selectedModule.config.general_config.sql_table,
          },

          {
            icon: 'mdi-table-row',
            title: 'Fields',
            subTitle: this.selectedModule.config.columns.length,
          },

          {
            icon: 'mdi-calendar-plus',
            title: 'Created',
            subTitle: moment(this.selectedModule.created_at).format('lll'),
          },

          {
            icon: 'mdi-calendar-plus',
            title: 'Updated',
            subTitle: moment(this.selectedModule.updated_at).fromNow(),
          },
        ];
      },
    },
  };
</script>
