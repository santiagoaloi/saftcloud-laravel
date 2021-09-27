<template>
  <baseDialog
    v-model="internalValue"
    dense
    title="Icons"
    max-width="600"
    @save="() => (internalValue = false)"
    @close="() => (internalValue = false)"
  >
    <template>
      <v-card-text>
        <v-row>
          <v-col cols="8">
            <v-autocomplete
              v-model="icon.name"
              :items="items"
              hide-no-data
              hide-selected
              hide-details
              solo
              item-text="name"
              item-value="name"
              label="Search mdi icons..."
              :color="isDark ? 'white' : ''"
              :background-color="isDark ? '#28292b' : 'white'"
            >
              <template
                slot="selection"
                slot-scope="data"
              >
                <v-icon class="mr-3">
                  {{ data.item.name }}
                </v-icon>
                <span class="mr-2">{{ data.item.name }} </span>
              </template>

              <template #item="{ item, on }">
                <v-list-item
                  :ripple="false"
                  v-on="on"
                >
                  <v-list-item-avatar>
                    <v-icon>{{ item.name }}</v-icon>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-title> {{ item.name }} </v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </template>
            </v-autocomplete>
          </v-col>
          <v-col>
            <v-text-field
              v-model="icon.color"
              append-icon="mdi-palette-outline"
              solo
              hide-details
              :color="isDark ? 'white' : ''"
              :background-color="isDark ? '#28292b' : 'white'"
              @click:append="colorPicker = !colorPicker"
            />
          </v-col>
        </v-row>

        <base-dialog
          v-if="colorPicker"
          v-model="colorPicker"
          no-gutters
          no-maximize
          no-overlay
          dense
          width="300"
          save-only
          @save="() => (colorPicker = false)"
        >
          <v-card
            class="mx-auto"
            width="300"
          >
            <v-color-picker
              v-model="icon.color"
              flat
            />
          </v-card>
        </base-dialog>
      </v-card-text>
    </template>
  </baseDialog>
</template>
<script>
import axios from 'axios';
import { sync, get } from 'vuex-pathify';
import { store } from '@/store';

export default {
  name: 'DialogIcons',
  props: {
    value: {
      type: Boolean,
      default: false,
    },
    icon: {
      type: Object,
      default: {},
    },
  },

  data() {
    return {
      internalValue: this.value,
      isLoading: false,
      colorPicker: false,
      iconColor: '',
    };
  },

  computed: {
    ...sync('theme', ['isDark', 'icons']),

    items() {
      return this.icons.map((icon) => {
        const name = `mdi-${icon.name}`;
        return { ...icon, name };
      });
    },
  },

  watch: {
    internalValue(val, oldVal) {
      if (val === oldVal) return; // Don't do anything.
      this.$emit('input', val); // emit input change to v-model
    },

    value(val, oldVal) {
      if (val === oldVal) return;
      this.internalValue = val;
    },
  },

  mounted() {
    this.getIcons();
  },

  methods: {
    getIcons() {
      if (this.items.length) return;
      axios
        .get('api/listIcons')
        .then((response) => {
          store.set('theme/icons', response.data.icons);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
