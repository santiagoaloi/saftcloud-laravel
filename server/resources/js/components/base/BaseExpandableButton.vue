<template>
  <div :style="`z-index: ${zIndex};width: ${width}`">
    <v-overlay v-if="value" :z-index="0" :opacity="0.9" color="#20202b" @click="internalValue = false" />
    <v-sheet>
      <v-list color="#222530e6">
        <v-list-item :ripple="false" @click="internalValue = !internalValue">
          <v-list-item-avatar>
            <v-icon>{{ icon }}</v-icon>
          </v-list-item-avatar>

          <v-list-item-content>
            <div style="max-width: 110px">
              <v-list-item-title class="indigo--text text--lighten-2">{{ title }}</v-list-item-title>
              <v-list-item-subtitle>{{ subtitle }}</v-list-item-subtitle>
            </div>
          </v-list-item-content>

          <v-list-item-icon v-if="!hideIcon">
            <v-icon right :class="{ iconActive: internalValue }"> mdi-chevron-up </v-icon>
          </v-list-item-icon>
        </v-list-item>
      </v-list>
    </v-sheet>

    <v-expand-transition>
      <base-flex-container v-show="internalValue" :width="width" :top="nudgeTop">
        <template #top>
          <slot name="listTop"> </slot>
        </template>
        <slot></slot>
      </base-flex-container>
    </v-expand-transition>
  </div>
</template>

<script>
  export default {
    name: 'ExpandableButton',
    props: {
      value: {
        type: [Boolean],
        default: false,
      },
      width: {
        type: [String],
        default: () => '100%',
      },
      icon: {
        type: [String],
        default: () => 'mdi-home',
      },
      title: {
        type: [String],
        default: () => 'Title',
      },
      subtitle: {
        type: [String],
        default: () => 'Subtitle',
      },
      nudgeTop: {
        type: [Number],
        default: () => 0,
      },

      zIndex: {
        type: [Number],
        default: () => 99,
      },
      hideIcon: {
        type: [Boolean],
        default: () => false,
      },
    },
    data() {
      return {
        internalValue: this.value,
      };
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
  };
</script>
<style scoped>
  .iconActive {
    transform: rotate(180deg);
  }
</style>
