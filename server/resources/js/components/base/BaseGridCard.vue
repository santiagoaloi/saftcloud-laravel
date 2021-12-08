<template>
  <v-hover v-slot="{ hover: hoverCard }" open-delay="500">
    <v-sheet
      :color="color || '#292c3b'"
      class="d-flex flex-column justify-space-between pa-4 hoverElevationSoft cursor-pointer rounded-lg"
      height="300"
      width="100%"
    >
      <v-card-actions class="px-0">
        <v-avatar size="90" :color="iconColor">
          <v-img v-if="!icon || !iconOnly" :src="avatar || `https://i.pravatar.cc/150?img=${index}`">
            <template #placeholder>
              <v-row class="fill-height ma-0" align="center" justify="center">
                <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
              </v-row>
            </template>
          </v-img>

          <v-icon v-if="iconOnly" size="40" dark>
            {{ icon }}
          </v-icon>
        </v-avatar>

        <v-spacer />

        <template v-if="!noActions">
          <div
            v-for="{ method, color, icon } in statusIcons"
            :key="icon"
            :class="{ 'show-btns': hoverCard, 'hide-btns': !hoverCard }"
          >
            <v-btn color="white" small icon :ripple="false" @click.native.stop="trigger(method, item)">
              <v-icon :color="trigger(color, item)">
                {{ trigger(icon, item) }}
              </v-icon>
            </v-btn>
          </div>
        </template>
      </v-card-actions>

      <span class="gallery-card-title pl-2">
        <template v-if="title">
          <h2>{{ title }}</h2>
        </template>
        <template v-else>
          <base-typing-indicator class="ml-n2" />
        </template>
      </span>

      <div v-if="$slots.footer" class="content">
        <div class="gallery-card-subtitle-container">
          <slot name="footer"> </slot>
        </div>
      </div>
    </v-sheet>
  </v-hover>
</template>

<script>
  import { sync } from 'vuex-pathify';

  export default {
    name: 'GridCard',
    props: {
      item: {
        type: [Object],
        default: () => {},
      },
      color: {
        type: [String],
        default: 'blue',
      },
      statusIcons: {
        type: [Array],
        default: () => [],
      },

      icon: {
        type: [String],
        default: () => null,
      },

      iconOnly: {
        type: [Boolean],
        default: () => false,
      },

      avatar: {
        type: [String],
        default: () => null,
      },

      iconColor: {
        type: [String],
        default: () => 'primary',
      },

      title: {
        type: [String],
        default: () => 'No Title...',
      },

      index: {
        type: [Number],
        default: () => 0,
      },

      methods: {
        type: [Object],
        default: () => {},
      },

      noActions: {
        type: [Boolean],
        default: () => false,
      },
    },

    computed: {
      ...sync('theme', ['isDark']),
    },

    methods: {
      // Executes a function with its argumentss
      trigger(fn, args) {
        return this.methods[fn](args);
      },
    },
  };
</script>
