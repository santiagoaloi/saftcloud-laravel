<template>
  <v-dialog
    v-model="internalValue"
    v-bind="$attrs"
    v-on="$listeners"
    :fullscreen="$vuetify.breakpoint.smAndDown || isMaximized"
    :transition="noTransition ? false : 'expand-transition'"
    :hide-overlay="noOverlay"
    :overlay-opacity="0.7"
    overlay-color="rgba(108, 122, 137)"
  >
    <v-toolbar ref="parentEl" class="popup-header px-6" flat dark color="#3E4042">
      <template>
        <v-btn
          v-if="$vuetify.breakpoint.mdAndUp"
          x-small
          color="white"
          outlined
          text
          fab
          class="ml-n3 mr-4"
          @click.stop="isMaximized = !isMaximized"
        >
          <v-icon>mdi-window-maximize</v-icon>
        </v-btn>
      </template>

      <v-toolbar-title>
        {{ title }}
      </v-toolbar-title>

      <div class="flex-grow-1" />

      <slot :parentData="$data" name="toolbar" />

      <template v-if="closeOnly && !noActions">
        <v-btn x-small color="white" outlined text fab class="mx-1" icon dark @click.stop="close">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </template>

      <template v-if="saveOnly">
        <v-btn fab small :loading="loading" icon dark @click.stop="save">
          <v-icon>mdi-check</v-icon>
        </v-btn>
      </template>

      <template v-if="showRemove">
        <v-btn x-small color="white" outlined text fab class="mx-1" icon dark :loading="loading" @click.stop="remove">
          <v-icon color="#00B985"> mdi-delete-empty-outline </v-icon>
        </v-btn>
      </template>

      <template v-if="!noActions">
        <v-btn
          v-if="!closeOnly"
          x-small
          color="white"
          outlined
          text
          fab
          class="mx-1"
          :loading="loading"
          @click.stop="save"
        >
          <v-icon color="#00B985"> mdi-check </v-icon>
        </v-btn>

        <v-btn v-if="!closeOnly" x-small color="white" outlined text fab icon dark class="ml-2" @click.stop="close">
          <v-icon color="white" small> mdi-close </v-icon>
        </v-btn>
      </template>
    </v-toolbar>
    <v-sheet color="primary" height="3" />
    <v-card id="scrollableContent" color="#f8f9fa" style="overflow: auto" flat tile :height="height">
      <slot />
    </v-card>

    <slot :parentData="$data" name="footer" />
  </v-dialog>
</template>

<script>
export default {
  name: "BaseDialog",

  inheritAttrs: false,
  props: {
    value: {
      type: [Boolean],
      default: false
    },
    title: {
      type: [String],
      default: ""
    },
    noActions: {
      type: [Boolean],
      default: false
    },
    noOverlay: {
      type: [Boolean],
      default: false
    },
    noTransition: {
      type: [Boolean],
      default: false
    },
    closeOnly: {
      type: [Boolean],
      default: false
    },
    saveOnly: {
      type: [Boolean],
      default: false
    },
    height: {
      type: [Boolean, String],
      default: null
    },
    showRemove: {
      type: [Boolean],
      default: false
    },
    loading: {
      type: [Boolean],
      default: false
    }
  },

  data() {
    return {
      internalValue: this.value,
      isMaximized: false
    };
  },

  watch: {
    internalValue(val, oldVal) {
      if (val === oldVal) return; // Don't do anything.
      this.$emit("input", val); // emit input change to v-model
    },

    value(val, oldVal) {
      if (val === oldVal) return;
      this.internalValue = val;
    }
  },

  mounted() {
    document.documentElement.style.setProperty("--blur", " blur(2px)");
  },

  beforeDestroy() {
    document.documentElement.style.setProperty("--blur", " blur(0px)");
  },

  methods: {
    scrollCardToTop() {
      var myDiv = document.getElementById("scrollableContent");
      myDiv.scrollTop = 0;
    },

    save() {
      this.$emit("save");
    },

    remove() {
      this.$emit("remove");
    },

    close() {
      this.$emit("close");
    }
  }
};
</script>
<style>
.v-application--wrap {
  filter: var(--blur);
}

.bottomColor {
  height: 3px;
  background: #0eb675;
}
</style>
