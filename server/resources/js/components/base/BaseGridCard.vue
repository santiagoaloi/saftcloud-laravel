<template>
  <v-item v-slot="{ toggle }" class="select-none">
    <v-hover v-slot="{ hover: hoverCard }" open-delay="500">
      <v-sheet
        class="cursor-pointer"
        height="300"
        width="100%"
        :color="isDark ? '#282c3b' : 'white'"
        @click.stop="toggle()"
        v-on="$listeners"
      >
        <v-card-actions class="px-0">
          <v-avatar size="80" :color="iconColor">
            <v-img :src="`https://i.pravatar.cc/150?img=${index}`">
              <template #placeholder>
                <v-row class="fill-height ma-0" align="center" justify="center">
                  <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                </v-row>
              </template>
            </v-img>

            <!-- <v-icon v-else size="40" dark>
              {{ icon }}
            </v-icon> -->
          </v-avatar>

          <v-spacer />

          <template v-if="!noActions">
            <div
              v-for="{ event, color, icon } in statusIcons"
              :key="icon"
              :class="{ 'show-btns': hoverCard, 'hide-btns': !hoverCard }"
            >
              <v-btn color="white" small icon :ripple="false" @click.native.stop="trigger(event, item)">
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
          <template v-else v>
            <base-typing-indicator class="ml-n2" />
          </template>
        </span>

        <div v-show="$slots.footer" class="content">
          <slot name="footer"> </slot>
        </div>
      </v-sheet>
    </v-hover>
  </v-item>
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
      statusIcons: {
        type: [Array],
        default: () => [],
      },

      icon: {
        type: [String],
        default: () => 'mdi-home',
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
        default: () => 1,
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
      trigger(fn, args) {
        return this.methods[fn](args);
      },
    },
  };
</script>
