<template>
  <v-dialog
    v-model="showDialog"
    v-bind="$attrs"
    :fullscreen="$vuetify.breakpoint.smAndDown || isMaximized || fullscreen"
    :hide-overlay="noOverlay || fullscreen"
    :overlay-opacity="0.9"
    :overlay-color="$vuetify.theme.dark ? '#20202b' : 'rgba(108, 122, 137)'"
    scrollable
    class="d-flex flex-column"
    v-on="$listeners"
  >
    <v-toolbar src="storage/appbar/prism2.jpg" class="pr-3 select-none" flat :dense="dense" dark color="#36393f">
      <template v-if="icon">
        <v-btn x-small color="white" text fab class="mr-3 pointer-events-none">
          <v-icon>{{ icon }}</v-icon>
        </v-btn>
      </template>

      <v-toolbar-title>
        <h5 class="text--lighten-5">
          {{ title }}
        </h5>
      </v-toolbar-title>

      <div class="flex-grow-1" />

      <template v-if="closeOnly && !noActions">
        <v-btn x-small color="white" outlined text fab class="mx-1" icon dark @click.stop="close">
          <v-icon>{{ fullscreen ? 'mdi-chevron-down' : 'mdi-close' }}</v-icon>
        </v-btn>
      </template>

      <template v-if="saveOnly">
        <v-btn v-if="!closeOnly" x-small color="white" outlined text fab :loading="loading" @click.stop="save">
          <v-icon color="green lighten-2"> mdi-check </v-icon>
        </v-btn>
      </template>

      <template v-if="showRemove">
        <v-btn x-small color="white" outlined text fab class="mx-1" icon dark :loading="loading" @click.stop="remove">
          <v-icon color="#00B985"> mdi-delete-empty-outline </v-icon>
        </v-btn>
      </template>

      <template v-if="!noActions && !saveOnly">
        <v-btn v-if="!closeOnly" x-small color="white" outlined text fab class="mx-1" :loading="loading" @click.stop="save">
          <v-icon color="green lighten-2"> mdi-check </v-icon>
        </v-btn>

        <v-btn v-if="!closeOnly && !saveOnly" x-small color="white" outlined text fab icon dark class="ml-2" @click.stop="close">
          <v-icon>{{ fullscreen ? 'mdi-chevron-down' : 'mdi-close' }}</v-icon>
        </v-btn>
      </template>
    </v-toolbar>

    <slot name="top"> </slot>

    <v-card width="100%" :class="{ 'pa-2': !noGutters }" style="overflow: auto" flat tile>
      <v-container v-if="!noContainer" :fluid="fluid" :class="{ 'fill-height': filled }">
        <slot />
      </v-container>
      <template v-if="noContainer">
        <slot />
      </template>
    </v-card>
  </v-dialog>
</template>

<script>
  export default {
    name: 'BaseDialog',
    props: {
      value: {
        type: [Boolean],
        required: true,
        default: false,
      },

      icon: {
        type: [String],
        default: null,
      },

      filled: {
        type: [Boolean],
        default: false,
      },

      fluid: {
        type: [Boolean],
        default: false,
      },

      title: {
        type: [String],
        default: '',
      },

      absoluteToolbar: {
        type: [Boolean],
        default: false,
      },

      noActions: {
        type: [Boolean],
        default: false,
      },
      noOverlay: {
        type: [Boolean],
        default: false,
      },
      closeOnly: {
        type: [Boolean],
        default: false,
      },
      saveOnly: {
        type: [Boolean],
        default: false,
      },
      height: {
        type: [Boolean, String],
        default: null,
      },
      showRemove: {
        type: [Boolean],
        default: false,
      },
      noGutters: {
        type: [Boolean],
        default: false,
      },
      noMaximize: {
        type: [Boolean],
        default: false,
      },
      fullscreen: {
        type: [Boolean],
        default: false,
      },
      dense: {
        type: [Boolean],
        default: false,
      },
      loading: {
        type: [Boolean],
        default: false,
      },
      noContainer: {
        type: [Boolean],
        default: false,
      },
    },

    data() {
      return {
        isMaximized: false,
      };
    },

    computed: {
      showDialog() {
        return this.value;
      },
    },

    methods: {
      save() {
        this.$emit('save');
      },

      remove() {
        this.$emit('remove');
      },

      close() {
        this.$emit('close');
      },
    },
  };
</script>
