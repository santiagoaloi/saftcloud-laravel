<template>
  <div>
    <capabilities-appbar class="mt-2" />
    <v-data-table :headers="headers" :items="selectedComponent.capabilities">
      <template #[`item.options`]="{ item }">
        <v-tooltip transition="false" color="black" bottom>
          <template #activator="{ on }">
            <v-btn color="white" small icon :ripple="false" @click="edit(item)" v-on="on">
              <v-icon> mdi-pencil </v-icon>
            </v-btn>
          </template>
          <span>Edit</span>
        </v-tooltip>

        <v-tooltip transition="false" color="black" bottom>
          <template #activator="{ on }">
            <v-btn
              class="ml-3"
              color="white"
              small
              icon
              :ripple="false"
              @click="remove(item)"
              v-on="on"
            >
              <v-icon> mdi-delete </v-icon>
            </v-btn>
          </template>
          <span>Remove</span>
        </v-tooltip>
      </template>
    </v-data-table>
    <DialogCapability />
  </div>
</template>

<script>
  import { sync, get, call } from 'vuex-pathify';
  import DialogCapability from './DialogCapability';
  import { store } from '@/store';

  export default {
    name: 'ComponentsEditViewsCapabilities',
    components: {
      CapabilitiesAppbar: () => import('./CapabilitiesAppbar'),
      DialogCapability,
    },
    data() {
      return {
        dialogIcons: false,

        headers: [
          {
            text: 'Name',
            align: 'start',
            value: 'name',
          },
          {
            text: 'Description',
            align: 'start',
            value: 'description',
          },

          {
            text: '',
            align: 'end',
            value: 'options',
          },
        ],
      };
    },
    computed: {
      ...sync('theme', ['isDark']),
      ...get('componentManagement', ['selectedComponent']),
      ...sync('componentManagement', ['dialogCapability']),
    },

    methods: {
      ...call('componentManagement/*'),

      edit(item) {
        this.dialogCapability = true;
        this.editCapability(item);
      },

      remove(capability) {
        this.removeCapability(capability).then((removed) => {
          if (removed) {
            this.selectedComponent.capabilities = this.selectedComponent.capabilities.filter(
              (item) => item.id !== capability.id,
            );
          }
        });
      },
    },
  };
</script>

<style scoped>
  .v-card--reveal {
    align-items: center;
    bottom: 0;
    justify-content: center;
    opacity: 0.5;
    position: absolute;
    width: 100%;
  }
</style>
